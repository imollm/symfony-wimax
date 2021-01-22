<?php

namespace App\Repository;

use App\Entity\User;

class PaymentRepository
{
    public static function findYears($connection, $role, $userId)
    {
        $sql = "SELECT year FROM payments ";
        if ($role == 'ROLE_USER') {
            $sql .= "WHERE user_id = {$userId} ";
        }
        $sql .= "GROUP BY year";

        $prepare = $connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetchAll();
    }

    public static function findUsers($connection)
    {
        $sql = "SELECT u.id, CONCAT(u.name,' ',u.surname) as 'user' 
                FROM payments p 
                INNER JOIN users u 
                ON p.user_id = u.id 
                GROUP BY u.id";

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

    public static function getAllPayments($connection)
    {
        $sql = "SELECT  p.month, 
                        p.year, 
                        p.amount, 
                        p.created_at, 
                        CONCAT(u.name, ' ', u.surname) AS 'user',
                        u.id
                FROM payments p 
                INNER JOIN users u
                ON p.user_id = u.id
                ORDER BY DATE(p.created_at) DESC, 'user' ASC";

        $prepare = $connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetchAll();
    }

    public static function getPayments($connection, $filters)
    {
        $role = $filters['role'];
        $userId = $filters['userId']; // GET param
        $user = $filters['user']; // Filter param
        $year = $filters['year']; // Filter param

        $sql = "SELECT  p.month,p.year,p.amount,p.created_at ";
        if ($role == 'ROLE_ADMIN') {
            $sql .= ", CONCAT(u.name, ' ', u.surname) AS 'user', u.id AS 'userId' ";
        }
        $sql .= "FROM payments p ";                        
        if ($role == 'ROLE_ADMIN') {
            $sql .= "INNER JOIN users u ON p.user_id = u.id ";
        }
        if ($role == 'ROLE_USER' || 
            ($year !== NULL && $year !== 'todos') || 
            ($user !== NULL && $user !== 'todos') ||
            ($role == 'ROLE_ADMIN' && $userId !== NULL)) {

            $sql .= "WHERE ";

            if ($role == 'ROLE_USER' || ($role == 'ROLE_ADMIN' && $userId !== NULL)) {
                $sql .= "p.user_id = {$userId} ";
            }
            if ($year !== NULL && $year !== 'todos') {
                if ($role == 'ROLE_USER') $sql .= "AND ";
                $sql .= "p.year = {$filters['year']} ";
                if ($user !== NULL && $user !== 'todos') $sql .= "AND ";
            }
            if ($user !== NULL && $user !== 'todos') {
                $sql .= "p.user_id = {$filters['user']} ";
            }
        }

        $sql .= "ORDER BY DATE(p.created_at) DESC";
        if ($role == 'ROLE_ADMIN') {
            $sql .= ", u.name ASC";
        }
        // var_dump($sql);die();
        $prepare = $connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetchAll();
    }

    /**
     * Determine if the payment already exists
     * @param $userId
     * @param $antennaId
     * @param $month
     * @param $year
     * @param $connection
     * @return bool
     */
    public static function isAlreadyPaid($userId, $antennaId, $month, $year, $connection)
    {
        $sql = "SELECT COUNT(*) as 'count'
                FROM payments 
                WHERE user_id = " . $userId . " AND 
                      antenna_id = " . $antennaId . " AND 
                      month = " . $month . " AND 
                      year = " . $year;

        $prepare = $connection->prepare($sql);
        $prepare->execute();
        return $prepare->fetch()['count'] > 0;
    }
}