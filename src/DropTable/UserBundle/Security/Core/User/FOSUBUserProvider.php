<?php

namespace DropTable\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FOSUBUserProvider
 * @package DropTable\UserBundle\Security\Core\User
 */
class FOSUBUserProvider extends BaseClass
{
    /**
     * Connect a user with social network providers.
     * @param UserInterface         $user
     * @param UserResponseInterface $response
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        // On connect - get the access token and the user ID.
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';

        // We "disconnect" previously connected users.
        if (null !== $previousUser = $this->userManager->findUserBy([$property => $username])) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        // We connect current user.
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * Create new user when registering with Facebook or other provider.
     * @param UserResponseInterface $response
     * @param string                $username
     * @param string                $email
     */
    public function createNewUser(UserResponseInterface $response, $username, $email)
    {
        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
        // Create new user here.
        $user = $this->userManager->createUser();
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
        // TODO: Set to "normal" values. First name, last name, facebook id needed.
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword('');
        $user->setEnabled(true);
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $email = $response->getEmail();
        $user = $this->userManager->findUserBy([$this->getProperty($response) => $username]);
        // When the user is registering.
        if (null === $user) {
            $this->createNewUser($response, $username, $email);

            return $user;
        }

        // If user exists - go with the HWIOAuth way.
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        // Update access token.
        $user->$setter($response->getAccessToken());

        return $user;
    }

}
