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

namespace App\Entity;


use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Repository\PodcastEpisodeRepository;
use Symfony\Component\Validator\Constraints\Valid;use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\PodcastShowRepository")
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

    private $subtitle;
    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $author;

    /**
     * @ORM\Column(type="string")
     */
    private $ownerName;

    /**
     * @ORM\Column(type="string")
     */
    private $ownerMail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isExplicit;
    /**
     * @ORM\Column(type="string")
     */
    private $copyright;

    /**
     * @var string
     *
     * @ORM\Column(name="showType", type="string", length=255)
     */
    private $showType;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string")
     */
    private $category;

    /**
     * @ORM\Column(type="string")
     */
    private $language;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $itunesUrl;


    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $visibleInWebsite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PodcastEpisode", mappedBy="podcastShow")
     * @ORM\OrderBy({"releasedAt" = "DESC"})
     */
    private $episodes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="podcastShow")
     */
    private $pages;

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
     * Many Users have Many Podcasts.
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="podcasts")
     */
    private $users;

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return PodcastEpisode[]
     */
    public function getPublishedEpisodes()
    {
        return $this->getEpisodes()->filter(function(PodcastEpisode $episode) {
            return $episode->getPublished() == true AND $episode->getReleasedAt()->getTimestamp() <= time();
        });
    }
    /**
     * @param mixed $episodes
     */
    public function setEpisodes($episodes)
    {

        $this->episodes = $episodes;
    }

    public function getPages()
    {

        return $this->pages;
    }

    public function setPages($pages)
    {

        $this->pages = $pages;
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
        $this->setSlug((new Slugify())->slugify($this->getTitle()));
        $this->updatedAt = new \DateTime('now');
    }

    public function __toString()
    {
        return $this -> title;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {

        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {

        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {

        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {

        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getOwnerName()
    {

        return $this->ownerName;
    }

    /**
     * @param mixed $ownerName
     */
    public function setOwnerName($ownerName)
    {

        $this->ownerName = $ownerName;
    }

    /**
     * @return mixed
     */
    public function getOwnerMail()
    {

        return $this->ownerMail;
    }

    /**
     * @param mixed $ownerMail
     */
    public function setOwnerMail($ownerMail)
    {

        $this->ownerMail = $ownerMail;
    }

    /**
     * @return mixed
     */
    public function getisExplicit()
    {

        return $this->isExplicit;
    }

    /**
     * @param mixed $isExplicit
     */
    public function setIsExplicit($isExplicit)
    {

        $this->isExplicit = $isExplicit;
    }

    /**
     * @return mixed
     */
    public function getCopyright()
    {

        return $this->copyright;
    }

    /**
     * @param mixed $copyright
     */
    public function setCopyright($copyright)
    {

        $this->copyright = $copyright;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {

        return $this->users;
    }


    public function addUser(User $users)
    {

        $this->users[] = $users;
        if (!$users->getPodcasts()->contains($this)) {
            $users->addPodcast($this);
        }

        return $this;
    }

    public function removeUser(User $users)
    {
        $this->users->removeElement($users);
        if ($users->getPodcasts()->contains($this)) {
            $users->removePodcast($this);
        }


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
     * @return mixed
     */
    public function getItunesUrl()
    {

        return $this->itunesUrl;
    }

    /**
     * @param mixed $itunesUrl
     */
    public function setItunesUrl($itunesUrl)
    {

        $this->itunesUrl = $itunesUrl;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {

        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {

        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getShowType()
    {

        return $this->showType;
    }

    /**
     * @param string $showType
     */
    public function setShowType($showType)
    {

        $this->showType = $showType;
    }

    /**
     * @return bool
     */
    public function getVisibleInWebsite()
    {

        return (bool)$this->visibleInWebsite;
    }

    /**
     * @param mixed $visibleInWebsite
     */
    public function setVisibleInWebsite($visibleInWebsite)
    {

        $this->visibleInWebsite = $visibleInWebsite;
    }



















}
