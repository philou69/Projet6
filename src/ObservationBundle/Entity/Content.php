<?php


namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Content
 * @package ObservationBundle\Entity
 *
 * @ORM\Table(name="content")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\ContentRepository")
 */
class Content
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=999999, nullable=false)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $page;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $postedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updateAt;

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
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Content
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get page
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set page
     *
     * @param string $page
     *
     * @return Content
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Set postedAt
     *
     * @param \DateTime $postedAt
     *
     * @return Content
     */
    public function setPostedAt($postedAt)
    {
        $this->postedAt = $postedAt;

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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Content
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}
