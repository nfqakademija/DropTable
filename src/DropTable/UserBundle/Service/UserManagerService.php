<?php

namespace DropTable\UserBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class UserService
 * @package DropTable\UserBundle\Service
 */
class UserManagerService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * List all users.
     * @return array
     */
    public function listUsers()
    {
        return $this->em->getRepository('DropTableUserBundle:User')->findAll();
    }

    /**
     * Find user by id.
     * @param $id
     * @return null|object
     */
    public function getUserById($id)
    {
        return $this->em->getRepository('DropTableUserBundle:User')->find($id);
    }

    /**
     * Disable a user.
     * @param $id
     */
    public function disableUser($id)
    {
        $user = $this->getUserById($id);
        $user->setEnabled(0);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Enable a user.
     * @param $id
     */
    public function enableUser($id)
    {
        $user = $this->getUserById($id);
        $user->setEnabled(1);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Lock a user.
     * @param $id
     */
    public function lockUser($id)
    {
        $user = $this->getUserById($id);
        $user->setLocked(1);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Unlock a user.
     * @param $id
     */
    public function unlockUser($id)
    {
        $user = $this->getUserById($id);
        $user->setLocked(0);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Promote user to admin.
     * @param $id
     */
    public function promoteToAdmin($id)
    {
        $user = $this->getUserById($id);
        $user->addRole('ROLE_ADMIN');

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Remove admin rights from a user.
     * @param $id
     */
    public function demoteToUser($id)
    {
        $user = $this->getUserById($id);
        $user->removeRole('ROLE_ADMIN');

        $this->em->persist($user);
        $this->em->flush();
    }
}
