<?php

namespace DropTable\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package DropTable\UserBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Return my books, reserved/taken books.
     * @Template("DropTableLibraryBundle:Default:layout.html.twig")
     */
    public function indexAction()
    {
        return ['a' => 'b'];
    }
}
