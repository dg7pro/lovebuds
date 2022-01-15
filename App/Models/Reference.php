<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Class Reference
 * @package App\Models
 */
class Reference extends Model
{

    /**
     * Each time guest visits pro member profile
     * new reference is generated
     * @param User $user
     * @param $code
     * @return bool
     */
    public function save(User $user, $code){

        $id= $user->id;
        $pid= $user->pid;

        $sql = "INSERT INTO reference(user_code,user_id,profile_id) VALUES (?,?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$code,$id,$pid]);
    }

    /*public static function checkEntry($code){

        $sql = "SELECT * FROM reference WHERE user_code=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$code]);
        return $stmt->rowCount();
    }*/

    /**
     * Count all footprints of particular pro member, means
     * no. of devices on which cookies/ reference is set.
     * @param $id
     * @return int
     */
    public function getFootprint($id): int
    {
        $sql = "SELECT * FROM reference WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    /**
     * Counts all signup's of particular pro members through reference
     * @param $id
     * @return int
     */
    public function getSignup($id): int
    {

        $sql = "SELECT * FROM reference WHERE user_id=? AND signup=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id,'yes']);
        return $stmt->rowCount();
    }

    /**
     * Update & record reference table when new user signup through reference
     * @param $code
     * @param $id
     * @return bool
     */
    public function setSignup($code, $id): bool
    {

        $sql = 'UPDATE reference SET signup = "yes", signup_id = :id WHERE user_code = :code';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @param $uid
     * @return array|false
     */
    public function getPaidMembers($uid)
    {
        $sql = "SELECT ref.user_code, users.first_name, ref.amount_paid, ref.earning FROM reference AS ref
                LEFT JOIN users ON users.id=ref.signup_id
                WHERE signup='yes' AND ref.user_id=? AND users.is_paid=1";

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$uid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $stmt->rowCount();
    }

    /**
     * @param $code
     * @param $amount
     * @return bool
     */
    public function setCommission($code, $amount): bool
    {

        $earning = $amount/100*50;
        $sql = 'UPDATE reference SET amount_paid = :amount, earning = :earning WHERE user_code = :code';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindValue(':earning', $earning, PDO::PARAM_INT);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);

        return $stmt->execute();
    }


    /*public function getNewMembers()
    {
        $sql = "SELECT ref.user_code, users.first_name, orders.txn_amount FROM reference AS ref
                LEFT JOIN users ON users.id=ref.signup_id
                LEFT JOIN orders ON orders.user_id=ref.signup_id
                WHERE signup='yes' AND users.is_paid=1";

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $stmt->rowCount();
    }*/

    /**
     * @param $start
     * @param $limit
     * @param $type
     * @param $uid
     * @return array|false
     */
    public function myFootprints($start, $limit, $type, $uid){

        $query = "SELECT reference.*, 
            users.first_name as fname, 
            users.last_name as lname, 
            users.email as email,
            users.pid as pid, 
            users.is_paid as pay 
            FROM reference LEFT JOIN users ON reference.signup_id = users.id ";

        if($type=='signup'){
            $query .= "WHERE reference.signup = 'yes' ";
        }elseif($type=='paid'){
            $query .= 'WHERE reference.amount_paid IS NOT NULL';
        }else{
            $query .= 'WHERE reference.user_code IS NOT NULL';
        }

        if($_POST['query'] != ''){
            $query .= '
            AND (users.first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR users.last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR users.email LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            )';
        }


        $query .= ' AND reference.user_id='.$uid.' ORDER BY reference.signup_id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /**
     * @return int
     */
    public function myFootprintsCount($type,$uid): int
    {

        $query = "SELECT reference.*, users.first_name as fname, users.pid as pid FROM reference LEFT JOIN users ON reference.signup_id = users.id ";

        if($type=='signup'){
            $query .= "WHERE reference.signup = 'yes' ";
        }elseif($type=='paid'){
            $query .= 'WHERE reference.amount_paid IS NOT NULL';
        }else{
            $query .= 'WHERE reference.user_code IS NOT NULL';
        }

        if($_POST['query'] != ''){
            $query .= '
            AND (users.first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR users.last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR users.email LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            )';
        }

        $query .= ' AND reference.user_id='.$uid;

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();


    }






}