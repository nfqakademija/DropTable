<?php
namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DropTable\LibraryBundle\Entity\Category;

/**
 * Class LoadCategoryData.
 *
 * @package LibraryBundle\DataFixtures\ORM
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setName('Detektyvas');
        $this->addReference('Detektyvas', $category1);

        $category2 = new Category();
        $category2->setName('Romanas');
        $this->addReference('Romanas', $category2);

        $category3 = new Category();
        $category3->setName('Proza');
        $this->addReference('Proza', $category3);

        $category4 = new Category();
        $category4->setName('Biografija');
        $this->addReference('Biografija', $category4);

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);
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
