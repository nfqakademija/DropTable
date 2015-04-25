<?php
namespace DropTable\LibraryBundle\Service;

use Doctrine\ORM\EntityManager;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\BookHasOwner;
use DropTable\LibraryBundle\Entity\Category;
use DropTable\UserBundle\Entity\User;

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
     * @param EntityManager      $em
     * @param ReservationService $reservationService
     */
    public function __construct(EntityManager $em, ReservationService $reservationService)
    {
        $this->em = $em;
        $this->reservationService = $reservationService;
    }

    /**
     * @param Book $book
     */
    public function addBook(Book $book)
    {
        $this->em->persist($book);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @param Book $book
     *
     * @return BookHasOwner
     */
    public function addBookOwner(User $user, Book $book)
    {
        $owner = new BookHasOwner();
        $owner->setUser($user);
        $owner->setBook($book);

        $this->em->persist($owner);
        $this->em->flush();

        return $owner;
    }

    /**
     * Function for removing owner.
     *
     * @param BookHasOwner $owner
     */
    public function removeBookOwner(BookHasOwner $owner)
    {
        $reservations = $this->reservationService->getReservationsByOwner($owner);
        foreach ($reservations as $reservation) {
            $this->em->remove($reservation);
        }

        $this->em->remove($owner);
        $this->em->flush();
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
     * Function for listing books by category.
     *
     * @param Category $category
     *
     * @return array
     */
    public function listBooksByCategory(Category $category)
    {
        return $this->em->getRepository('DropTableLibraryBundle:Book')->findByCategory($category);
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    public function getBookById($id)
    {
        return $this->em->getRepository('DropTableLibraryBundle:Book')->find($id);
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    public function getOwnerById($id)
    {
        return $this->em->getRepository('DropTableLibraryBundle:BookHasOwner')->find($id);
    }

    /**
     * @param Book $book
     *
     * @return mixed
     */
    public function getAvailableOwner(Book $book)
    {
        $owners = $this->em->getRepository('DropTableLibraryBundle:BookHasOwner')->findAllAvailableOwners($book);

        return $owners;
    }

    public function listBooksByPopularity()
    {
        //TODO: implement function
    }

    public function listBooksBySimilarity(Book $book)
    {
        //TODO: implement function
    }
}
