<?php

namespace DropTable\LibraryBundle\Controller;

use DropTable\LibraryBundle\Entity\UserHasReservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Form\Type\BookType;

/**
 * Catalog CatalogController
 * @package DropTable\LibraryBundle\Controller
 */
class ReservationController extends Controller
{
    /**
     * Action for listing all books.
     *
     * @param string $slug
     * @return JsonResponse
     * @Template()
     */
    public function reserveAction($slug)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $reservationService = $this->container->get('reservation');
        $book = $em->getRepository('DropTableLibraryBundle:Book')->findOneBySlug($slug);

        $reservation = $reservationService->reserveBook($book);

        if ($reservation instanceof UserHasReservation) {
            $this->addFlash('reservation-result', 'Book reservation successful!');
        } else {
            $this->addFlash('reservation-result', 'Something went wrong, try again.');
        }

        return $this->redirectToRoute('catalog.book', ['slug' => $slug ]);
    }

    /**
     * Return or cancel reservation.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function returnAction($slug)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $reservationService = $this->container->get('reservation');
        $book = $em->getRepository('DropTableLibraryBundle:Book')->findOneBySlug($slug);



        $result = $reservationService->returnBook($book);

        if ($result) {
            return new JsonResponse(['status' => 'success']);
        } else {
            return new JsonResponse(['status' => 'error']);
        }
    }

    /**
     * Return users reservations.
     *
     * @return array
     *
     * @Template()
     */
    public function myReservationsAction()
    {
        $reservationService = $this->container->get('reservation');

        $reservations = $reservationService->getReservationsByUser();

        return [
            'reservations' => $reservations,
        ];
    }

    /**
     * Return reservations by book.
     *
     * @param string $slug
     * @return array
     *
     * @Template("DropTableLibraryBundle:Reservation:reservations.html.twig")
     */
    public function reservationsAction($slug)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $reservationService = $this->container->get('reservation');

        $book = $em->getRepository('DropTableLibraryBundle:Book')->findOneBySlug($slug);
        $reservations = $reservationService->getReservationsByBook($book);

        return [
            'reservations' => $reservations,
        ];
    }
}
