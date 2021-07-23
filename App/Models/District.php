<?php


namespace App\Models;


use Core\Model;
use PDO;

/**
 * Class District
 * @package App\Models
 */
class District extends \Core\Model
{
    /**
     * @param $sid
     * @return array
     */
    public static function fetchAll($sid){

        $sql = "SELECT * FROM districts WHERE state_id =?";

        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sid]);

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}