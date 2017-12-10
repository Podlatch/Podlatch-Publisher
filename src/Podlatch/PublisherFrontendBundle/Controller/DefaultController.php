<?php

namespace Podlatch\PublisherFrontendBundle\Controller;

use GetId3\GetId3Core;
use Podlatch\PublisherCoreBundle\Entity\PodcastShow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublisherFrontendBundle:Default:index.html.twig');
    }

    public function feedAction($id=null)
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

        $channel->appendChild($xml->createElement('title', $podCast -> getTitle()));
        /**
         * @TODO implement url
         */
        //$channel->appendChild($xml->createElement('link', $podCast -> getUrl()));
        $channel->appendChild($xml->createElement('generator', 'Podlatch Podcast Publisher - https://podlat.ch'));
        /**
         * @TODO implement language
         */
        //$channel->appendChild($xml->createElement('language', $podCast -> getLanguage()));

        foreach ($podCast -> getEpisodes() as $episode){

            $audioPath = sprintf(
                '%s%s%s',
                $this -> getParameter('kernel.root_dir').'/../web',
                $this -> getParameter('app.path.audio_assets'),
                $episode -> getAudio()
            );
            /**
             * @TODO get url here
             */
            $audioUrl = sprintf(
                '%s://%s%s%s',
                'https',
                'url',
                $this -> getParameter('app.path.audio_assets'),
                $episode -> getAudio()
            );

            $item = $channel->appendChild($xml->createElement('item'));
            $item->appendChild($xml->createElement('title', $episode -> getTitle()));
            $item->appendChild($xml->createElement('link', $audioUrl));
            $item->appendChild($xml->createElement('itunes:author', $podCast -> getAuthor()));
            $item->appendChild($xml->createElement('itunes:summary', $episode -> getSummary()));
            $item->appendChild($xml->createElement('guid', $audioUrl));
            $item->appendChild($xml->createElement('pubDate',
                date('D, d M Y H:i:s O', $episode ->getUpdatedAt() ->getTimestamp())
            ));

            if($episode -> getAudio()){
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

                $enclosure = $item->appendChild($xml->createElement('enclosure'));
                $enclosure->setAttribute('url', $audioUrl);
                $enclosure->setAttribute('length', filesize($audioPath));
                $enclosure->setAttribute('type', finfo_file($fileInfo, $audioPath));
                $getID3 = new GetId3Core();
                $fileInfo = $getID3->analyze($audioPath);
                $item->appendChild($xml->createElement('itunes:duration', $fileInfo['playtime_string']));
            }

        }
        $xml->formatOutput = true;
        $response = new Response($xml -> saveXML());
        $response->headers->set('Content-Type', 'xml');
        return $response;
    }

    public function EpisodeListAction($id=null){

    }

}
