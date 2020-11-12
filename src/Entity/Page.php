<?php

namespace App\Entity;

use Orbitale\Bundle\CmsBundle\Entity\Page as BasePage;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Orbitale\Bundle\CmsBundle\Repository\PageRepository")
 * @ORM\Table(name="orbitale_cms_pages")
 */
class Page extends BasePage
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PodcastShow", inversedBy="pages")
     * @ORM\JoinColumn(name="podcast_show_id", referencedColumnName="id", nullable=false)
     * @Assert\Valid()
     */
    private $podcastShow;

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
}
