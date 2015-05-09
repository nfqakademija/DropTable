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
        $userManager = $this->container->get('user_manager');

        $users = $userManager->listUsers();

        return [
            'users' => $users,
        ];
    }

    /**
     * Disable a user if is enabled and the other way round.
     * @param int $userId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleEnabledAction($userId)
    {
        $userManager = $this->container->get('user_manager');

        $userManager->toggleEnabled($userId);

        return $this->redirectToRoute('admin_list_users');
    }

    /**
     * Unlock a user if is locked and the other way round.
     * @param int $userId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleLockedAction($userId)
    {
        $userManager = $this->container->get('user_manager');

        $userManager->toggleLocked($userId);

        return $this->redirectToRoute('admin_list_users');
    }

    /**
     * Promote user to admin if is not admin and otherwise.
     * @param int $userId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function switchRoleAction($userId)
    {
        $userManager = $this->container->get('user_manager');

        $userManager->switchRole($userId);

        return $this->redirectToRoute('admin_list_users');
    }
}
