<?php

namespace App\Repository;

class PaymentRepository
{
    public static function findAllYearsOfUser($user_id, $connection)
    {
        // SQL
        $sql = "SELECT year FROM payments WHERE user_id = ".$user_id." GROUP BY year"; 
        $prepare = $connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetchAll();
    }
}