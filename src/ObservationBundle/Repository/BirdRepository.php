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
    public function getPage($page, $numbers, $search = null, $couleurBec = null, $couleurPatte = null, $couleurPlumage = null, $typeBec = null)
    {
        $query = $this->createQueryBuilder('b');
        // On regarde s'il s'agit d'une recherche
        if ($search !== null) {
            $query
                ->orWhere('b.lbNom LIKE :regex')
                ->setParameter('regex', "%$search%")
                ->orWhere("b.nomVern LIKE :regex2")
                ->setParameter('regex2', "%$search%");
        }
        // On va vérifie les filtres sur bec pattes et bec
        if($couleurBec !== null){
            $query->andWhere('b.bec = :couleurBec')
                ->setParameter('couleurBec', $couleurBec);
        }
        if($couleurPatte !== null){
            $query->andWhere('b.patte = :couleurPatte')
                ->setParameter('couleurPatte', $couleurPatte);
        }
        if($couleurPlumage !== null){
            $query->andWhere('b.plumage = :couleurPlumage')
                ->setParameter('couleurPlumage', $couleurPlumage);
        }
        if($typeBec !== null){
            $query->andWhere('b.typeBec = :typeBec')
                ->setParameter('typeBec', $typeBec);
        }

        $query->orderBy('b.nameSearch', 'ASC')->getQuery();

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

    public function findAllSort()
    {
       $query= $this->createQueryBuilder('b');
       $query->orderBy('b.nameSearch', 'ASC');
       return $query->getQuery()->getResult();
    }

    public function findForCSV()
    {
        $query = $this->createQueryBuilder('b');
        return $query->getQuery()->getArrayResult();

    }
}
