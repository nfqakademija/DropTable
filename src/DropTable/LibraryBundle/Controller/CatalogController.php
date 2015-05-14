<?php

namespace DropTable\LibraryBundle\Controller;

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
class CatalogController extends Controller
{
    /**
     * Action for listing all books.
     *
     * @Template()
     */
    public function listAction()
    {
        $catalog = $this->container->get('catalog');

        $book_list = $catalog->listBooks();

        return [
            'list' => $book_list,
        ];
    }

    /**
     * Action for listing all books.
     *
     * @param string $category
     * @return array
     *
     * @Template("DropTableLibraryBundle:Book:list.html.twig")
     */
    public function listByCategoryAction($category)
    {
        $catalog = $this->container->get('catalog');

        $book_list = $catalog->listBooksByCategory($category);

        return [
            'list' => $book_list,
        ];
    }

    /**
     * Action to add new book.
     *
     * @param Request $request
     * @return array
     *
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $catalog = $this->container->get('catalog');

        $book = new Book();
        $book_form = $this->createForm(new BookType(), $book);

        $book_form->handleRequest($request);
        if ($book_form->isValid()) {
            $catalog->addBook($book);
        }

        return [
            'form' => $book_form->createView(),
        ];
    }

    /**
     * Action to edit book.
     *
     * @param Request $request
     * @param int     $id
     * @return array
     *
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $book = $em->getRepository('DropTableLibraryBundle:Book')->find($id);
        $book_form = $this->createForm(new BookType(), $book);

        $book_form->handleRequest($request);
        if ($book_form->isValid()) {
            $em->persist($book);
            $em->flush();
        }

        return [
            'form' => $book_form->createView(),
        ];
    }

    /**
     * Action for deleteing book.
     *
     * @param int $id
     * @return array
     *
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $book = $em->getRepository('DropTableLibraryBundle:Book')->find($id);
        $em->remove($book);
        $em->flush();

        return new JsonResponse(['status' => 'success']);
    }
}
