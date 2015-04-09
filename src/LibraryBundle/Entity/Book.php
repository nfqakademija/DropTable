<?php
namespace LibraryBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="book")
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, unique=true, nullable=false)
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $publisher;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $pages;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="book")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="\UserBundle\Entity\User", mappedBy="book_reservation")
     */
    private $user_reservation;

    /**
     * @ORM\ManyToMany(targetEntity="\UserBundle\Entity\User", mappedBy="book_owner")
     */
    private $user_owner;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user_reservation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user_owner = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Book
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * Set author
     *
     * @param string $author
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     * @return Book
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
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
     * Set pages
     *
     * @param string $pages
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
     * @return string
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Book
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set category
     *
     * @param \LibraryBundle\Entity\Category $category
     * @return Book
     */
    public function setCategory(\LibraryBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \LibraryBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add user_reservation
     *
     * @param \LibraryBundle\Entity\User $userReservation
     * @return Book
     */
    public function addUserReservation(\LibraryBundle\Entity\User $userReservation)
    {
        $this->user_reservation[] = $userReservation;

        return $this;
    }

    /**
     * Remove user_reservation
     *
     * @param \LibraryBundle\Entity\User $userReservation
     */
    public function removeUserReservation(\LibraryBundle\Entity\User $userReservation)
    {
        $this->user_reservation->removeElement($userReservation);
    }

    /**
     * Get user_reservation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserReservation()
    {
        return $this->user_reservation;
    }

    /**
     * Add user_owner
     *
     * @param \LibraryBundle\Entity\User $userOwner
     * @return Book
     */
    public function addUserOwner(\LibraryBundle\Entity\User $userOwner)
    {
        $this->user_owner[] = $userOwner;

        return $this;
    }

    /**
     * Remove user_owner
     *
     * @param \LibraryBundle\Entity\User $userOwner
     */
    public function removeUserOwner(\LibraryBundle\Entity\User $userOwner)
    {
        $this->user_owner->removeElement($userOwner);
    }

    /**
     * Get user_owner
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserOwner()
    {
        return $this->user_owner;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
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
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
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
}
