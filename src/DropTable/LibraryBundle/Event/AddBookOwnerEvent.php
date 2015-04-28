<?php
namespace DropTable\LibraryBundle\Event;

use DropTable\LibraryBundle\Entity\Book;
use DropTable\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AddBookOwnerEvent.
 *
 * @package DropTable\LibraryBundle\Event
 */
class AddBookOwnerEvent extends Event
{
    /**
     * @var Book
     */
    protected $book;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param Book $book
     * @param User $user
     */
    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

    /**
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
