<?php

namespace DropTable\LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use DropTable\LibraryBundle\Entity\Book;
use DropTable\LibraryBundle\Form\Type\BookType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Catalog CatalogController
 * @package DropTable\LibraryBundle\Controller
 */
class CatalogController extends Controller
{
    /**
     * List all categories.
     *
     * @return array
     * @Template("DropTableLibraryBundle:Catalog:browse.html.twig")
     */
    public function listCategoriesAction()
    {
        $catalog = $this->container->get('catalog');
        $categories = $catalog->listCategories();

        return [
            'categories' => $categories,
        ];
    }

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
     * @param string $slug
     * @return array
     *
     * @Template("DropTableLibraryBundle:Catalog:list.html.twig")
     */
    public function listByCategoryAction($slug)
    {
        $catalog = $this->container->get('catalog');

        $book_list = $catalog->listBooksByCategory($slug);

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
     * @Template("DropTableLibraryBundle:Catalog:add.html.twig")
     */
    public function addAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $catalog = $this->container->get('catalog');

        $book = new Book();

        $book_form = $this->createForm(new BookType(), $book);

        $book_form->handleRequest($request);
        if ($book_form->isValid()) {
            $slug = $catalog->addBook($book);

            return $this->redirectToRoute('catalog.book', ['slug' => $slug]);
        }

        return [
            'form' => $book_form->createView(),
        ];
    }

    /**
     * Action to edit book.
     *
     * @param Request $request
     * @param string  $slug
     * @return array
     *
     * @Template("DropTableLibraryBundle:Catalog:edit.html.twig")
     */
    public function editAction(Request $request, $slug)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $book = $em->getRepository('DropTableLibraryBundle:Book')->findOneBySlug($slug);
        $book_form = $this->createForm(new BookType(), $book);

        $a = $this->getRequest()->request;
        dump($a);

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
     * Create new category via AJAX call.
     *
     * @param string $name
     * @return Response
     */
    public function createCategoryViaAjaxAction($name)
    {
        $catalog = $this->container->get('catalog');
        $existingCategories = $catalog->listCategories();
        dump($existingCategories);

        dump($catalog->createCategoryViaAjax($name));

        return new Response('');
    }

    /**
     * Action for deleting book.
     *
     * @param string $slug
     * @return array
     *
     * @Template()
     */
    public function deleteAction($slug)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $book = $em->getRepository('DropTableLibraryBundle:Book')->findOneBySlug($slug);
        $em->remove($book);
        $em->flush();

        return new JsonResponse(['status' => 'success']);
    }

    /**
     * Get book by slug.
     *
     * @param string $slug
     * @return array
     *
     * @Template()
     */
    public function bookAction($slug)
    {
        $em = $this->get('catalog');

        $book = $em->getBookById($slug);

        return [
            'book' => $book,
        ];
    }

    /**
     * Get Owners by book.
     *
     * @param string $slug
     * @return array
     *
     * @Template("DropTableLibraryBundle:Catalog:owners.html.twig")
     */
    public function ownersAction($slug)
    {
        $em = $this->get('catalog');

        $owners = $em->getOwnersByBook($slug);

        return [
            'owners' => $owners,
        ];
    }

    /**
     * Get my books.
     *
     * @return array
     *
     * @Template()
     */
    public function myBooksAction()
    {
        $em = $this->get('catalog');

        $owners = $em->getMyBooks();

        return [
            'owners' => $owners,
        ];
    }
}
