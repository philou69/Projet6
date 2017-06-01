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
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Star", mappedBy="groupMedal")
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
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
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
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return '/bundles/observation/public/images/icones/' . $this->image;
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
//        foreach ($this->stars as $star)
//            var_dump($star->getUsers());
//        exit;
        // Cette fonction permet de retourné la derniere médaile du groupe déverouilllé par le visiteur
        // On s'assure qu'il soit déjà dans le group
        if (!$this->users->contains($user)) {
            return null;
        }
        foreach ($this->stars as $star){
            if($star->getUsers()->contains($user)){
//                var_dump($star);
//                exit;
                return $star;
            }
        }
    }
//
//    protected function trie($objet1, $objet2)
//    {
//        return ($objet1->getOrder() < $objet2->getOrder()) ? -1 : 1);
//    }
}
