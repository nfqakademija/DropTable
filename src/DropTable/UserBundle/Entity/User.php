<?php

namespace DropTable\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45, nullable=true)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date", nullable=true)
     */
    private $createdAt;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
//     */
//    protected $facebook_id;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
//     */
//    protected $facebook_access_token;

    /**
     * Set firstName.
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

//    /**
//     * Set facebook_id.
//     *
//     * @param $facebook_id
//     * @return $this
//     */
//    public function setFacebook_id($facebook_id)
//    {
//        $this->facebook_id = $facebook_id;
//
//        return $this;
//    }
//
//    /**
//     * Get facebook_id.
//     *
//     * @return string
//     */
//    public function getFacebook_id()
//    {
//        return $this->facebook_id;
//    }
//
//    /**
//     * Set facebook_access_token.
//     *
//     * @param $facebook_access_token
//     * @return $this
//     */
//    public function setfacebook_access_token($facebook_access_token)
//    {
//        $this->facebook_access_token = $facebook_access_token;
//
//        return $this;
//    }
//
//    /**
//     * Get facebook_access_token.
//     *
//     * @return string
//     */
//    public function getfacebook_access_token()
//    {
//        return $this->facebook_access_token;
//    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->setUsername($email);

        return parent::setEmail($email);
    }

}
