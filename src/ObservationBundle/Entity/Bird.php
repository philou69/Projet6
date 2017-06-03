<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bird
 *
 * @ORM\Table(name="bird")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\BirdRepository")
 */
class Bird
{
    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Fiche")
     */
    protected $fiche;
    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Sound")
     */
    protected $sound;
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
     * @ORM\Column(name="ordre", type="string", length=255)
     */
    private $ordre;
    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=255)
     */
    private $famille;
    /**
     * @var int
     *
     * @ORM\Column(name="cd_nom", type="integer")
     */
    private $cdNom;
    /**
     * @var int
     *
     * @ORM\Column(name="cd_taxsup", type="integer")
     */
    private $cdTaxsup;
    /**
     * @var int
     *
     * @ORM\Column(name="cd_ref", type="integer")
     */
    private $cdRef;
    /**
     * @var string
     *
     * @ORM\Column(name="rang", type="string", length=255)
     */
    private $rang;
    /**
     * @var string
     *
     * @ORM\Column(name="lb_nom", type="string", length=255)
     */
    private $lbNom;
    /**
     * @var string
     *
     * @ORM\Column(name="lb_auteur", type="string", length=255)
     */
    private $lbAuteur;
    /**
     * @var string
     *
     * @ORM\Column(name="nom_complet", type="string", length=255)
     */
    private $nomComplet;
    /**
     * @var string
     *
     * @ORM\Column(name="nom_valide", type="string", length=255)
     */
    private $nomValide;
    /**
     * @var string
     *
     * @ORM\Column(name="nom_vern", type="string", length=255)
     */
    private $nomVern;
    /**
     * @var string
     *
     * @ORM\Column(name="nom_vern_eng", type="string", length=255)
     */
    private $nomVernEng;
    /**
     * @var string
     *
     * @ORM\Column(name="phylum", type="string", length=255)
     */
    private $phylum;
    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=255)
     */
    private $classe;
    /**
     * @var string
     *
     * @ORM\Column(name="regne", type="string", length=255)
     */
    private $regne;
    /**
     * @ORM\ManyToMany(targetEntity="ObservationBundle\Entity\Location", inversedBy="birds", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */

    private $locations;
    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Observation", mappedBy="bird")
     * @ORM\JoinColumn(nullable=false)
     */
    private $observations;
    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Picture", mappedBy="bird")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pictures;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->locations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->observations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get ordre
     *
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     *
     * @return Bird
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Bird
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get cdNom
     *
     * @return int
     */
    public function getCdNom()
    {
        return $this->cdNom;
    }

    /**
     * Set cdNom
     *
     * @param integer $cdNom
     *
     * @return Bird
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = $cdNom;

        return $this;
    }

    /**
     * Get cdTaxsup
     *
     * @return int
     */
    public function getCdTaxsup()
    {
        return $this->cdTaxsup;
    }

    /**
     * Set cdTaxsup
     *
     * @param integer $cdTaxsup
     *
     * @return Bird
     */
    public function setCdTaxsup($cdTaxsup)
    {
        $this->cdTaxsup = $cdTaxsup;

        return $this;
    }

    /**
     * Get cdRef
     *
     * @return int
     */
    public function getCdRef()
    {
        return $this->cdRef;
    }

    /**
     * Set cdRef
     *
     * @param integer $cdRef
     *
     * @return Bird
     */
    public function setCdRef($cdRef)
    {
        $this->cdRef = $cdRef;

        return $this;
    }

    /**
     * Get rang
     *
     * @return string
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set rang
     *
     * @param string $rang
     *
     * @return Bird
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get lbNom
     *
     * @return string
     */
    public function getLbNom()
    {
        return $this->lbNom;
    }

    /**
     * Set lbNom
     *
     * @param string $lbNom
     *
     * @return Bird
     */
    public function setLbNom($lbNom)
    {
        $this->lbNom = $lbNom;

        return $this;
    }

    /**
     * Get lbAuteur
     *
     * @return string
     */
    public function getLbAuteur()
    {
        return $this->lbAuteur;
    }

    /**
     * Set lbAuteur
     *
     * @param string $lbAuteur
     *
     * @return Bird
     */
    public function setLbAuteur($lbAuteur)
    {
        $this->lbAuteur = $lbAuteur;

        return $this;
    }

    /**
     * Get nomComplet
     *
     * @return string
     */
    public function getNomComplet()
    {
        return $this->nomComplet;
    }

    /**
     * Set nomComplet
     *
     * @param string $nomComplet
     *
     * @return Bird
     */
    public function setNomComplet($nomComplet)
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    /**
     * Get nomValide
     *
     * @return string
     */
    public function getNomValide()
    {
        return $this->nomValide;
    }

    /**
     * Set nomValide
     *
     * @param string $nomValide
     *
     * @return Bird
     */
    public function setNomValide($nomValide)
    {
        $this->nomValide = $nomValide;

        return $this;
    }

    /**
     * Get nomVernEng
     *
     * @return string
     */
    public function getNomVernEng()
    {
    }

    /**
     * Set nomVernEng
     *
     * @param string $nomVernEng
     *
     * @return Bird
     */
    public function setNomVernEng($nomVernEng)
    {
        $this->nomVernEng = $nomVernEng;

        return $this;
    }

    /**
     * Get phylum
     *
     * @return string
     */
    public function getPhylum()
    {
        return $this->phylum;
    }

    /**
     * Set phylum
     *
     * @param string $phylum
     *
     * @return Bird
     */
    public function setPhylum($phylum)
    {
        $this->phylum = $phylum;

        return $this;
    }

    /**
     * Get classe
     *
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set classe
     *
     * @param string $classe
     *
     * @return Bird
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Add location
     *
     * @param \ObservationBundle\Entity\Location $location
     *
     * @return Bird
     */
    public function addLocation(\ObservationBundle\Entity\Location $location)
    {
        $this->locations[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \ObservationBundle\Entity\Location $location
     */
    public function removeLocation(\ObservationBundle\Entity\Location $location)
    {
        $this->locations->removeElement($location);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Add observation
     *
     * @param \ObservationBundle\Entity\Observation $observation
     *
     * @return Bird
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

    /**
     * Add picture
     *
     * @param \ObservationBundle\Entity\Picture $picture
     *
     * @return Bird
     */
    public function addPicture(\ObservationBundle\Entity\Picture $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \ObservationBundle\Entity\Picture $picture
     */
    public function removePicture(\ObservationBundle\Entity\Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Get regne
     *
     * @return string
     */
    public function getRegne()
    {
        return $this->regne;
    }

    /**
     * Set regne
     *
     * @param string $regne
     *
     * @return Bird
     */
    public function setRegne($regne)
    {
        $this->regne = $regne;

        return $this;
    }

    public  function getAName()
    {
        return $this->nomVern == '' ? $this->lbNom : $this->getNomVern();
    }

    /**
     * Get nomVern
     *
     * @return string
     */
    public function getNomVern()
    {
        return str_replace("\"", "", $this->nomVern);
    }

    /**
     * Set nomVern
     *
     * @param string $nomVern
     *
     * @return Bird
     */
    public function setNomVern($nomVern)
    {
        $this->nomVern = $nomVern;

        return $this;
    }

    function __toString()
    {
        return $this->nomVern == '' ? $this->lbNom : $this->getNomVern();
    }

    /**
     * Get fiche
     *
     * @return \ObservationBundle\Entity\Fiche
     */
    public function getFiche()
    {
        return $this->fiche;
    }

    /**
     * Set fiche
     *
     * @param \ObservationBundle\Entity\Fiche $fiche
     *
     * @return Bird
     */
    public function setFiche(\ObservationBundle\Entity\Fiche $fiche = null)
    {
        $this->fiche = $fiche;

        return $this;
    }

    /**
     * Get sound
     *
     * @return \ObservationBundle\Entity\Sound
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * Set sound
     *
     * @param \ObservationBundle\Entity\Sound $sound
     *
     * @return Bird
     */
    public function setSound(\ObservationBundle\Entity\Sound $sound = null)
    {
        $this->sound = $sound;

        return $this;
    }
}
