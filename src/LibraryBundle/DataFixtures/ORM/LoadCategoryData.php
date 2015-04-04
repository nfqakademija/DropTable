<?php
namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LibraryBundle\Entity\Book;
use LibraryBundle\Entity\Category;
use LibraryBundle\Entity\Status;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setName('Detektyvas');
        $this->addReference('category1', $category1);

        $category2 = new Category();
        $category2->setName('Romanas');
        $this->addReference('category2', $category2);

        $category3 = new Category();
        $category3->setName('Proza');
        $this->addReference('category3', $category3);

        $category4 = new Category();
        $category4->setName('Biografija');
        $this->addReference('category4', $category4);

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}