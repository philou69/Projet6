<?php


namespace ObservationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function findAllOrdering()
    {
        $query = $this->createQueryBuilder('m');
        $query->orderBy('m.postedAt', 'DESC')
            ->addOrderBy('m.received', 'DESC')
            ->addOrderBy('m.answered', 'DESC');

        return $query->getQuery()->getResult();
    }
}