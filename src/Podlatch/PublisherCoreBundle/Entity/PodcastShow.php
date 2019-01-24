<?php
/**
 * Copyright (c) Benjamin Issleib 2017.
 * This file is part of the Podlatch Podcast Publisher.
 * Podlatch Podcast Publisher is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * Podlatch Podcast Publisher is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with the Podlatch Podcast Publisher. If not, see http://www.gnu.org/licenses/.
 */
/**
 * Show.php
 *
 * Made with <3 with PhpStorm
 * @author Benjamin Issleib
 * @copyright 2017 Benjamin Issleib
 * @license    GPLv3
 * @see
 * @since      File available since Release
 * @deprecated File deprecated in Release
 */

namespace Podlatch\PublisherCoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Podlatch\PublisherCoreBundle\Repository\PodcastEpisodeRepository;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="Podlatch\PublisherCoreBundle\Repository\PodcastShowRepository")
 * @ORM\Table(name="podcast_show")
 */
class PodcastShow
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
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Podlatch\PublisherCoreBundle\Entity\PodcastEpisode", mappedBy="podcastShow")
     */
    private $episodes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="podcast_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

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
     * @return PodcastEpisode[]
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
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function __toString()
    {
        return $this -> title;
    }

}