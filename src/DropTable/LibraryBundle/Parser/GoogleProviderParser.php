<?php

namespace DropTable\LibraryBundle\Parser;

use DropTable\LibraryBundle\Entity\Author;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\Category;
use DropTable\LibraryBundle\Entity\Publisher;

/**
 * Class GoogleProviderParser.
 *
 * @package DropTable\LibraryBundle\Parser
 */
class GoogleProviderParser
{
    /**
     * Function to convert json data to entities.
     *
     * @param string $json
     *
     * @return array
     */
    public function getBookEntities($json)
    {
        $books = [];
        $googleData = json_decode($json, true);

        if ($googleData['totalItems'] <= 0) {
            $books[] = new Book();

            return $books;
        }

        foreach ($googleData['items'] as $googleBook) {
            $book = new Book();
            $publisher = new Publisher();
            $publisher->setName($googleBook['volumeInfo']['publisher']);
            $this->getAuthors($googleBook, $book);
            $this->getCategories($googleBook, $book);
            $book->setTitle($googleBook['volumeInfo']['title']);
            $book->setPages($googleBook['volumeInfo']['pageCount']);
            $book->AddPublisher($publisher);
            $book->setDescription($googleBook['volumeInfo']['description']);
            $book->setThumbnailSmall($googleBook['volumeInfo']['imageLinks']['smallThumbnail']);
            $book->setThumbnail($googleBook['volumeInfo']['imageLinks']['thumbnail']);
            
            //TODO: need implementation for dealing with multiple isbn numbers.
            $book->setIsbn($googleBook['volumeInfo']['industryIdentifiers'][1]['identifier']);

            $books[] = $book;
        }

        return $books;
    }

    /**
     * Populates Book entity with Authors form google book data.
     *
     * @param string $googleBook
     * @param Book   $book
     */
    private function getAuthors($googleBook, Book $book)
    {
        foreach ($googleBook['volumeInfo']['authors'] as $author) {
            $authorEntity = new Author();
            $authorEntity->setName($author);
            $book->AddAuthor($authorEntity);
        }
    }

    /**
     * Populates Book entity with Categories form google book data.
     *
     * @param string $googleBook
     * @param Book   $book
     */
    private function getCategories($googleBook, Book $book)
    {
        foreach ($googleBook['volumeInfo']['categories'] as $category) {
            $categoryEntity = new Category();
            $categoryEntity->setName($category);
            $book->addCategory($categoryEntity);
        }
    }
}
