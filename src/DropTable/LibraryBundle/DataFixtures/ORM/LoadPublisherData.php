<?php

namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DropTable\LibraryBundle\Entity\Publisher;

/**
 * Class LoadCategoryData.
 *
 * @package LibraryBundle\DataFixtures\ORM
 */
class LoadPublisherData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $publisher1 = new Publisher();
        $publisher1->setName('Obuolys');
        $this->addReference('Publisher1', $publisher1);

        $publisher2 = new Publisher();
        $publisher2->setName('Alma Littera');
        $this->addReference('Publisher2', $publisher2);

        $publisher3 = new Publisher();
        $publisher3->setName('Kitos knygos');
        $this->addReference('Publisher3', $publisher3);

        $publisher4 = new Publisher();
        $publisher4->setName('Tyto Alba');
        $this->addReference('Publisher4', $publisher4);

        $manager->persist($publisher1);
        $manager->persist($publisher2);
        $manager->persist($publisher3);
        $manager->persist($publisher4);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
