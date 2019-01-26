<?php
/**
 * Copyright (c) Benjamin Issleib 2017.
 * This file is part of the Podlatch Podcast Publisher.
 * Podlatch Podcast Publisher is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * Podlatch Podcast Publisher is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with the Podlatch Podcast Publisher. If not, see http://www.gnu.org/licenses/.
 */
namespace Podlatch\PublisherBackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Podlatch\PublisherCoreBundle\Entity\PodcastShow;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Podlatch\PublisherBackendBundle\Repository\UserRepository")
 */
class User  extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection|PodcastShow[]
     *
     * @ORM\ManyToMany(targetEntity="Podlatch\PublisherCoreBundle\Entity\PodcastShow", inversedBy="users")
     * @ORM\JoinTable(
     *  name="users_podcasts",
     *  joinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="podcast_show_id", referencedColumnName="id")
     *  }
     * )
     */
    private $podcasts;

    public function __construct() {
        $this->podcasts = new \Doctrine\Common\Collections\ArrayCollection();
        parent::__construct();
    }


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
     * @return mixed
     */
    public function getPodcasts()
    {

        return $this->podcasts;
    }

    public function addPodcast(PodcastShow $podcasts)
    {

        $this->podcasts[] = $podcasts;
        if (!$podcasts->getUsers()->contains($this)) {
            $podcasts->addUser($this);
        }

        return $this;
    }

    public function removePodcast(PodcastShow $podcasts)
    {
        $this->podcasts->removeElement($podcasts);
        if ($podcasts->getUsers()->contains($this)){
            $podcasts->removeUser($this);
        }


    }



}

