<?php


namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use ObservationBundle\Validator\Constraints as ObsAssert;

/**
 * Class Fiche
 * @package ObservationBundle\Entity
 *
 * @ORM\Table(name="fiche")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\FicheRepository")
 * @ObsAssert\Fiche
 */
class Fiche
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="min_quantity",type="integer")
     */
    protected $minQuantity = 0;

    /**
     * @ORM\Column(name="max_quantity", type="integer")
     */
    protected $maxQuantity = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Bird", mappedBy="fiche", cascade={"persist"})
     * @ORM\JoinColumn(name="bird", referencedColumnName="id")
     */
    protected $bird;



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
     * Get minQuantity
     *
     * @return integer
     */
    public function getMinQuantity()
    {
        return $this->minQuantity;
    }

    /**
     * Set minQuantity
     *
     * @param integer $minQuantity
     *
     * @return Fiche
     */
    public function setMinQuantity($minQuantity)
    {
        $this->minQuantity = $minQuantity;

        return $this;
    }

    /**
     * Get maxQuantity
     *
     * @return integer
     */
    public function getMaxQuantity()
    {
        return $this->maxQuantity;
    }

    /**
     * Set maxQuantity
     *
     * @param integer $maxQuantity
     *
     * @return Fiche
     */
    public function setMaxQuantity($maxQuantity)
    {
        $this->maxQuantity = $maxQuantity;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Fiche
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Set description
     *
     * @param string $description
     *
     * @return Fiche
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get bird
     *
     * @return \ObservationBundle\Entity\Bird
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * Set bird
     *
     * @param \ObservationBundle\Entity\Bird $bird
     *
     * @return Fiche
     */
    public function setBird(\ObservationBundle\Entity\Bird $bird = null)
    {
        $this->bird = $bird;

        return $this;
    }
}
