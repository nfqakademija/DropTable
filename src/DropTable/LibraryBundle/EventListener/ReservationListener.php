<?php

namespace DropTable\LibraryBundle\EventListener;

use DropTable\LibraryBundle\Event\AssignReservationEvent;
use DropTable\LibraryBundle\Event\RemoveBookReservationEvent;
use DropTable\LibraryBundle\Event\ReserveBookEvent;
use DropTable\LibraryBundle\Event\ReturnBookEvent;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class ReservationListener.
 *
 * @package DropTable\LibraryBundle\EventListener
 */
class ReservationListener
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
     * @param \Swift_Mailer $mailer
     * @param TwigEngine    $twig
     * @param string        $contactMail
     */
    public function __construct(\Swift_Mailer $mailer, TwigEngine $twig, $contactMail)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->contactMail = $contactMail;
    }

    /**
     * Event triggered actions when reserving book.
     *
     * @param ReserveBookEvent $event
     */
    public function onReserveBook(ReserveBookEvent $event)
    {
        $book = $event->getBook();
        $user = $event->getUser();

        $title = $book->getTitle();
        $email = $user->getUsername();

        $message = $this->mailer->createMessage()
            ->setSubject("Library - Book \"$title\" added to queue")
            ->setFrom($this->contactMail)
            ->setTo($email)
            ->setBody(
                $this->twig->render(
                    'DropTableLibraryBundle:Emails:reserveBook.html.twig',
                    ['book' => $book]
                )
            );

        $this->mailer->send($message);
    }

    /**
     * Event triggered actions when returned book.
     *
     * @param ReturnBookEvent $event
     */
    public function onReturnBook(ReturnBookEvent $event)
    {
        $reservation = $event->getReservation();
        $user = $event->getUser();

        $title = $reservation->getBook()->getTitle();
        $email = $user->getUsername();

        $message = $this->mailer->createMessage()
            ->setSubject("Library - Book \"$title\" has been returned")
            ->setFrom($this->contactMail)
            ->setTo($email)
            ->setBody(
                $this->twig->render(
                    'DropTableLibraryBundle:Emails:returnBook.html.twig',
                    ['reservation' => $reservation]
                )
            );

        $this->mailer->send($message);
    }

    /**
     * Event triggered actions when assigned reservation to owner.
     *
     * @param AssignReservationEvent $event
     */
    public function onAssignReservation(AssignReservationEvent $event)
    {
        $reservation = $event->getReservation();

        $user = $reservation->getUser();
        $owner = $reservation->getBookHasOwner();
        $book = $reservation->getBook();

        $bookTitle = $book->getTitle();
        $userEmail = $user->getUsername();
        $ownerEmail = $owner->getUser()->getUsername();

        $messageToUser = $this->mailer->createMessage()
            ->setSubject("Library - Book \"$bookTitle\" is available")
            ->setFrom($this->contactMail)
            ->setTo($userEmail)
            ->setBody(
                $this->twig->render(
                    'DropTableLibraryBundle:Emails:assignBookToUser.html.twig',
                    ['reservation' => $reservation]
                )
            );

        $messageToOwner = $this->mailer->createMessage()
            ->setSubject("Library - Book \"$bookTitle\" has been reserved")
            ->setFrom($this->contactMail)
            ->setTo($ownerEmail)
            ->setBody(
                $this->twig->render(
                    'DropTableLibraryBundle:Emails:assignBookToOwner.html.twig',
                    ['reservation' => $reservation]
                )
            );
        $this->mailer->send($messageToUser);
        $this->mailer->send($messageToOwner);
    }

    /**
     * Event triggered actions when reservation is being removed.
     *
     * @param RemoveBookReservationEvent $event
     */
    public function onRemoveBookReservation(RemoveBookReservationEvent $event)
    {
        $reservation = $event->getReservation();

        $userEmail = $reservation->getUser()->getUsername();
        $bookTitle = $reservation->getBook()->getTitle();

        $message = $this->mailer->createMessage()
            ->setSubject("Library - Book \"$bookTitle\" is available")
            ->setFrom($this->contactMail)
            ->setTo($userEmail)
            ->setBody(
                $this->twig->render(
                    'DropTableLibraryBundle:Emails:removeBookReservation.html.twig',
                    ['reservation' => $reservation]
                )
            );

        $this->mailer->send($message);
    }
}
