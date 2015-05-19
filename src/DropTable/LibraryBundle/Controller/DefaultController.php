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

        $books = $catalog->getNewestBooks(20);

        return [
            'books' => $books,
        ];
    }
}
