<?php
/**
 * Show.php
 *
 * Made with <3 with PhpStorm
 * @author kampfq
 * @copyright 2017 Benjamin Issleib
 * @license    NO LICENSE AVAILIABLE
 * @see
 * @since      File available since Release
 * @deprecated File deprecated in Release
 */

namespace Podlatch\PublisherBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Podlatch\PublisherBundle\Repository\PodcastShowRepository")
 * @ORM\Table(name="podcast_show")
 */
class PodcastShow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string")
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Podlatch\PublisherBundle\Entity\PodcastEpisode", mappedBy="podcastShow")
     */
    private $episodes;

    /**
     * @return mixed
     */
    public function getAuthor()
    {

        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {

        $this->author = $author;
    }



    /**
     * @return mixed
     */
    public function getEpisodes()
    {

        return $this->episodes;
    }

    /**
     * @param mixed $episodes
     */
    public function setEpisodes($episodes)
    {

        $this->episodes = $episodes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {

        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {

        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {

        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {

        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {

        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {

        $this->picture = $picture;
    }

    public function __toString()
    {
        return $this -> title;
    }

}