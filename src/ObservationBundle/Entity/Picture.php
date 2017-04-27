<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\PictureRepository")
 */
class Picture
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\Birds", inversedBy="picture")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bird;

    /**
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\Observation", inversedBy="observation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $observation;


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
     * Set url
     *
     * @param string $url
     *
     * @return Picture
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Picture
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set bird
     *
     * @param \ObservationBundle\Entity\Birds $bird
     *
     * @return Picture
     */
    public function setBird(\ObservationBundle\Entity\Birds $bird)
    {
        $this->bird = $bird;

        return $this;
    }

    /**
     * Get bird
     *
     * @return \ObservationBundle\Entity\Birds
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * Set observation
     *
     * @param \ObservationBundle\Entity\Observation $observation
     *
     * @return Picture
     */
    public function setObservation(\ObservationBundle\Entity\Observation $observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return \ObservationBundle\Entity\Observation
     */
    public function getObservation()
    {
        return $this->observation;
    }
}
