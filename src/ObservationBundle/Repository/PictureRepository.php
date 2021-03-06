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

        $query = $this->createQueryBuilder('p');
        $query->where('p.bird IS NOT null')
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

    public function getPage($page, $numbers, $filters)
    {
        $query = $this->createQueryBuilder('p');

        $query->join('p.observation', 'o')
            ->addSelect('o')
            ->where('p.bird IS NOT NULL')
            ->orderBy('p.id', 'DESC');
        // On regarde s'il s'agit d'une recherche

        if ($filters !== null) {
            $query
                ->andWhere('o.bird = :bird')
                ->setParameter('bird', $filters);
        }



        $query->setFirstResult(($page - 1) * $numbers)->setMaxResults($numbers);

        return new Paginator($query, true);
    }
}
