<?php

namespace Podlatch\PublisherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PodcastEpisode
 *
 * @ORM\Table(name="podcast_episode")
 * @ORM\Entity(repositoryClass="Podlatch\PublisherBundle\Repository\PodcastEpisodeRepository")
 */
class PodcastEpisode
{
    /**
     * @return mixed
     */
    public function getPodcastShow()
    {

        return $this->podcastShow;
    }

    /**
     * @param mixed $podcastShow
     */
    public function setPodcastShow($podcastShow)
    {

        $this->podcastShow = $podcastShow;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255,)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255,nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;


    /**
     * @ORM\ManyToOne(targetEntity="Podlatch\PublisherBundle\Entity\PodcastShow", inversedBy="episodes")
     * @ORM\JoinColumn(name="podcast_show_id", referencedColumnName="id")
     */
    private $podcastShow;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return PodcastEpisode
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PodcastEpisode
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return PodcastEpisode
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function __toString()
    {
        return $this -> title;
    }
}

