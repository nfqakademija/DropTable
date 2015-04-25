<?php

namespace DropTable\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DropTable\UserBundle\Entity\User;

/**
 * Class LoadUserData.
 *
 * @package DropTable\UserBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('Vardenis');
        $user1->setLastName('Pavardenis');
        $user1->setUsername('user1@');

        $user2 = new User();
        $user2->setFirstName('Vardenis1');
        $user2->setLastName('Pavardenis1');
        $user2->setUsername('user2@');

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
