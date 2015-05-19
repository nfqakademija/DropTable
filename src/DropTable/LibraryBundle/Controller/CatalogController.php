<?php

namespace DropTable\LibraryBundle\Controller;

use DropTable\LibraryBundle\Form\Type\SearchOnlineType;
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
     * @internal param string $name
     * @return JsonResponse
     */
    public function addCategoryAction()
    {
        $catalog = $this->container->get('catalog');

        $subCatNames = json_decode($this->get('request')->getContent(), true);

        // Get all existing categories.
        $existCat = $catalog->listCategories();

        // Put existing categories' names into array.
        $existCatNames = [];
        foreach ($existCat as $category) {
            $existCatNames[] = $category->getName();
        }

        // Iterate over submitted categories and check if they exist in db already.
        $newCatsNames = [];
        $newIds = [];
        foreach ($subCatNames as $category) {
            if (!in_array($category, $existCatNames)) {
                $newIds[] = $catalog->createCategory($category);
                $newCatsNames[] = $category;
            }
        }
        $newCats = array_combine($newIds, $newCatsNames);

        return new JsonResponse(json_encode($newCats));
    }

    /**
     * @internal param string $name
     * @return JsonResponse
     */
    public function addAuthorAction()
    {
        $catalog = $this->container->get('catalog');

        $subAuthsNames = json_decode($this->get('request')->getContent(), true);

        // Get all existing authors.
        $existAuths = $catalog->listAuthors();

        // Put existing authors' names into array.
        $existAuthsNames = [];
        foreach ($existAuths as $author) {
            $existAuthsNames[] = $author->getName();
        }

        // Iterate over submitted authors and check if they exist in db already.
        $newAuthsNames = [];
        $newIds = [];
        foreach ($subAuthsNames as $author) {
            if (!in_array($author, $existAuthsNames)) {
                $newIds[] = $catalog->createAuthor($author);
                $newAuthsNames[] = $author;
            }
        }
        $newAuths = array_combine($newIds, $newAuthsNames);

        return new JsonResponse(json_encode($newAuths));
    }

    /**
     * @internal param string $name
     * @return JsonResponse
     */
    public function addPublisherAction()
    {
        $catalog = $this->container->get('catalog');

        $subAuthsNames = json_decode($this->get('request')->getContent(), true);

        // Get all existing authors.
        $existAuths = $catalog->listPublishers();
        // Put existing authors' names into array.
        $existAuthsNames = [];
        foreach ($existAuths as $author) {
            $existAuthsNames[] = $author->getName();
        }

        // Iterate over submitted authors and check if they exist in db already.
        $newAuthsNames = [];
        $newIds = [];
        foreach ($subAuthsNames as $author) {
            if (!in_array($author, $existAuthsNames)) {
                $newIds[] = $catalog->createPublisher($author);
                $newAuthsNames[] = $author;
            }
        }
        $newAuths = array_combine($newIds, $newAuthsNames);

        return new JsonResponse(json_encode($newAuths));
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
        $catalog = $this->container->get('catalog');
        $reservation = $this->container->get('reservation');
        $googleService = $this->container->get('provider.google');
        $form = $this->createForm(new SearchOnlineType());
        $book_form = $this->createForm(new BookType($catalog));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $book = $googleService->getBook($data['isbn']);

            $em = $this->container->get('doctrine.orm.entity_manager');

            foreach ($book as $b) {
                if ($b->getPublisher()) {
                    if (!($catalog->findPublisher($b->getPublisher()->getName()))) {
                        $em->persist($b);
                    }
                }
            }
            $em->flush();

            $book_form->setData($book[0]);

            return [
                'form' => $book_form->createView(),
            ];
        }

        $book_form->handleRequest($request);
        if ($book_form->isValid()) {
            $book = $book_form->getData();

            $slug = $catalog->addBook($book);

            return $this->redirectToRoute('catalog.book', ['slug' => $slug]);
        }

        return [
            'form' => $form->createView(),
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
        $catalog = $this->container->get('catalog');

        $book = $em->getRepository('DropTableLibraryBundle:Book')->findOneBySlug($slug);
        $book_form = $this->createForm(new BookType($catalog), $book);

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
     * Action for deleting book.
     *
     * @param string $slug
     * @return array
     *
     * @Template()
     */
    public function deleteAction($slug)
    {
        $catalog = $this->container->get('catalog');
        $reservation = $this->container->get('reservation');

        $book = $catalog->getBookBySlug($slug);

        $reservation->removeReservationsByBook($book);
        $catalog->removeBookOwner($book);

        return new JsonResponse();
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

        $book = $em->getBookBySlug($slug);

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
        $catalogService = $this->get('catalog');
        $reservationService = $this->get('reservation');

        $owners = $catalogService->getMyBooks();
        $reservations = $reservationService->getMyBooksReservations($owners);

        return [
            'owners' => $owners,
            'reservations' => $reservations,
        ];
    }

    /**
     * Search book by title or isbn.
     *
     * @Template()
     * @param string $key
     * @return array
     */
    public function searchAction($key)
    {
        $catalogService = $this->container->get('catalog');
        $book = $catalogService->search($key);

        return [
            'book' => $book,
        ];
    }
}
