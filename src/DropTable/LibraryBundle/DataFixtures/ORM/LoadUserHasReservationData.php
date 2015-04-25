<?php
namespace DropTable\LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DropTable\LibraryBundle\Entity\UserHasReservation;

/**
 * Class LoadUserHasReservationData.
 *
 * @package DropTable\LibraryBundle\DataFixtures\ORM
 */
class LoadUserHasReservationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $reservation1 = new UserHasReservation();
        $reservation1->setUser($this->getReference('user1'));
        $reservation1->setBook($this->getReference('book1'));
        $reservation1->setBookHasOwner($this->getReference('owner1'));

        $reservation2 = new UserHasReservation();
        $reservation2->setUser($this->getReference('user2'));
        $reservation2->setBook($this->getReference('book1'));

        $reservation3 = new UserHasReservation();
        $reservation3->setUser($this->getReference('user1'));
        $reservation3->setBook($this->getReference('book2'));
        $reservation3->setBookHasOwner($this->getReference('owner2'));

        $manager->persist($reservation1);
        $manager->persist($reservation2);
        $manager->persist($reservation3);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }
}
