<?php

namespace App\Repository;

use App\Entity\Antenna;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByRole(string $role)
    {
        return $this->getEntityManager()
        ->createQuery(
            'SELECT u 
            FROM App\Entity\User u 
            WHERE u.role = :role'
        )
        ->setParameter('role', $role)
        ->getResult();
    }

    public function findAll()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u.name, u.id
                FROM App\Entity\User u'
            )
            ->getResult();
    }

    public function findById($id)
    {
        return $this->getEntityManager()->find(User::class, $id);
    }

    public function findWithContract()
    {
        $dql = "SELECT u
                FROM App\Entity\User u
                INNER JOIN App\Entity\Antenna a 
                WITH u.id = a.user 
                WHERE u.role = 'ROLE_USER'
                GROUP BY u.id";

        return $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
    }
}