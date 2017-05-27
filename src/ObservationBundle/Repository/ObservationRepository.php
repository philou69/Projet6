<?php

namespace ObservationBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use ObservationBundle\Entity\Bird;
/**
 * ObservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findObs($status, $user, $page, $limit, $all)
    {
        $query = $this->createQueryBuilder('o');

        // On vérife lavaleur de all,
        // false veut dire qu'on cherche les observation de l'utilisateur qui sont validées ou non
        if (!$all) {
            $query->where('o.user = :user')
                ->andWhere('o.validated = :status')
                ->setParameter('user', $user);
        } else {
            // Si true on ne recherche sur la valeur de validated
            $query->where('o.validated = :status');
        }

        // On les trie par date de post
        $query->setParameter('status', $status)
            ->orderBy('o.postedAt', 'DESC')
            ->getQuery();
        // On récupere la quantité et on commence par page -1 fois la quantité.
        $query->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        // On retourné un objet Paginator qui contient la query et qui conserve les relations
        return new  Paginator($query, true);
    }

    public function findsByBird(Bird $bird, $page, $limit)
    {
        $query = $this->createQueryBuilder('o');
        $query->where('o.bird = :bird')
            ->setParameter('bird', $bird)
            ->orderBy('o.postedAt', 'DESC')
            ->getQuery();
        $query->setFirstResult(($page-1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($query, true);
    }

}
