<?php

namespace DropTable\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserHasReservation
 *
 * @ORM\Table(name="user_has_reservation", indexes={@ORM\Index(name="fk_user_has_reservation_user_idx", columns={"user_id"}), @ORM\Index(name="fk_user_has_reservation_book_has_owner_idx", columns={"book_has_owner_id"}), @ORM\Index(name="fk_user_has_reservation_book_idx", columns={"book_id"})})
 * @ORM\Entity
 */
class UserHasReservation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DropTable\LibraryBundle\Entity\Book
     *
     * @ORM\OneToOne(targetEntity="DropTable\LibraryBundle\Entity\Book")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_id", referencedColumnName="id", unique=true)
     * })
     */
    private $book;

    /**
     * @var \DropTable\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="DropTable\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)
     * })
     */
    private $user;

    /**
     * @var \DropTable\LibraryBundle\Entity\BookHasOwner
     *
     * @ORM\ManyToOne(targetEntity="DropTable\LibraryBundle\Entity\BookHasOwner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_has_owner_id", referencedColumnName="id")
     * })
     */
    private $bookHasOwner;



    /**
     * Set id
     *
     * @param integer $id
     * @return UserHasReservation
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
     * Set book
     *
     * @param \DropTable\LibraryBundle\Entity\Book $book
     * @return UserHasReservation
     */
    public function setBook(\DropTable\LibraryBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \DropTable\LibraryBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set user
     *
     * @param \DropTable\UserBundle\Entity\User $user
     * @return UserHasReservation
     */
    public function setUser(\DropTable\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DropTable\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set bookHasOwner
     *
     * @param \DropTable\LibraryBundle\Entity\BookHasOwner $bookHasOwner
     * @return UserHasReservation
     */
    public function setBookHasOwner(\DropTable\LibraryBundle\Entity\BookHasOwner $bookHasOwner = null)
    {
        $this->bookHasOwner = $bookHasOwner;

        return $this;
    }

    /**
     * Get bookHasOwner
     *
     * @return \DropTable\LibraryBundle\Entity\BookHasOwner
     */
    public function getBookHasOwner()
    {
        return $this->bookHasOwner;
    }
}
