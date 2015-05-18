<?php

namespace DropTable\LibraryBundle\Event;

use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Entity\UserHasReservation;
use DropTable\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ReturnBookEvent.
 *
 * @package DropTable\LibraryBundle\Event
 */
class ReturnBookEvent extends Event
{
    /**
     * @var UserHasReservation
     */
    protected $reservation;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param User               $user
     * @param UserHasReservation $reservation
     */
    public function __construct(User $user, UserHasReservation $reservation)
    {
        $this->user = $user;
        $this->reservation = $reservation;
    }

    /**
     * @return UserHasReservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
