<?php
namespace DropTable\LibraryBundle\Event;

use DropTable\LibraryBundle\Entity\Book;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class RemoveBookOwnerEvent.
 *
 * @package DropTable\LibraryBundle\Event
 */
class RemoveBookOwnerEvent extends Event
{
    /**
     * @var Book
     */
    protected $book;

    /**
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }
}
