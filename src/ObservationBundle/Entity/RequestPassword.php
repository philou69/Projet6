<?php


namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RequestPassword
 * @package ObservationBundle\Entity
 *
 * @ORM\Table(name="request_password")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\RequestPasswordRepository", )
 */
class RequestPassword
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\User", mappedBy="requestPassword")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $token;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $whenToken;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $addressIP;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $used = false;

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return RequestPassword
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set when
     *
     * @param \DateTime $when
     *
     * @return RequestPassword
     */
    public function setWhen($when)
    {
        $this->when = $when;

        return $this;
    }

    /**
     * Get when
     *
     * @return \DateTime
     */
    public function getWhen()
    {
        return $this->when;
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
     * @return RequestPassword
     */
    public function setUser(\ObservationBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
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
     * Get addressIP
     *
     * @return integer
     */
    public function getAddressIP()
    {
        return $this->addressIP;
    }

    /**
     * Set addressIP
     *
     * @param integer $addressIP
     *
     * @return RequestPassword
     */
    public function setAddressIP($addressIP)
    {
        $this->addressIP = $addressIP;

        return $this;
    }

    /**
     * Get whenToken
     *
     * @return \DateTime
     */
    public function getWhenToken()
    {
        return $this->whenToken;
    }

    /**
     * Set whenToken
     *
     * @param \DateTime $whenToken
     *
     * @return RequestPassword
     */
    public function setWhenToken($whenToken)
    {
        $this->whenToken = $whenToken;

        return $this;
    }

    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Get used
     *
     * @return boolean
     */
    public function getUsed()
    {
        return $this->used;
    }

    public function setUsed(bool $used)
    {
        $this->used = $used;

        return $this;
    }
}
