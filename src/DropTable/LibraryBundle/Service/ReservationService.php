<?php

namespace DropTable\LibraryBundle\Service;

use Doctrine\ORM\EntityManager;
use DropTable\LibraryBundle\Constant\Status;
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
        $user = $this->tokenStorage->getToken()->getUser();

        if ($this->userHasReserved($user, $book)) {
            return false;
        } else {
            if ($user instanceof User) {
                $reservation = new UserHasReservation();
                $reservation->setUser($user);
                $reservation->setBook($book);
                $reservation->setStatus(Status::WAITING);

                $this->em->persist($reservation);
                $this->em->flush();

                $reserveBookEvent = new ReserveBookEvent($user, $book);
                $this->eventDispatcher->dispatch('reservation.reserved_book', $reserveBookEvent);

                return $reservation;
            }
        }
    }

    /**
     * Function for returning book.
     *
     * @param Book $book
     * @return bool
     */
    public function returnBook(Book $book)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User) {
            $bookHasReservationRepository = $this->em->getRepository('DropTableLibraryBundle:UserHasReservation');

            /** @var UserHasReservation $reservation */
            $reservation = $bookHasReservationRepository->findOneBy(
                [
                    'user' => $user,
                    'book' => $book,
                ]
            );
            if ($reservation instanceof UserHasReservation) {
                $this->em->remove($reservation);
                $this->em->flush();

                $returnBookEvent = new ReturnBookEvent($user, $reservation);
                $this->eventDispatcher->dispatch('reservation.returned_book', $returnBookEvent);

                return true;
            }
        }

        return false;
    }

    /**
     * Change status of the book reservation.
     *
     * @param Book $book
     * @return bool
     */
    public function giveBook(Book $book)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User) {
            $bookHasReservationRepository = $this->em->getRepository('DropTableLibraryBundle:UserHasReservation');

            /** @var UserHasReservation $reservation */
            $reservation = $bookHasReservationRepository->findOneBy(
                [
                    'user' => $user,
                    'book' => $book,
                ]
            );
            if ($reservation instanceof UserHasReservation) {
                $reservation->setStatus(Status::GIVEN);

                $this->em->persist($reservation);
                $this->em->flush($reservation);

//TODO: need events?

                return true;
            }
        }

        return false;
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
     * @return array|null
     */
    public function getReservationsByUser()
    {
        $reservations = null;
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user instanceof User) {
            $reservations = $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findByUser($user);
        }

        return $reservations;
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
     * Find if user has reserved book.
     * @param User $user
     * @param Book $book
     *
     * @return null|object
     */
    public function userHasReserved(User $user, Book $book)
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
     * @param array $owners
     * @return mixed
     */
    public function getMyBooksReservations($owners)
    {
        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findMyBooksReservations($owners);
    }

    /**
     * Remove reservation by Book entity.
     *
     * @param Book $book
     */
    public function removeReservationsByBook(Book $book)
    {
        $userHasReservationRepository = $this->em->getRepository('DropTableLibraryBundle:UserHasReservation');
        $reservations = $userHasReservationRepository->findByBook($book);

        foreach ($reservations as $reservation) {
            $this->em->remove($reservation);

            $removeBookReservationEvent = new RemoveBookReservationEvent($reservation);
            $this->eventDispatcher->dispatch('reservation.remove_reserved_book', $removeBookReservationEvent);
        }

        $this->em->flush();
    }
}
