<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Class Users
 * Deals with all User Object related queries with fetch all
 * @package App\Models
 */
class Users extends Model
{

    /**
     * Fetch all Pro users
     * @param $start
     * @param $limit
     * @param $type
     * @return array|false
     */
    public function proUsers($start, $limit, $type){

        $query = "SELECT users.*, fors.name as cfor FROM users LEFT JOIN fors ON users.for_id = fors.id ";

        if($type=='unpaid'){
            $query .= 'WHERE is_paid =0';
        }else{
            $query .= 'WHERE users.id > 0';
        }

        if($_POST['query'] != ''){
            $query .= '
            AND (first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR email LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            )';
        }


        $query .= ' AND users.is_pro =1 ORDER BY users.id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /**
     * Pro users count
     * @param $type
     * @return int
     */
    public function proUsersCount($type): int
    {

        $query = "SELECT users.*, fors.name as cfor FROM users LEFT JOIN fors ON users.for_id = fors.id ";

        if($type=='unpaid'){
            $query .= 'WHERE is_paid =0 AND users.is_pro =1';
        }else{
            $query .= 'WHERE users.id > 0 AND users.is_pro =1';
        }

        if($_POST['query'] != ''){
            $query .= '
            AND (first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR email LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            )';
        }

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }

}