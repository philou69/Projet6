<?php

namespace ObservationBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use ObservationBundle\Entity\User;

/**
 * BirdsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BirdRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Fonction pour paginer la liste d'oiseaux
     */
    public function getPage($page, $numbers, $search = null)
    {
        $query = $this->createQueryBuilder('b');
        if ($search !== null) {
            $query
                ->orWhere('b.lbNom LIKE :regex')
                ->setParameter('regex', "%$search%")
                ->orWhere("b.nomVern LIKE :regex2")
                ->setParameter('regex2', "%$search%");
        }
        $query->orderBy('b.nomVern', 'ASC')
            ->addOrderBy('b.lbNom', 'ASC')->getQuery();

        $query->setFirstResult(($page - 1) * $numbers)->setMaxResults($numbers);

        return new Paginator($query, true);
    }

    public function findForValidate(User $user)
    {
        $query = $this->createQueryBuilder('b')
            ->innerJoin('b.observations', 'o')
            ->where('o.user = :user')
            ->setParameter('user', $user)
            ->andWhere('o.validated = true');

        return $query->getQuery()->getResult();
    }
}
