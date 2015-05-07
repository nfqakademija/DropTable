<?php

namespace DropTable\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData.
 *
 * @package DropTable\UserBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $test_password = 'test';

        $factory = $this->container->get('security.encoder_factory');


        /** @var $manager \FOS\UserBundle\Doctrine\UserManager */
        $manager = $this->container->get('fos_user.user_manager');

        /** @var $user \DropTable\UserBundle\Entity\User */
        $user = $manager->createUser();

        $user->setUsername('Admin');
        $user->setEmail('admin@droptable.lt');
        $user->setFirstname('Admin');
        $user->setLastname('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEnabled(true);
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($test_password, $user->getSalt());
        $user->setPassword($password);

        $manager->updateUser($user);

        $this->addReference('user1', $user);

        unset($user);

        /** @var $user \DropTable\UserBundle\Entity\User */
        $user = $manager->createUser();

        $user->setUsername('User');
        $user->setEmail('user@droptable.lt');
        $user->setFirstname('User');
        $user->setLastname('User');
        $user->setRoles(['ROLE_USER']);
        $user->setEnabled(true);
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($test_password, $user->getSalt());
        $user->setPassword($password);

        $manager->updateUser($user);

        $this->addReference('user2', $user);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
