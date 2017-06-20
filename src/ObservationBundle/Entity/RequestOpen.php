<?php


namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RequestOpen
 * @package ObservationBundle\Entity
 *
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\RequestOpenRepository")
 */

class RequestOpen
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\User", mappedBy="requestOpen")
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $token;

    /**
     * @ORM\Column(type="string")
     */
    protected $adresseIP;

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
     * Set token
     *
     * @param string $token
     *
     * @return RequestOpen
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

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
     * Set adresseIP
     *
     * @param string $adresseIP
     *
     * @return RequestOpen
     */
    public function setAdresseIP($adresseIP)
    {
        $this->adresseIP = $adresseIP;

        return $this;
    }

    /**
     * Get adresseIP
     *
     * @return string
     */
    public function getAdresseIP()
    {
        return $this->adresseIP;
    }

    /**
     * Set user
     *
     * @param \ObservationBundle\Entity\User $user
     *
     * @return RequestOpen
     */
    public function setUser(\ObservationBundle\Entity\User $user = null)
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
}
