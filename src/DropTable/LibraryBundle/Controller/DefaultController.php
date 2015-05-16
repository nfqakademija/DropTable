<?php

namespace DropTable\LibraryBundle\Controller;

use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Form\Type\BookType;
use DropTable\LibraryBundle\Form\Type\SearchOnlineType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package DropTable\LibraryBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Render homepage.
     * @Template()
     */
    public function indexAction()
    {
        $catalog = $this->container->get('catalog');

        $books = $catalog->getNewestBooks(10);

        return [
            'books' => $books,
        ];

/**        $catalog = $this->container->get('catalog');
        $reservation = $this->container->get('reservation');

        //getBookOnlineByISBN('0395714060');

        /** @var Book $book
        $book = $catalog->getBookById(10);

        $form = $this->createForm(new BookType(), $book);
        $book = $catalog->getAvailableOwner($book);
        return [
            'name' => $book,
            'form' => $form->createView()
        ];
*/
    }

    /**
     * @Route("/search")
     * @Template()
     */
    public function searchAction()
    {
        $catalog = $this->container->get('catalog');
        $reservation = $this->container->get('reservation');

        //getBookOnlineByISBN('0395714060');

        /** @var Book $book */
        $book = $catalog->getBookById(10);

        $form = $this->createForm(new SearchOnlineType());

        return [
            'name' => $book,
            'form' => $form->createView(),
        ];
    }
}
