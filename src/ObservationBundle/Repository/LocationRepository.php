<?php

namespace ObservationBundle\Repository;

use ObservationBundle\Entity\User;
use ObservationBundle\Entity\Bird;

/**
 * LocationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LocationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findForValidate(User $user)
    {
        $query = $this->createQueryBuilder('l');
        $query->innerJoin('l.observations', 'o')
            ->where('o.validated = true')
            ->andWhere('o.user = :user')
            ->setParameter('user', $user);

        return $query->getQuery()->getResult();
    }

    public function findBirdLocations(Bird $bird)
    {
        $query = $this->createQueryBuilder('l')
            ->innerJoin('l.observations', 'o')
            ->addSelect('o')
            ->where('o.bird = :bird')
            ->setParameter('bird', $bird)
            ->getQuery()
            ->getArrayResult();

        return $query;
    }

    public function findForCSV()
    {
        $query = $this->createQueryBuilder('l');
        return $query->getQuery()->getArrayResult();

    }
}
