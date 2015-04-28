<?php

namespace DropTable\LibraryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class BookHasOwnerRepository.
 *
 * @package DropTable\LibraryBundle\Entity
 */
class BookHasOwnerRepository extends EntityRepository
{
    /**
     * Function findAllAvailableOwners.
     *
     * @param Book $book
     *
     * @return array
     */
    public function findAllAvailableOwner(Book $book)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('owner')
            ->from('DropTableLibraryBundle:BookHasOwner', 'owner')
            ->leftJoin(
                'DropTableLibraryBundle:UserHasReservation',
                'reservation',
                'WITH',
                'reservation.bookHasOwner = owner'
            )
            ->where('reservation.bookHasOwner IS NULL')
            ->andWhere('owner.book = :book_id')
            ->setParameter('book_id', $book)
            ->getQuery()
            ->getOneOrNullResult();

        return $qb;
    }
}
