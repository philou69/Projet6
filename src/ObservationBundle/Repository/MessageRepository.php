<?php


namespace ObservationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function findAllOrdering()
    {
        $query = $this->createQueryBuilder('m');
        $query->add('orderBy', 'm.received ASC, m.answered ASC, m.postedAt DESC');

        return $query->getQuery()->getResult();
    }
}
