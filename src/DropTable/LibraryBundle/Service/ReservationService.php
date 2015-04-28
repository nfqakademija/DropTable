<?php
namespace DropTable\LibraryBundle\Service;

use Doctrine\ORM\EntityManager;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\BookHasOwner;
use DropTable\LibraryBundle\Entity\UserHasReservation;
use DropTable\LibraryBundle\Event\AssignReservationEvent;
use DropTable\LibraryBundle\Event\RemoveBookReservationEvent;
use DropTable\LibraryBundle\Event\ReserveBookEvent;
use DropTable\LibraryBundle\Event\ReturnBookEvent;
use DropTable\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ReservationService.
 *
 * @package DropTable\LibraryBundle\Service
 */
class ReservationService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var CatalogService
     */
    protected $catalogService;

    /**
     * @param EntityManager            $em
     * @param EventDispatcherInterface $eventDispatcher
     * @param TokenStorageInterface    $tokenStorage
     * @param CatalogService           $catalogService
     */
    public function __construct(
        EntityManager $em,
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage,
        CatalogService $catalogService
    ) {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
        $this->catalogService = $catalogService;
    }

    /**
     * Function for reserving book.
     *
     * @param Book $book
     *
     * @return UserHasReservation
     */
    public function reserveBook(Book $book)
    {
        $user = $this->tokenStorage->getToken()->getUser(); //TODO: after user bundle configured change type casting for user, and check if user is logged in

        $reservation = new UserHasReservation();
        $reservation->setUser($user);
        $reservation->setBook($book);

        $this->em->persist($reservation);
        $this->em->flush();

        $reserveBookEvent = new ReserveBookEvent($user, $book);
        $this->eventDispatcher->dispatch('reservation.reserved_book', $reserveBookEvent);

        return $reservation;
    }

    /**
     * Function for returning book.
     *
     * @param Book $book
     */
    public function returnBook(Book $book)
    {
        $user = $this->tokenStorage->getToken()->getUser(); //TODO: after user bundle configured change type casting for user, and check if user is logged in

        $bookHasReservationReopository = $this->em->getRepository('DropTableLibraryBundle:BookHasReservation');
        $reservation = $bookHasReservationReopository->findOneBy(
            [
                'user' => $user,
                'book' => $book,
            ]
        );
        $this->em->remove($reservation);
        $this->em->flush();

        $returnBookEvent = new ReturnBookEvent($user, $reservation);
        $this->eventDispatcher->dispatch('reservation.returned_book', $returnBookEvent);
    }

    /**
     * Function to find and assigning book owner if available to reservation.
     *
     * @param UserHasReservation $reservation
     */
    public function assignReservationToOwner(UserHasReservation $reservation)
    {
        $book = $reservation->getBook();
        $owner = $this->catalogService->getAvailableOwner($book);

        if ($owner instanceof BookHasOwner) {
            $reservation->setBookHasOwner($owner);

            $this->em->persist($reservation);
            $this->em->flush();

            $assignReservationEvent = new AssignReservationEvent($reservation);
            $this->eventDispatcher->dispatch('reservation.assigned_book', $assignReservationEvent);
        }
    }

    /**
     * @param User $user
     *
     * @return array|null
     */
    public function getReservationsByUser(User $user)
    {
        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findByUser($user);
    }

    /**
     * @param Book $book
     *
     * @return array|null
     */
    public function getReservationsByBook(Book $book)
    {
        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findByBook($book);
    }

    /**
     * @param BookHasOwner $owner
     *
     * @return array|null
     */
    public function getReservationsByOwner(BookHasOwner $owner)
    {
        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findByBookHasOwner($owner);
    }

    /**
     * @param User $user
     * @param Book $book
     *
     * @return null|object
     */
    public function getReservation(User $user, Book $book)
    {
        $user_id = $user->getId();
        $book_id = $book->getId();

        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findOneBy(
            [
                'user' => $user_id,
                'book' => $book_id,
            ]
        );
    }

    /**
     * Remove reservation by Book entity.
     *
     * @param Book $book
     */
    public function removeReservationsByBook(Book $book)
    {
        $userHasReservationRepository = $this->em->getRepository('DropTableLibraryService:UserHasReservation');
        $reservations = $userHasReservationRepository->findByBook($book);

        foreach ($reservations as $reservation) {
            $this->em->remove($reservation);

            $removeBookReservationEvent = new RemoveBookReservationEvent($reservation);
            $this->eventDispatcher->dispatch('reservation.remove_reserved_book', $removeBookReservationEvent);
        }

        $this->em->flush();
    }
}
