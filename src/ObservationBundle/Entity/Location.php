<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\LocationRepository")
 */
class Location
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
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=10)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="Longitude", type="decimal", precision=10, scale=10)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="text")
     */
    private $lieu;

    /**
     * @ORM\ManyToMany(targetEntity="ObservationBundle\Entity\Bird", mappedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */

    private $birds;

    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Observation", mappedBy="location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $observations;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->birds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->observations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Location
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Add bird
     *
     * @param \ObservationBundle\Entity\Bird $bird
     *
     * @return Location
     */
    public function addBird(\ObservationBundle\Entity\Bird $bird)
    {
        $this->birds[] = $bird;

        return $this;
    }

    /**
     * Remove bird
     *
     * @param \ObservationBundle\Entity\Bird $bird
     */
    public function removeBird(\ObservationBundle\Entity\Bird $bird)
    {
        $this->birds->removeElement($bird);
    }

    /**
     * Get birds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBirds()
    {
        return $this->birds;
    }

    /**
     * Add observation
     *
     * @param \ObservationBundle\Entity\Observation $observation
     *
     * @return Location
     */
    public function addObservation(\ObservationBundle\Entity\Observation $observation)
    {
        $this->observations[] = $observation;

        return $this;
    }

    /**
     * Remove observation
     *
     * @param \ObservationBundle\Entity\Observation $observation
     */
    public function removeObservation(\ObservationBundle\Entity\Observation $observation)
    {
        $this->observations->removeElement($observation);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }
}
