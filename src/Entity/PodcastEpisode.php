<?php
/**
 * Copyright (c) Benjamin Issleib 2017.
 * This file is part of the Podlatch Podcast Publisher.
 * Podlatch Podcast Publisher is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * Podlatch Podcast Publisher is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with the Podlatch Podcast Publisher. If not, see http://www.gnu.org/licenses/.
 */
namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * PodcastEpisode
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="podcast_episode")
 * @ORM\Entity(repositoryClass="Podlatch\PublisherCoreBundle\Repository\PodcastEpisodeRepository")
 * @Vich\Uploadable
 */
class PodcastEpisode
{

    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid_binary_ordered_time", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="episodeNumber", type="integer",)
     */
    private $episodeNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="episodeSeason", type="integer", options={"default" : 1})
     */
    private $episodeSeason;

    /**
     * @var string
     *
     * @ORM\Column(name="episodeType", type="string", length=255)
     */
    private $episodeType;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255,)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="text", nullable=true)
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
     * @ORM\JoinColumn(name="podcast_show_id", referencedColumnName="id", nullable=false)
     * @Assert\Valid()
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
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $published;


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

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function getDuration($basePath)
    {
        $returnValue = '';

        if($this->getAudio()){
            $audioPath = $basePath . $this->getAudio();
            $getID3 = new \getID3();
            $fileInfo = $getID3->analyze($audioPath);
            if (array_key_exists('playtime_string',$fileInfo)) {
                $returnValue = $fileInfo['playtime_string'];
            }
        }
        return $returnValue;


    }

    public function getFileSize($basePath)
    {
        $audioPath = $basePath . $this->getAudio();
        return filesize($audioPath);
    }


    /**
     * @return mixed
     */
    public function getSubtitle()
    {

        return $this->subtitle;
    }

    /**
     * @param mixed $subtitle
     */
    public function setSubtitle($subtitle)
    {

        $this->subtitle = $subtitle;
    }

    /**
     * @return string
     */
    public function getEpisodeNumber()
    {

        return $this->episodeNumber;
    }

    /**
     * @param string $episodeNumber
     */
    public function setEpisodeNumber($episodeNumber)
    {

        $this->episodeNumber = $episodeNumber;
    }

    /**
     * @return string
     */
    public function getEpisodeType()
    {

        return $this->episodeType;
    }

    /**
     * @param string $episodeType
     */
    public function setEpisodeType($episodeType)
    {

        $this->episodeType = $episodeType;
    }

    /**
     * @return string
     */
    public function getEpisodeSeason()
    {

        return $this->episodeSeason;
    }

    /**
     * @param string $episodeSeason
     */
    public function setEpisodeSeason($episodeSeason)
    {

        $this->episodeSeason = $episodeSeason;
    }

    /**
     * @return bool
     */
    public function getPublished()
    {

        return (bool)$this->published;
    }

    /**
     * @param mixed $published
     */
    public function setPublished($published)
    {

        $this->published = $published;
    }









}

