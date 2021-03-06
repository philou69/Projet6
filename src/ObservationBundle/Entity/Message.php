<?php


namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Message
 * @package ObservationBundle\Entity
 *
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text", length=9999999)
     */
    protected $message;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $postedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $received = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $answered = false;

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
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Message
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get postedAt
     *
     * @return \DateTime
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }

    /**
     * Set postedAt
     *
     * @param \DateTime $postedAt
     *
     * @return Message
     */
    public function setPostedAt($postedAt)
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    /**
     * Get received
     *
     * @return boolean
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * Set received
     *
     * @param boolean $received
     *
     * @return Message
     */
    public function setReceived($received)
    {
        $this->received = $received;

        return $this;
    }

    /**
     * Get answered
     *
     * @return boolean
     */
    public function getAnswered()
    {
        return $this->answered;
    }

    /**
     * Set answered
     *
     * @param boolean $answered
     *
     * @return Message
     */
    public function setAnswered($answered)
    {
        $this->answered = $answered;

        return $this;
    }

    public function getSlugTitle()
    {
        return strtr(
            $this->getTitle(),
            '@ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'aAAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
        );
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Message
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
