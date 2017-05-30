<?php


namespace ObservationBundle\Entity;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package ObservationBundle\Entity
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="L'email est déjà utilisé")
 * @UniqueEntity(fields="username", message="Le pseudo est déjà utilisé")
 */

class User implements AdvancedUserInterface, \Serializable
{
    const  ROLE_DEFAULT = 'ROLE_USER';
    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(name="username", type="string", unique=true)
     * @Assert\NotBlank()
     *
     */
    protected $username;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(name="email", type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\Column(name="firstname", type="string", length=150)
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=150)
     */
    protected  $lastname;

    /**
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    protected $birthDate;

    /**
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * @var array
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;

    /**
     * @ORM\Column(name="token", type="string", nullable=true)
     */
    protected $token;

    /**
     * @ORM\Column(name="token_date", type="datetime", nullable=true)
     */
    protected $dateToken;

    /**
     * @ORM\ManyToMany(targetEntity="ObservationBundle\Entity\Star", mappedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $stars;


    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Observation", mappedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $observations;


    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Picture", cascade={"persist"})
     */
    protected $avatar;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = array();
        $this->isActive = true;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);
        if($role == static::ROLE_DEFAULT){
            return $this;
        }
        if(!in_array($role, $this->roles, true)){
            $this->roles[] = $role;
        }
        return $this;
    }

    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

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
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->isActive,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->isActive
            ) = unserialize($serialized);
    }

    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function getRoles()
    {
        $roles = $this->roles;

        // on s'assure la présence d'au moins un role
        $roles[] = static::ROLE_DEFAULT;

        // On retourne le tableau en supprimant  les doublons
        return array_unique($roles);
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        return null;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * Get plainPassword
     *
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set plainPassword
     *
     * @param mixed $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

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
     * Set token
     *
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get dateToken
     *
     * @return \DateTime
     */
    public function getDateToken()
    {
        return $this->dateToken;
    }

    /**
     * Set dateToken
     *
     * @param \DateTime $dateToken
     *
     * @return User
     */
    public function setDateToken($dateToken)
    {
        $this->dateToken = $dateToken;

        return $this;
    }

    /**
     * Add star
     *
     * @param \ObservationBundle\Entity\Star $star
     *
     * @return User
     */
    public function addStar(\ObservationBundle\Entity\Star $star)
    {
        $this->stars[] = $star;

        return $this;
    }

    /**
     * Remove star
     *
     * @param \ObservationBundle\Entity\Star $star
     */
    public function removeStar(\ObservationBundle\Entity\Star $star)
    {
        $this->stars->removeElement($star);
    }

    /**
     * Get stars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * Add observation
     *
     * @param \ObservationBundle\Entity\Observation $observation
     *
     * @return User
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
     * Get avatar
     *
     * @return \ObservationBundle\Entity\Picture
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatar
     *
     * @param \ObservationBundle\Entity\Picture $avatar
     *
     * @return User
     */
    public function setAvatar(\ObservationBundle\Entity\Picture $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }
}
