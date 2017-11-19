<?php

namespace Podlatch\PublisherFrontendBundle\Controller;

use Podlatch\PublisherCoreBundle\Entity\PodcastShow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Tests\Controller\ContainerAwareController;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublisherFrontendBundle:Default:index.html.twig');
    }

    public function feedAction($id)
    {
        /**
         * @var $podCast PodcastShow
         */
        $podCast = $this -> getDoctrine() -> getRepository(
            PodcastShow::class
        ) -> findOneBy(['id' => $id]);

        $xml = new \DOMDocument();
        $root = $xml->appendChild($xml->createElement('rss'));
        $root-> setAttribute('xmlns:itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd');

        $channel = $root->appendChild($xml->createElement('channel'));

        $channel->appendChild($xml->createElement('title', $podcast -> getTitle()));
        $channel->appendChild($xml->createElement('link', $podCast -> getUrl()));
        $channel->appendChild($xml->createElement('generator', 'Podlatch Podcast Publisher'));
        $channel->appendChild($xml->createElement('language', $podCast -> getLanguage()));

        foreach ($podCast -> getEpisodes() as $episode){

            $audioPath = sprintf(
                '%s%s%s',
                $this -> getParameter('kernel.root_dir'),
                $this -> getParameter('app.path.audio_assets'),
                $episode -> getAudioFile()
            );
            /**
             * @TODO get url here
             */
            $audioUrl = sprintf(
                '%s://%s%s%s',
                'https',
                'url',
                $this -> getParameter('app.path.audio_assets'),
                $episode -> getAudioFile()
            );

            $item = $channel->appendChild($xml->createElement('item'));
            $item->appendChild($xml->createElement('title', $episode -> getTitle()));
            $item->appendChild($xml->createElement('link', $audioUrl));
            $item->appendChild($xml->createElement('itunes:author', $podCast -> getAuthor()));
            $item->appendChild($xml->createElement('itunes:summary', $episode -> getSummary()));
            $item->appendChild($xml->createElement('guid', $audioUrl));
            $item->appendChild($xml->createElement('pubDate',
                date('D, d M Y H:i:s O', $episode ->getUpdatedAt())
            ));

            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

            $enclosure = $item->appendChild($xml->createElement('enclosure'));
            $enclosure->setAttribute('url', $audioPath);
            $enclosure->setAttribute('length', filesize($audioPath));
            $enclosure->setAttribute('type', finfo_file($fileInfo, $audioPath));
            /**
             * @TODO get duration from file here
             */
            $item->appendChild($xml->createElement('itunes:duration', '00:00'));

        }

    }

}
