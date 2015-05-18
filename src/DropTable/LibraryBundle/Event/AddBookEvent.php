<?php

namespace DropTable\LibraryBundle\Event;

use DropTable\LibraryBundle\Entity\Book;
use DropTable\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AddBookEvent.
 *
 * @package DropTable\LibraryBundle\Event
 */
class AddBookEvent extends Event
{
    /**
     * @var Book
     */
    protected $book;

    /**
     * @var User
     */
    protected $loggedInUser;

    /**
     * @param Book $book
     * @param User $loggedInUser
     */
    public function __construct(Book $book, User $loggedInUser)
    {
        $this->book = $book;
        $this->loggedInUser = $loggedInUser;
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
    public function getLoggedInUser()
    {
        return $this->$loggedInUser;
    }
}
