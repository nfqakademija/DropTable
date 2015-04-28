<?php
namespace DropTable\LibraryBundle\Event;

use DropTable\LibraryBundle\Entity\Book;
use DropTable\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ReserveBookEvent.
 *
 * @package DropTable\LibraryBundle\Event
 */
class ReserveBookEvent extends Event
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
     * @param User $user
     * @param Book $book
     */
    public function __construct(User $user, Book $book)
    {
        $this->user = $user;
        $this->book = $book;
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
