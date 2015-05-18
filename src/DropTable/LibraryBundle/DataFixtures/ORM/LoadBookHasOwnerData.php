<?php

namespace DropTable\LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DropTable\LibraryBundle\Entity\BookHasOwner;

/**
 * Class LoadBookHasOwnerData.
 *
 * @package DropTable\LibraryBundle\DataFixtures\ORM
 */
class LoadBookHasOwnerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $owner1 = new BookHasOwner();
        $owner1->setBook($this->getReference('book1'));
        $owner1->setUser($this->getReference('user1'));

        $owner2 = new BookHasOwner();
        $owner2->setBook($this->getReference('book2'));
        $owner2->setUser($this->getReference('user1'));

        $owner3 = new BookHasOwner();
        $owner3->setBook($this->getReference('book1'));
        $owner3->setUser($this->getReference('user2'));

        $this->setReference('owner1', $owner1);
        $this->setReference('owner2', $owner2);

        $manager->persist($owner1);
        $manager->persist($owner2);
        $manager->persist($owner3);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
