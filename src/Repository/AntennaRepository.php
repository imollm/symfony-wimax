<?php

namespace App\Repository;

use App\Entity\User;

class AntennaRepository 
{
    public static function setNullUserId($connection, User $user)
    {
        $sql = "UPDATE antennas SET user_id = NULL WHERE user_id = " . $user->getId(); 
        $prepare = $connection->prepare($sql);
        $prepare->execute();
    }
}