<?php

namespace DropTable\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookHasOwner.
 *
 * @ORM\Table(name="book_has_owner", indexes={
 *     @ORM\Index(name="fk_book_has_owner_user_idx", columns={"user_id"}),
 *     @ORM\Index(name="fk_book_has_owner_book_idx", columns={"book_id"})
 * })
 * @ORM\Entity(repositoryClass="DropTable\LibraryBundle\Entity\BookHasOwnerRepository")
 */
class BookHasOwner
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
     * @var \DropTable\LibraryBundle\Entity\Book
     *
     * @ORM\ManyToOne(targetEntity="DropTable\LibraryBundle\Entity\Book")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     * })
     */
    private $book;

    /**
     * @var \DropTable\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="DropTable\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return BookHasOwner
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set book.
     *
     * @param \DropTable\LibraryBundle\Entity\Book $book
     *
     * @return BookHasOwner
     */
    public function setBook(\DropTable\LibraryBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book.
     *
     * @return \DropTable\LibraryBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set user.
     *
     * @param \DropTable\UserBundle\Entity\User $user
     *
     * @return BookHasOwner
     */
    public function setUser(\DropTable\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \DropTable\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
