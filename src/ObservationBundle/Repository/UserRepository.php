<?php


namespace ObservationBundle\Repository;


use Doctrine\ORM\EntityRepository;
use ObservationBundle\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findUsernames($username)
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->where('REGEXP(u.username, :regex) = true')
            ->setParameter('regex', '^' . $username . '[0-9]*$');

        return $queryBuilder->getQuery()
            ->getResult();
    }

    public function findAllOthers($id)
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.id != :id')
            ->setParameter('id', $id)
            ->orderBy('u.username', 'DESC');

        return $query->getQuery()->getResult();
    }
}
