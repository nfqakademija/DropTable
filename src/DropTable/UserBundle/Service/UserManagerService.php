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
     * @param int $userId
     * @return null|object
     */
    public function getUserById($userId)
    {
        return $this->em->getRepository('DropTableUserBundle:User')->find($userId);
    }

    /**
     * Disable a user if is enabled and the other way round.
     * @param int $userId
     */
    public function toggleEnabled($userId)
    {
        $user = $this->getUserById($userId);

        if ($user->isEnabled()) {
            $user->setEnabled(0);
        } else {
            $user->setEnabled(1);
        }

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Unlock a user if is locked and the other way round.
     * @param int $userId
     */
    public function toggleLocked($userId)
    {
        $user = $this->getUserById($userId);

        if ($user->isLocked()) {
            $user->setLocked(0);
        } else {
            $user->setLocked(1);
        }

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Promote user to admin if is not admin and otherwise.
     * @param int $id
     */
    public function switchRole($id)
    {
        $user = $this->getUserById($id);

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $user->removeRole('ROLE_ADMIN');
        } else {
            $user->addRole('ROLE_ADMIN');
        }

        $this->em->persist($user);
        $this->em->flush();
    }
}
