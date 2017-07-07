<?php

namespace ObservationBundle\Repository;

use ObservationBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PictureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PictureRepository extends \Doctrine\ORM\EntityRepository
{

    public function getPictureGallery()
    {

        $qb = $this->createQueryBuilder('p');
        $query = $qb
//            ->select('p.url')
            ->leftJoin('p.observation', 'obs')
            ->where('obs.validated = true ')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(4);

        return $query->getQuery()
            ->getResult();
    }

    public function findForValidate(User $user)
    {
        $query = $this->createQueryBuilder('p')
            ->innerJoin('p.observation', 'o')
            ->where('o.user = :user')
            ->setParameter('user', $user)
            ->andWhere('o.validated = true');

        return $query->getQuery()->getResult();
    }

    public function getUserPicture(){
        $query = $this->createQueryBuilder('p')
            ->innerJoin('p.observation', 'o');

        return $query->getQuery()->getResult();
    }

    public function getPage($page, $numbers)
    {
        $query = $this->createQueryBuilder('p');
        // On regarde s'il s'agit d'une recherche

        $query->leftJoin('p.observation', 'o')
              ->orderBy('p.id', 'DESC');

        $query->setFirstResult(($page - 1) * $numbers)->setMaxResults($numbers);

        return new Paginator($query, true);
    }
}
