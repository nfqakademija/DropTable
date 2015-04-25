<?php
namespace DropTable\LibraryBundle\Parser;

use DropTable\LibraryBundle\Entity\Book;

/**
 * Class GoogleProviderParser.
 *
 * @package DropTable\LibraryBundle\Parser
 */
class GoogleProviderParser implements BookProviderParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBookEntities($json)
    {
        $books = [];
        $googleData = json_decode($json, true);

        foreach ($googleData['items'] as $googleBook) {
            $book = new Book();
            $book->setTitle($googleBook['volumeInfo']['title']);
            $book->setPages($googleBook['volumeInfo']['pageCount']);
            $book->setPublisher($googleBook['volumeInfo']['publisher']);
            $book->setAuthor(implode($googleBook['volumeInfo']['authors']));
            $book->setDescription($googleBook['volumeInfo']['description']);
            //TODO: need implementation for dealing with multiple isbn numbers.
            $book->setIsbn($googleBook['volumeInfo']['industryIdentifiers'][1]['identifier']);

            $books[] = $book;
        }

        return $books;
    }
}
