<?php

namespace DropTable\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Author.
 *
 * @ORM\Table(
 *     name="publisher",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="publisher_name_UNIQUE", columns={"name"})}
 * )
 * @ORM\Entity
 */
class Publisher
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="publishers")
     */
    private $books;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->books = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Publisher
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add books
     *
     * @param \DropTable\LibraryBundle\Entity\Book $books
     * @return Publisher
     */
    public function addBook(\DropTable\LibraryBundle\Entity\Book $books)
    {
        $this->books[] = $books;

        return $this;
    }

    /**
     * Remove books
     *
     * @param \DropTable\LibraryBundle\Entity\Book $books
     */
    public function removeBook(\DropTable\LibraryBundle\Entity\Book $books)
    {
        $this->books->removeElement($books);
    }

    /**
     * Get books
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBooks()
    {
        return $this->books;
    }
}
