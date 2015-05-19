<?php

namespace DropTable\LibraryBundle\Parser;

use Doctrine\ORM\EntityManager;
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
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
            $this->getAuthors($googleBook, $book);
            $this->getCategories($googleBook, $book);
            $this->getPublisher($googleBook, $book);
            $book->setTitle($googleBook['volumeInfo']['title']);
            $book->setPages($googleBook['volumeInfo']['pageCount']);
            $book->setDescription($googleBook['volumeInfo']['description']);
            $book->setThumbnailSmall($googleBook['volumeInfo']['imageLinks']['smallThumbnail']);
            $book->setThumbnail($googleBook['volumeInfo']['imageLinks']['thumbnail']);
            
            $book->setIsbn($googleBook['volumeInfo']['industryIdentifiers'][0]['identifier']);

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
        $categoryRepository = $this->entityManager->getRepository('DropTableLibraryBundle:Author');

        foreach ($googleBook['volumeInfo']['authors'] as $authorName) {
            $author = $categoryRepository->findOneByName($authorName);
            if ($author instanceof Author) {
                $book->addAuthor($author);
            } else {
                $author = new Author();
                $author->setName($authorName);
                $book->AddAuthor($author);
            }
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
        $categoryRepository = $this->entityManager->getRepository('DropTableLibraryBundle:Category');

        foreach ($googleBook['volumeInfo']['categories'] as $categoryName) {
            $category = $categoryRepository->findOneByName($categoryName);
            if ($category instanceof Category) {
                $book->addCategory($category);
            } else {
                $category = new Category();
                $category->setName($categoryName);
                $book->addCategory($category);
            }
        }
    }

    /**
     * Populates Book entity with Categories form google book data.
     *
     * @param string $googleBook
     * @param Book   $book
     */
    private function getPublisher($googleBook, Book $book)
    {
        $publisherName = $googleBook['volumeInfo']['publisher'];
        $publisherRepository = $this->entityManager->getRepository('DropTableLibraryBundle:Publisher');
        $publisher = $publisherRepository->findOneByName($publisherName);

        if ($publisher instanceof Publisher) {
            $book->setPublisher($publisher);
        } else {
            $publisher = new Publisher();
            $publisher->setName($publisherName);
            $this->entityManager->persist($publisher);
            $this->entityManager->flush($publisher);
            $book->setPublisher($publisher);
        }
    }
}
