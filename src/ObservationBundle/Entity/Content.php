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
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $page;

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
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
     * Get page
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }
}
