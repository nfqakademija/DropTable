<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;
use UserBundle\Entity\Role;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('John');
        $user1->setLastName('Marks');
        $user1->setUsername('Johnie');
        $user1->setPassword('QWERTY123');
        $user1->setCreatedAt(new \DateTime());
        $user1->setSalt('4f6we48fwefweg648egEe6gweEF');
        $user1->setIsDeleted(0);

        $user2 = new User();
        $user2->setFirstName('John');
        $user2->setLastName('Marks');
        $user2->setUsername('Johnie');
        $user2->setPassword('QWERTY123');
        $user2->setCreatedAt(new \DateTime());
        $user2->setSalt('4f6we48fwefweg648egEe6gweEF');
        $user2->setIsDeleted(0);

        $user3 = new User();
        $user3->setFirstName('John');
        $user3->setLastName('Marks');
        $user3->setUsername('Johnie');
        $user3->setPassword('QWERTY123');
        $user3->setCreatedAt(new \DateTime());
        $user3->setSalt('4f6we48fwefweg648egEe6gweEF');
        $user3->setIsDeleted(0);

        $user4 = new User();
        $user4->setFirstName('John');
        $user4->setLastName('Marks');
        $user4->setUsername('Johnie');
        $user4->setPassword('QWERTY123');
        $user4->setCreatedAt(new \DateTime());
        $user4->setSalt('4f6we48fwefweg648egEe6gweEF');
        $user4->setIsDeleted(0);

        $user5 = new User();
        $user5->setFirstName('John');
        $user5->setLastName('Marks');
        $user5->setUsername('Johnie');
        $user5->setPassword('QWERTY123');
        $user5->setCreatedAt(new \DateTime());
        $user5->setSalt('4f6we48fwefweg648egEe6gweEF');
        $user5->setIsDeleted(0);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}