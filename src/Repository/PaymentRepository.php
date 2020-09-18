<?php

namespace App\Repository;

use App\Entity\User;

class PaymentRepository
{
    public static function findAllYearsOfUser($connection, $user_id)
    {
        // SQL
        $sql = "SELECT year FROM payments WHERE user_id = ".$user_id." GROUP BY year"; 
        $prepare = $connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetchAll();
    }

    public static function getTotalPaidByUserId($connection, $user_id)
    {
        $sql = "SELECT SUM(amount) AS 'total' FROM payments WHERE user_id = ".$user_id; 
        $prepare = $connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetch();
    }

    public static function deleteAllPaymentsByUserId($connection, User $user)
    {
        $sql = "DELETE FROM payments WHERE user_id = ".$user->getId(); 
        $prepare = $connection->prepare($sql);
        $prepare->execute();
    }
}