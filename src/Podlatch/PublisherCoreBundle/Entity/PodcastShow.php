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

namespace Podlatch\PublisherCoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="Podlatch\PublisherCoreBundle\Repository\PodcastShowRepository")
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


    public function __toString()
    {
        return $this -> title;
    }

}