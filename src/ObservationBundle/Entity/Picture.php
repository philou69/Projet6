<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Image()
     */
    protected $file;
    protected $tempFileName;
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
     * @Assert\Image()
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
     */
    private $bird;
    /**
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\Observation", inversedBy="pictures")
     */
    private $observation;


    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\User", mappedBy="avatar")
     */
    private $user;

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
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url === null ? 'No_picture' : $this->url;
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
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt === null ? 'Picture missing' : $this->alt;
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
     * @return Picture
     */
    public function setBird(\ObservationBundle\Entity\Bird $bird = null)
    {
        $this->bird = $bird;

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
     * Set observation
     *
     * @param \ObservationBundle\Entity\Observation $observation
     *
     * @return Picture
     */
    public function setObservation(\ObservationBundle\Entity\Observation $observation)
    {
        $this->observation = $observation;
        $observation->addPicture($this);
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
     * Set user
     *
     * @param \ObservationBundle\Entity\User $user
     *
     * @return Picture
     */
    public function setUser(\ObservationBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
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

        return $this;
    }

    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function getUploadDir()
    {
        $directory = $this->bird === null ? $this->observation === null ? 'avatar' : 'bird' : 'bird';
        return 'uploads/images/' . $directory;
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

    public function getWebPath()
    {
        return $this->getUploadDir(). '/'.  $this->url;
    }

}
