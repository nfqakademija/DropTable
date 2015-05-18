<?php

namespace DropTable\LibraryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserHasReservationRepository.
 *
 * @package DropTable\LibraryBundle\Entity
 */
class UserHasReservationRepository extends EntityRepository
{
    /**
     * Function findMyBooksReservations.
     *
     * @param array $owners
     *
     * @return array
     */
    public function findMyBooksReservations($owners)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('UHR')
            ->from('DropTableLibraryBundle:UserHasReservation', 'UHR')
            ->where('UHR.bookHasOwner IN (:owners)')
            ->setParameter('owners', $owners)
            ->getQuery()
            ->getResult();

        return $qb;
    }
}
