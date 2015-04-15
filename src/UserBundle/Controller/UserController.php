<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller
{
    protected $em;

    public function __construct()
    {
        $this->em = $this->get('request');
        // parent::__construct();
    }
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        $this->em = $this->getDoctrine()->getManager();
        return array('name' => $name);
    }
}
