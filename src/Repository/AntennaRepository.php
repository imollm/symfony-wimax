<?php

namespace App\Repository;

use App\Entity\Antenna;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AntennaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Antenna::class);
    }
    public static function setNullUserId($connection, User $user)
    {
        $sql = "UPDATE antennas SET user_id = NULL WHERE user_id = " . $user->getId(); 
        $prepare = $connection->prepare($sql);
        $prepare->execute();
    }

    public function findById($id) {
        return $this->getEntityManager()->find(Antenna::class, $id);
    }
}