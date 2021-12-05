<?php

namespace App\Models;

use Core\Model;
use PDO;

class Offer extends Model
{
    /**
     * fetch Insta/first offer for the new user
     * @return mixed
     */
    public static function getFirst(){

        $sql="SELECT * FROM offers WHERE id=1 AND status=1";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * fetch current ongoing offer if available
     * @return mixed
     */
    public static function getCurrent(){

        $sql="SELECT * FROM offers WHERE id>1 AND status=1";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * No use kept for reference
     * fetch current ongoing offer if available
     * @return mixed
     */
    public static function isGoingOn(){

        $sql="SELECT * FROM offers WHERE id>1 AND status=1";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();

    }

    /**
     * Set status of offers to Off
     * @return bool
     */
    public static function revokeAllOffers(): bool
    {

        $sql = "UPDATE offers SET status=? WHERE id>?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([false,1]);
    }

    /**
     * Insert new offer
     * @param $arr
     * @return bool
     */
    public static function insert($arr): bool
    {

        $name = $arr['name'];
        $code = $arr['code'];
        $base_price = $arr['base_price'];
        $rate = $arr['rate'];
        $offer_price = $arr['offer_price'];
        $image = $arr['image'];
        $status = $arr['status'];

        $sql = "INSERT INTO offers (offer_name, offer_code, base_price, discount_rate, discount_price, image, status) VALUES (?,?,?,?,?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $result = $stmt->execute([$name,$code,$base_price,$rate,$offer_price,$image,$status]);

        if($result && $status==1){
            Setting::enactOffer();
        }

        return $result;

    }

    /**
     * Fetch single offer data
     * @param $oid
     * @return mixed
     */
    public static function fetch($oid){

        $sql = "SELECT * FROM offers WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$oid]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update offer
     * @param $arr
     * @return bool
     */
    public static function update($arr): bool
    {

        $name = $arr['name'];
        $code = $arr['code'];
        $base_price = $arr['b_price'];
        $rate = $arr['rate'];
        $offer_price = $arr['o_price'];
        $image = $arr['image'];
        $status = $arr['status'];
        $id = $arr['id'];

        $sql = "UPDATE offers SET offer_name=?, offer_code=?, base_price=?, discount_rate=?, discount_price=?, image=?, status=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $result = $stmt->execute([$name, $code, $base_price, $rate, $offer_price, $image, $status, $id]);

        if($result && $status==1){
            Setting::enactOffer();
        }

        return $result;

    }

    /**
     * Live Search Offers
     * @param $start
     * @param $limit
     * @return array|false
     */
    public static function liveSearch($start, $limit){

        $query = "SELECT * FROM offers";

        if($_POST['query'] != ''){
            $query .= '
            WHERE id LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR offer_name LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            OR offer_code LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            ';
        }

        $query .= ' ORDER BY id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }

    /**
     * Counts offers
     * @return int
     */
    public static function liveSearchCount(): int
    {

        $query = "SELECT * FROM offers";

        if($_POST['query'] != ''){
            $query .= '
            WHERE id LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR offer_name LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            OR offer_code LIKE "%'.str_replace('', '%', $_POST['query']).'%" ';
        }

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();

    }

}