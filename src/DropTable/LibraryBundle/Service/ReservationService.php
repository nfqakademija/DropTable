<?php
namespace DropTable\LibraryBundle\Service;

use Doctrine\ORM\EntityManager;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\BookHasOwner;
use DropTable\LibraryBundle\Entity\UserHasReservation;
use DropTable\UserBundle\Entity\User;

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
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Function for reserving book.
     *
     * @param User $user
     * @param Book $book
     *
     * @return UserHasReservation
     */
    public function reserveBook(User $user, Book $book)
    {
        $reservation = new UserHasReservation();
        $reservation->setUser($user);
        $reservation->setBook($book);

        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }

    /**
     * Function for returning book.
     *
     * @param UserHasReservation $reservation
     */
    public function returnBook(UserHasReservation $reservation)
    {
        $this->em->remove($reservation);
        $this->em->flush();
    }

    /**
     * Function for assinging book owner to reservation.
     *
     * @param UserHasReservation $reservation
     * @param BookHasOwner       $owner
     */
    public function assignReservationToOwner(UserHasReservation $reservation, BookHasOwner $owner)
    {
        $reservation->setBookHasOwner($owner);

        $this->em->persist($reservation);
        $this->em->flush();
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
}
