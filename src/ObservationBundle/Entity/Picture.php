<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\PictureRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\Bird", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bird;

    /**
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\Observation", inversedBy="pictures")
     */
    private $observation;

    /**
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Star", mappedBy="picture")
     */
    protected $star;

    protected $file;

    protected $tempFileName;

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
        return $this->url === null ? 'No_picture' : $this->url;
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
        return $this->alt === null ? 'Picture missing' : $this->alt;
    }

    /**
     * Set bird
     *
     * @param \ObservationBundle\Entity\Bird $bird
     *
     * @return Picture
     */
    public function setBird(\ObservationBundle\Entity\Bird $bird)
    {
        $this->bird = $bird;

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

    /**
     * Set user
     *
     * @param \ObservationBundle\Entity\User $user
     *
     * @return Picture
     */
    public function setUser(\ObservationBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ObservationBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set star
     *
     * @param \ObservationBundle\Entity\Star $star
     *
     * @return Picture
     */
    public function setStar(\ObservationBundle\Entity\Star $star = null)
    {
        $this->star = $star;

        return $this;
    }

    /**
     * Get star
     *
     * @return \ObservationBundle\Entity\Star
     */
    public function getStar()
    {
        return $this->star;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if(null !== $this->url){
            $this->tempFileName = $this->getUploadRootDir() . '/'. $this->url;
        }
        $this->url = null;
        $this->alt = null;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if($this->file === null){
            return;
        }

        $this->url = uniqid() . '.' . $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function postUpload()
    {
        if($this->file === null){
            return;
        }

        if($this->tempFileName !== null){
            if(file_exists($this->tempFileName)){
                unlink($this->tempFileName);
            }
        }
        $this->file->move($this->getUploadRootDir(), $this->url);
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemove()
    {
        $this->tempFileName = $this->getUploadRootDir() . '/' . $this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemove()
    {
        if(file_exists($this->tempFileName))
        unlink($this->tempFileName);
    }

    public function getUploadDir()
    {
        $directory = $this->bird === null ? $this->observation === null ? 'avatar' : 'bird' : 'bird';
        return 'uploads/images/' . $directory;
    }

    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function getWebPath()
    {
        $directory = $this->bird === null ? $this->observation === null ? 'avatar' : 'bird' : 'bird';
        return $this->getUploadDir(). '/'.  $this->url;
    }
}
