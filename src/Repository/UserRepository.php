<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
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
}