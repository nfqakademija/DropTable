<?php

namespace DropTable\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AdminController
 * @package DropTable\UserBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * List all users.
     * @Template("DropTableUserBundle:Admin:all_users.html.twig")
     */
    public function listAction()
    {
        $user = $this->container->get('user');

        $users = $user->listUsers();

        return [
            'users' => $users,
        ];
    }
}
