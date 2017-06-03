<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Star
 *
 * @ORM\Table(name="star")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\StarRepository")
 */
class Star
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    protected $order;

    /**
     * @ORM\Column(type="string")
     */
    protected $image;

    /**
     * @ORM\ManyToMany(targetEntity="ObservationBundle\Entity\User", inversedBy="stars")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\GroupStar", inversedBy="stars")
     */
    protected $groupStar;


    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set title
     *
     * @param string $title
     *
     * @return Star
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Star
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Star
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add user
     *
     * @param \ObservationBundle\Entity\User $user
     *
     * @return Star
     */
    public function addUser(\ObservationBundle\Entity\User $user)
    {
        $this->users[] = $user;
        // On regarde si le groupStar contient dejà l'user et on lui le passe si c'est pas le cas
        if(!$this->groupStar->getUsers()->contains($user)){
            $this->groupStar->addUser($user);
        }
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

    /**
     * Set groupStar
     *
     * @param \ObservationBundle\Entity\GroupStar $groupStar
     *
     * @return Star
     */
    public function setGroupStar(\ObservationBundle\Entity\GroupStar $groupStar = null)
    {
        $this->groupStar = $groupStar;

        return $this;
    }

    /**
     * Get groupStar
     *
     * @return \ObservationBundle\Entity\GroupStar
     */
    public function getGroupStar()
    {
        return $this->groupStar;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Star
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
        return '/bundles/observation/images/icones/' . $this->image;
    }
}
