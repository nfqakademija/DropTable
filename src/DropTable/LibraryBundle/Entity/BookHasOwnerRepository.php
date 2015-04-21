<?php

namespace DropTable\LibraryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BookHasOwnerRepository extends EntityRepository
{
    public function findAllAvailableOwners(Book $book)
    {
        $book_id = $book->getId();


        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('owner')
            ->from('DropTableLibraryBundle:BookHasOwner', 'owner')
            ->leftJoin('DropTableLibraryBundle:UserHasReservation', 'reservation', 'WITH', 'reservation.bookHasOwner = owner')
//            ->where('owner.id = :ids')
//            ->setParameter('id', '')
            ->getQuery()
            ->getResult();

        return $qb;
    }
}