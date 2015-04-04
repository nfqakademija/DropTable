<?php

namespace LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use LibraryBundle\Entity\Book;
use LibraryBundle\Form\Type\BookType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;

/**
 * @Route(service="library.book_controller")
 */
class BookController
{
    /** @var EntityManager */
    protected $em;

    /** @var FormFactory */
    protected $formFactory;

    public function __construct(EntityManager $em, FormFactory $formFactory)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    /**
     * @Route("/books/list")
     * @Template()
     */
    public function listAction()
    {
        $book_list = $this->em->getRepository('LibraryBundle:Book')->findAll();

        return [
            'list' => $book_list
        ];
    }

    /**
     * @Route("/books/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $book = new Book();
        $book_form = $this->formFactory->create(new BookType(), $book);

        $book_form->handleRequest($request);

        if($book_form->isValid()) {
            $this->em->persist($book);
            $this->em->flush();
        }

        return [
            'form' => $book_form->createView()
        ];
    }

    /**
     * @Route("/books/edit/{id}")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $book = $this->em->getRepository('LibraryBundle:Book')->find($id);
        $book_form = $this->formFactory->create(new BookType(), $book);

        $book_form->handleRequest($request);

        if($book_form->isValid()) {
            $this->em->persist($book);
            $this->em->flush();
        }

        return [
            'form' => $book_form->createView()
        ];
    }

    /**
     * @Route("/books/delete/{id}")
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $book = $this->em->getRepository('LibraryBundle:Book')->find($id);
        $this->em->remove($book);
        $this->em->flush();

        return new JsonResponse(['status' => 'success']);
    }
}
