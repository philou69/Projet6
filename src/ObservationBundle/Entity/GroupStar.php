<?php


namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class GroupStar
 * @package ObservationBundle\Entity
 *
 * @ORM\Table(name="groupMedal")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\GroupStarRepository")
 */
class GroupStar
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
    protected $entity;

    /**
     * @ORM\Column(type="string")
     */
    protected $image;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Star", mappedBy="groupStar")
     * @ORM\OrderBy({"order"="DESC"})
     */
    protected $stars;

    /**
     * @ORM\ManyToMany(targetEntity="ObservationBundle\Entity\User")
     */
    protected $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return GroupStar
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return '/bundles/observation/images/icones/' . $this->image;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return GroupStar
     */
    public function setImage($image)
    {
        $this->image = $image;

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
     * @return GroupStar
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Add star
     *
     * @param \ObservationBundle\Entity\Star $star
     *
     * @return GroupStar
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
     * Add user
     *
     * @param \ObservationBundle\Entity\User $user
     *
     * @return GroupStar
     */
    public function addUser(\ObservationBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ObservationBundle\Entity\User $user
     */
    public function removeUser(\ObservationBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function getHighest(User $user)
    {
        // Cette fonction permet de retourné la derniere médaile du groupe déverouilllé par le visiteur
        // On s'assure qu'il soit déjà dans le group
        if ($this->stars->count() == 1) {
            return $this->stars->first();
        }
        foreach ($this->stars as $star){
            if($star->getUsers()->contains($user)){
                return $star;
            }
        }
    }
}
