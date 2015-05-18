<?php

namespace DropTable\LibraryBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book.
 *
 * @ORM\Table(name="book")
 * @ORM\Entity
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="isbn", type="string", nullable=false)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=45, nullable=true)
     */
    private $slug;

    /**
     * @var \DropTable\LibraryBundle\Entity\Author
     *
<<<<<<< HEAD
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="books", cascade={"persist"})
=======
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="books", cascade={"persist"}))
>>>>>>> Add new field/category via ajax. -
     * @ORM\JoinTable(name="book_has_author")
     **/
    private $authors;

    /**
     * @var \DropTable\LibraryBundle\Entity\Publisher
     *
     * @ORM\ManyToOne(targetEntity="Publisher")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
     * })
     **/
    private $publisher;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail_small", type="text", nullable=true)
     */
    private $thumbnail_small;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="text", nullable=true)
     */
    private $thumbnail;

    /**
     * @var int
     *
     * @ORM\Column(name="pages", type="integer", nullable=true)
     */
    private $pages;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DropTable\LibraryBundle\Entity\Category
     *
<<<<<<< HEAD
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="books", cascade={"persist"})
=======
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="books", cascade={"persist"}))
>>>>>>> Add new field/category via ajax. -
     * @ORM\JoinTable(name="book_has_category")
     **/
    private $categories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set isbn
     *
     * @param integer $isbn
     * @return Book
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return integer 
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Book
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
     * Set slug
     *
     * @param string $slug
     * @return Book
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Book
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
     * Set thumbnail_small
     *
     * @param string $thumbnailSmall
     * @return Book
     */
    public function setThumbnailSmall($thumbnailSmall)
    {
        $this->thumbnail_small = $thumbnailSmall;

        return $this;
    }

    /**
     * Get thumbnail_small
     *
     * @return string 
     */
    public function getThumbnailSmall()
    {
        return $this->thumbnail_small;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Book
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set pages
     *
     * @param integer $pages
     * @return Book
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get pages
     *
     * @return integer 
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Book
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add authors
     *
     * @param \DropTable\LibraryBundle\Entity\Author $authors
     * @return Book
     */
    public function addAuthor(\DropTable\LibraryBundle\Entity\Author $authors)
    {
        $this->authors[] = $authors;

        return $this;
    }

    /**
     * Remove authors
     *
     * @param \DropTable\LibraryBundle\Entity\Author $authors
     */
    public function removeAuthor(\DropTable\LibraryBundle\Entity\Author $authors)
    {
        $this->authors->removeElement($authors);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set publisher
     *
     * @param \DropTable\LibraryBundle\Entity\Publisher $publisher
     * @return Book
     */
    public function setPublisher(\DropTable\LibraryBundle\Entity\Publisher $publisher = null)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return \DropTable\LibraryBundle\Entity\Publisher 
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Add categories
     *
     * @param \DropTable\LibraryBundle\Entity\Category $categories
     * @return Book
     */
    public function addCategory(\DropTable\LibraryBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \DropTable\LibraryBundle\Entity\Category $categories
     */
    public function removeCategory(\DropTable\LibraryBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
