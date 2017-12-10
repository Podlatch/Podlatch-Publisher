<?php
/**
 * Copyright (c) Benjamin Issleib 2017.
 * This file is part of the Podlatch Podcast Publisher.
 * Podlatch Podcast Publisher is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * Podlatch Podcast Publisher is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with the Podlatch Podcast Publisher. If not, see http://www.gnu.org/licenses/.
 */
namespace Podlatch\PublisherCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * PodcastEpisode
 *
 * @ORM\Table(name="podcast_episode")
 * @ORM\Entity(repositoryClass="Podlatch\PublisherCoreBundle\Repository\PodcastEpisodeRepository")
 * @Vich\Uploadable
 */
class PodcastEpisode
{

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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $audio;

    /**
     * @Vich\UploadableField(mapping="audio_assets", fileNameProperty="audio")
     * @var File
     */
    private $audioFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="episode_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\ManyToOne(targetEntity="Podlatch\PublisherCoreBundle\Entity\PodcastShow", inversedBy="episodes")
     * @ORM\JoinColumn(name="podcast_show_id", referencedColumnName="id")
     */
    private $podcastShow;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $releasedAt;
    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;


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

    /**
     * @return mixed
     */
    public function getSummary()
    {

        return $this->summary;
    }

    /**
     * @param mixed $summary
     */
    public function setSummary($summary)
    {

        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getAudioFile()
    {

        return $this->audioFile;
    }

    /**
     * @param mixed $audioFile
     */
    public function setAudioFile($audioFile)
    {
        if ($audioFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }

        $this->audioFile = $audioFile;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {

        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {

        $this->image = $image;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile)
    {
        if ($imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }

        $this->imageFile = $imageFile;
    }



    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {

        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {

        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getAudio()
    {

        return $this->audio;
    }

    /**
     * @param string $audio
     */
    public function setAudio($audio)
    {

        $this->audio = $audio;
    }

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
     * @return \DateTime
     */
    public function getReleasedAt()
    {

        return $this->releasedAt;
    }

    /**
     * @param \DateTime $releasedAt
     */
    public function setReleasedAt($releasedAt)
    {

        $this->releasedAt = $releasedAt;
    }





}

