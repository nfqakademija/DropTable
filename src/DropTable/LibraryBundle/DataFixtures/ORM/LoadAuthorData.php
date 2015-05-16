<?php

namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DropTable\LibraryBundle\Entity\Author;

/**
 * Class LoadCategoryData.
 *
 * @package LibraryBundle\DataFixtures\ORM
 */
class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $author1 = new Author();
        $author1->setName('Jussi Adler-Olsen');
        $this->addReference('Author1', $author1);

        $author2 = new Author();
        $author2->setName('Michael Ondaatje');
        $this->addReference('Author2', $author2);

        $author3 = new Author();
        $author3->setName('Santa Montefiore');
        $this->addReference('Author3', $author3);

        $author4 = new Author();
        $author4->setName('Tomas Šinkariukas');
        $this->addReference('Author4', $author4);

        $author5 = new Author();
        $author5->setName('Emma Goldman');
        $this->addReference('Author5', $author5);

        $manager->persist($author1);
        $manager->persist($author2);
        $manager->persist($author3);
        $manager->persist($author4);
        $manager->persist($author5);
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
