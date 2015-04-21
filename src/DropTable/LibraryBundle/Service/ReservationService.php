<?php

namespace DropTable\LibraryBundle\Service;

use Doctrine\ORM\EntityManager;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\BookHasOwner;
use DropTable\LibraryBundle\Entity\UserHasReservation;
use DropTable\UserBundle\Entity\User;

class ReservationService
{
    /** @var EntityManager $em */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public function reserveBook(User $user, Book $book)
    {
        $reservation = new UserHasReservation();
        $reservation->setUser($user);
        $reservation->setBook($book);

        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }

    public function returnBook(UserHasReservation $reservation)
    {
        $this->em->remove($reservation);
        $this->em->flush();
    }

    public function assignReservationToOwner(UserHasReservation $reservation, BookHasOwner $owner)
    {
        $reservation->setBookHasOwner($owner);

        $this->em->persist($reservation);
        $this->em->flush();
    }

    public function getReservationsByUser(User $user)
    {
        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findByUser($user);
    }

    public function getReservationsByBook(Book $book)
    {
        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findByBook($book);
    }

    public function getReservationsByOwner(BookHasOwner $owner)
    {
        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findByBookHasOwner($owner);
    }

    public function getReservation(User $user, Book $book)
    {
        $user_id = $user->getId();
        $book_id = $book->getId();

        return $this->em->getRepository('DropTableLibraryBundle:UserHasReservation')->findOneBy(
            [
                'user' => $user_id,
                'book' => $book_id
            ]
        );
    }

}