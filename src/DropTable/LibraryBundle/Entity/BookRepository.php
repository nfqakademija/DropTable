<?php

namespace DropTable\LibraryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class BookRepository.
 *
 * @package DropTable\LibraryBundle\Entity
 */
class BookRepository extends EntityRepository
{
    /**
     * Function findAvailableOwners.
     *
     * @param string $slug
     *
     * @return array
     */
    public function findBooksByCategory($slug)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $result = $qb->select('book')
            ->from('DropTableLibraryBundle:Book', 'book')
            ->innerJoin('book.categories', 'category')
            ->where('category.slug = :slug')->setParameter('slug', $slug)
            ->getQuery()
            ->execute();

        return $result;
    }
}
