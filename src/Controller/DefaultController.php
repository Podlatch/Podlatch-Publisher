<?php

namespace App\Controller;

use App\Entity\PodcastShow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
	public function indexAction($podcastId)
	{

		$podcast = $this->getDoctrine()->getRepository(
			PodcastShow::class
		)->findOneBy(['slug' => $podcastId]);

		if (!$podcast) {
			$podcast = $this->getDoctrine()->getRepository(
				PodcastShow::class
			)->findOneBy(['id' => $podcastId]);
		}

		$audioBasePath = sprintf(
			'%s%s',
			$this->getParameter('kernel.root_dir') . '/../web',
			$this->getParameter('app.path.audio_assets')
		);

		return $this->render(
			'PublisherFrontendBundle:Default:index.html.twig',
			[
				'audioBasePath' => $audioBasePath,
				'podcast' => $podcast
			]
		);
	}

	public function dashboardAction()
	{
		$podcasts = $this->getDoctrine()->getRepository(
			PodcastShow::class
		)->findAll();
		return $this->render(
			'PublisherFrontendBundle:Default:dashboard.html.twig',
			[
				'podcasts' => $podcasts
			]
		);
	}

	public function feedAction($podcastId = null)
	{
		/**
		 * @var $podCast PodcastShow
		 */

		$podCast = $this->getDoctrine()->getRepository(
			PodcastShow::class
		)->findOneBy(['slug' => $podcastId]);

		if (!$podCast) {
			$podCast = $this->getDoctrine()->getRepository(
				PodcastShow::class
			)->findOneBy(['id' => $podcastId]);
		}

		$xml = new \DOMDocument();
		$root = $xml->appendChild($xml->createElement('rss'));

		$root->setAttribute('xmlns:itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd');
		$root->setAttribute('version', "2.0");

		$channel = $root->appendChild($xml->createElement('channel'));

		$channel->appendChild($xml->createElement('title', $podCast->getTitle()));
		$channel->appendChild($xml->createElement('itunes:subtitle', $podCast->getSubtitle()));

		$descriptionNode = $xml->createElement('description', '');
		$channel->appendChild($descriptionNode)->appendChild($xml->createCDATASection(nl2br($podCast->getDescription())));
		$channel->appendChild($xml->createElement('language', $podCast->getLanguage()));

		/**
		 * @TODO implement url
		 */
		//$channel->appendChild($xml->createElement('link', $podCast -> getUrl()));
		$channel->appendChild($xml->createElement('generator', 'Podlatch Podcast Publisher - https://podlat.ch'));
		$channel->appendChild($xml->createElement('itunes:author', $podCast->getAuthor()));

		if ($podCast->getDescription()) {
			$channel->appendChild($xml->createElement('itunes:summary', $podCast->getDescription()));
		}

		$channel->appendChild($xml->createElement('itunes:type', $podCast->getShowType() ?: 'episodic'));

		$categories = explode(':', $podCast->getCategory());
		foreach ($categories as $category) {
			$element = $xml->createElement('itunes:category', '');
			$element->setAttribute('text', $category);
			$channel->appendChild($element);
		}

		if ($podCast->getImage()) {
			$pictureUrl = sprintf(
				'%s%s%s',
				$this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
				$this->getParameter('app.path.podcast_images'),
				$podCast->getImage()
			);
			$pictureUrl = $pictureUrl;

			$element = $xml->createElement('itunes:image', '');
			$element->setAttribute('href', $pictureUrl);
			$channel->appendChild($element);
		}


		$channel->appendChild($xml->createElement('itunes:explicit', $podCast->getisExplicit() ? 'Yes' : 'No'));


		$item = $channel->appendChild($xml->createElement('itunes:owner'));
		$item->appendChild($xml->createElement('itunes:name', $podCast->getOwnerName()));
		$item->appendChild($xml->createElement('itunes:email', $podCast->getOwnerMail()));

		$channel->appendChild($xml->createElement('copyright', $podCast->getCopyright()));
		$channel->appendChild(
			$xml->createElement(
				'link',
				$this->generateUrl('publisher_frontend_podcast_overview', [
					'podcastId' => $podCast->getSlug()
				], UrlGeneratorInterface::ABSOLUTE_URL)
			)
		);

		/**
		 * @TODO implement language
		 */
		//$channel->appendChild($xml->createElement('language', $podCast -> getLanguage()));


		foreach ($podCast->getPublishedEpisodes() as $episode) {

			$audioPath = sprintf(
				'%s%s%s',
				$this->getParameter('kernel.root_dir') . '/../web',
				$this->getParameter('app.path.audio_assets'),
				$episode->getAudio()
			);
			/**
			 * @TODO get url here
			 */
			$audioUrl = sprintf(
				'%s%s%s',
				$this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
				$this->getParameter('app.path.audio_assets'),
				$episode->getAudio()
			);


			$item = $channel->appendChild($xml->createElement('item'));
			$item->appendChild($xml->createElement('itunes:episodeType', $episode->getEpisodeType() ?: 'full'));
			$item->appendChild($xml->createElement('itunes:title', $episode->getTitle()));

			$item->appendChild($xml->createElement('title', $episode->getTitle()));
			$item->appendChild($xml->createElement('itunes:subtitle', $episode->getSubtitle()));

			$item->appendChild($xml->createElement('itunes:episode', $episode->getTitle()));
			$item->appendChild($xml->createElement('itunes:season', $episode->getEpisodeSeason()));


			$item->appendChild($xml->createElement('link', $audioUrl));
			$item->appendChild($xml->createElement('itunes:author', $podCast->getAuthor()));
			if ($episode->getSummary()) {
				$item->appendChild($xml->createElement('itunes:summary', $episode->getSummary()));
				$descriptionNode = $xml->createElement('description', '');
				$item->appendChild($descriptionNode)->appendChild($xml->createCDATASection(nl2br($episode->getSummary())));
			}
			$item->appendChild($xml->createElement('guid', $episode->getId()));
			$item->appendChild($xml->createElement('pubDate',
				date('D, d M Y H:i:s O', $episode->getReleasedAt()->getTimestamp())
			));

			if ($episode->getImage()) {
				$pictureUrl = sprintf(
					'%s%s%s',
					$this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
					$this->getParameter('app.path.episode_images'),
					$episode->getImage()
				);
				$pictureUrl = $pictureUrl;

				$element = $xml->createElement('itunes:image', '');
				$element->setAttribute('href', $pictureUrl);
				$item->appendChild($element);
			}

			if ($episode->getAudio()) {
				$fileInfo = finfo_open(FILEINFO_MIME_TYPE);

				$enclosure = $item->appendChild($xml->createElement('enclosure'));
				$enclosure->setAttribute('url', $audioUrl);
				$enclosure->setAttribute('length', filesize($audioPath));
				$enclosure->setAttribute('type', finfo_file($fileInfo, $audioPath));
				$getID3 = new \getID3();
				$fileInfo = $getID3->analyze($audioPath);
				if (array_key_exists('playtime_string', $fileInfo)) {
					$item->appendChild($xml->createElement('itunes:duration', $fileInfo['playtime_string']));
				}
			}

		}
		$xml->formatOutput = true;
		$response = new Response($xml->saveXML());
		$response->headers->set('Content-Type', 'text/xml');
		return $response;
	}


}
