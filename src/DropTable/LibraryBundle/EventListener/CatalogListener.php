<?php
namespace DropTable\LibraryBundle\EventListener;

use DropTable\LibraryBundle\Event\AddBookEvent;
use DropTable\LibraryBundle\Event\AddBookOwnerEvent;
use DropTable\LibraryBundle\Event\RemoveBookOwnerEvent;
use DropTable\LibraryBundle\Service\ReservationService;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class CatalogListener.
 *
 * @package DropTable\LibraryBundle\EventListener
 */
class CatalogListener
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var TwigEngine
     */
    protected $twig;

    /**
     * @var string
     */
    protected $contactMail;

    /**
     * @var ReservationService
     */
    protected $reservationService;

    /**
     * @param \Swift_Mailer      $mailer
     * @param TwigEngine         $twig
     * @param ReservationService $reservationService
     * @param string             $contactMail
     */
    public function __construct(
        \Swift_Mailer $mailer,
        TwigEngine $twig,
        ReservationService $reservationService,
        $contactMail
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->reservationService = $reservationService;
        $this->contactMail = $contactMail;
    }

    /**
     * Event triggered actions when adding the book.
     *
     * @param AddBookEvent $event
     */
    public function onAddBook(AddBookEvent $event)
    {
    }

    /**
     * Event triggered action when adding book owner.
     *
     * @param AddBookOwnerEvent $event
     */
    public function onAddBookOwner(AddBookOwnerEvent $event)
    {
    }

    /**
     * Event triggered action when removing book owner.
     *
     * @param RemoveBookOwnerEvent $event
     */
    public function onRemoveBookOwner(RemoveBookOwnerEvent $event)
    {
        $book = $event->getBook();
        $this->reservationService->removeReservationsByBook($book);
    }
}
