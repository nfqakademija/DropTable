<?php
namespace DropTable\LibraryBundle\Service;

use Doctrine\ORM\EntityManager;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\BookHasOwner;
use DropTable\LibraryBundle\Entity\Category;
use DropTable\UserBundle\Entity\User;

class CatalogService
{
    /** @var EntityManager $em */
    protected $em;

    /** @var  ReservationService $userHasReservation */
    protected $reservationService;

    public function __construct(EntityManager $em, ReservationService $reservationService)
    {
        $this->em = $em;
        $this->reservationService = $reservationService;
    }

    public function addBook(Book $book)
    {
        $this->em->persist($book);
        $this->em->flush();
    }

    public function addBookOwner(User $user, Book $book)
    {
        $owner = new BookHasOwner();
        $owner->setUser($user);
        $owner->setBook($book);

        $this->em->persist($owner);
        $this->em->flush();

        return $owner;
    }

    public function removeBookOwner(BookHasOwner $owner)
    {
        $reservations = $this->reservationService->getReservationsByOwner($owner);
        foreach ($reservations as $reservation) {
            $this->em->remove($reservation);
        }

        $this->em->remove($owner);
        $this->em->flush();
    }

    public function listBooks()
    {
        return $this->em->getRepository('DropTableLibraryBundle:Book')->findAll();
    }

    public function listBooksByCategory(Category $category)
    {
        return $this->em->getRepository('DropTableLibraryBundle:Book')->findByCategory($category);
    }

    public function getBookById($id)
    {
        return $this->em->getRepository('DropTableLibraryBundle:Book')->find($id);
    }

    public function getOwnerById($id)
    {
        return $this->em->getRepository('DropTableLibraryBundle:BookHasOwner')->find($id);
    }

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