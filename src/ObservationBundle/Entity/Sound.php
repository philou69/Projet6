<?php


namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Sound
 * @package ObservationBundle\Entity
 *
 * @ORM\Table(name="sound")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\SoundRepository")
 * @ORM\HasLifecycleCallbacks()
 */

class Sound
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $fileName;

    protected $file;

    protected $tempFileName;

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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Sound
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Get file
     *
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set file
     *
     * @param mixed $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if($this->fileName !== null){
            $this->tempFileName = $this->getUploadRootDir() . '/' . $this->fileName;
        }
        $this->fileName = null;
        return $this;
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
        $this->file->move($this->getUploadRootDir(), $this->fileName);
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemove()
    {
        $this->tempFileName = $this->getUploadRootDir() . '/' . $this->fileName;
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
        return 'uploads/sound/';
    }

    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir(). '/'.  $this->fileName;
    }

}
