<?php
namespace DropTable\LibraryBundle\Event;

use DropTable\LibraryBundle\Entity\UserHasReservation;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class RemoveBookReservationEvent.
 *
 * @package DropTable\LibraryBundle\Event
 */
class RemoveBookReservationEvent extends Event
{
    /**
     * @var UserHasReservation
     */
    protected $reservation;

    /**
     * @param UserHasReservation $reservation
     */
    public function __construct(UserHasReservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * @return UserHasReservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }
}
