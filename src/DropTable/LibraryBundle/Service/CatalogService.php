<?php

namespace DropTable\LibraryBundle\Service;

use Doctrine\ORM\EntityManager;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\BookHasOwner;
use DropTable\LibraryBundle\Entity\BookRepository;
use DropTable\LibraryBundle\Event\AddBookEvent;
use DropTable\LibraryBundle\Event\AddBookOwnerEvent;
use DropTable\LibraryBundle\Event\RemoveBookOwnerEvent;
use DropTable\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CatalogService.
 *
 * @package DropTable\LibraryBundle\Service
 */
class CatalogService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ReservationService
     */
    protected $reservationService;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param EntityManager            $em
     * @param EventDispatcherInterface $eventDispatcher
     * @param TokenStorageInterface    $tokenStorage
     */
    public function __construct(
        EntityManager $em,
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage
    ) {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Book $book
     * @return int
     */
    public function addBook(Book $book)
    {
        $this->em->persist($book);
        $this->em->flush();

        $user = $this->tokenStorage->getToken()->getUser();

        $this->addBookOwner($book);

        $addBookEvent = new AddBookEvent($book, $user);
        $this->eventDispatcher->dispatch('catalog.added_book', $addBookEvent);

        return $book->getId();
    }

    /**
     * @param Book $book
     *
     * @return BookHasOwner
     */
    public function addBookOwner(Book $book)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $owner = new BookHasOwner();
        $owner->setUser($user);
        $owner->setBook($book);

        $this->em->persist($owner);
        $this->em->flush();

        $addBookOwnerEvent = new AddBookOwnerEvent($book, $user);
        $this->eventDispatcher->dispatch('catalog.added_book_owner', $addBookOwnerEvent);

        return $owner;
    }

    /**
     * Function for removing owner.
     *
     * @param Book $book
     */
    public function removeBookOwner(Book $book)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $owner = $this->getBookOwner($user, $book);

        if ($owner instanceof BookHasOwner) {
            $this->em->remove($owner);
            $this->em->flush();

            $removeBookOwnerEvent = new RemoveBookOwnerEvent($book);
            $this->eventDispatcher->dispatch('catalog.removed_book_owner', $removeBookOwnerEvent);
        }
    }

    /**
     * Function for listing books.
     *
     * @return array
     */
    public function listBooks()
    {
        return $this->em->getRepository('DropTableLibraryBundle:Book')->findAll();
    }

    /**
     * Get defined count of newest books.
     *
     * @param int $count
     * @return mixed
     */
    public function getNewestBooks($count)
    {
        return $this->em
            ->getRepository('DropTableLibraryBundle:Book')
            ->createQueryBuilder('b')
            ->where('b.id > 0')
            ->orderBy('b.createdAt', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    /**
     * Function for listing books by category.
     *
     * @param string $slug
     *
     * @return array
     */
    public function listBooksByCategory($slug)
    {
        /** @var BookRepository $repository */
        $repository = $this->em->getRepository('DropTableLibraryBundle:Book');
        $books = $repository->findBooksByCategory($slug);

        return $books;
    }

    /**
     * @param string $slug
     * @return null|object
     */
    public function getBookById($slug)
    {
        return $this->em->getRepository('DropTableLibraryBundle:Book')->find($slug);
    }

    /**
     * @param string $slug
     * @return null|object
     */
    public function getOwnersByBook($slug)
    {
        $repository = $this->em->getRepository('DropTableLibraryBundle:Book');
        $book = $repository->find($slug);

        return $this->em->getRepository('DropTableLibraryBundle:BookHasOwner')->findByBook($book);
    }

    /**
     * @return BookHasOwner|null
     */
    public function getMyBooks()
    {
        /** @var BookHasOwner $owners */
        $owners = null;
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User) {
            $owners = $this->em->getRepository('DropTableLibraryBundle:BookHasOwner')->findByUser($user);
        }

        return $owners;
    }

    /**
     * @param Book $book
     * @return BookHasOwner
     */
    public function getAvailableOwner(Book $book)
    {
        $owner = $this->em->getRepository('DropTableLibraryBundle:BookHasOwner')->findAvailableOwner($book);

        return $owner;
    }

    public function listBooksByPopularity()
    {
        //TODO: implement function
    }

    public function listBooksBySimilarity(Book $book)
    {
        //TODO: implement function
    }

    /**
     * @param User $user
     * @param Book $book
     *
     * @return BookHasOwner
     */
    private function getBookOwner(User $user, Book $book)
    {
        $owner = $this->em->getRepository('DropTableLibraryBundle:BookHasOwner')->findOneBy(
            [
                'book' => $book,
                'user' => $user,
            ]
        );

        return $owner;
    }
}
