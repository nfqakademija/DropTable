<?php
namespace UserBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $salt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_deleted;

    /**
     * @ORM\ManyToMany(targetEntity="\LibraryBundle\Entity\Book", inversedBy="user_reservation")
     * @ORM\JoinTable(
     *     name="book_has_reservation",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $book_reservation;

    /**
     * @ORM\ManyToMany(targetEntity="\LibraryBundle\Entity\Book", inversedBy="user_owner")
     * @ORM\JoinTable(
     *     name="book_has_owner",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $book_owner;

    /**
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="user")
     */
    private $role;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->book_reservation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->book_owner = new \Doctrine\Common\Collections\ArrayCollection();
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set is_deleted
     *
     * @param boolean $isDeleted
     * @return User
     */
    public function setIsDeleted($isDeleted)
    {
        $this->is_deleted = $isDeleted;

        return $this;
    }

    /**
     * Get is_deleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Add book_reservation
     *
     * @param \UserBundle\Entity\Book $bookReservation
     * @return User
     */
    public function addBookReservation(\UserBundle\Entity\Book $bookReservation)
    {
        $this->book_reservation[] = $bookReservation;

        return $this;
    }

    /**
     * Remove book_reservation
     *
     * @param \UserBundle\Entity\Book $bookReservation
     */
    public function removeBookReservation(\UserBundle\Entity\Book $bookReservation)
    {
        $this->book_reservation->removeElement($bookReservation);
    }

    /**
     * Get book_reservation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBookReservation()
    {
        return $this->book_reservation;
    }

    /**
     * Add book_owner
     *
     * @param \UserBundle\Entity\Book $bookOwner
     * @return User
     */
    public function addBookOwner(\UserBundle\Entity\Book $bookOwner)
    {
        $this->book_owner[] = $bookOwner;

        return $this;
    }

    /**
     * Remove book_owner
     *
     * @param \UserBundle\Entity\Book $bookOwner
     */
    public function removeBookOwner(\UserBundle\Entity\Book $bookOwner)
    {
        $this->book_owner->removeElement($bookOwner);
    }

    /**
     * Get book_owner
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBookOwner()
    {
        return $this->book_owner;
    }

    /**
     * Add role
     *
     * @param \UserBundle\Entity\Role $role
     * @return User
     */
    public function addRole(\UserBundle\Entity\Role $role)
    {
        $this->role[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \UserBundle\Entity\Role $role
     */
    public function removeRole(\UserBundle\Entity\Role $role)
    {
        $this->role->removeElement($role);
    }

    /**
     * Get role
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole()
    {
        return $this->role;
    }
}
