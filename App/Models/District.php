<?php


namespace App\Models;


use Core\Model;
use PDO;

class District extends \Core\Model
{
    public static function fetchAll($sid){

        $sql = "SELECT * FROM districts WHERE sid =?";

        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sid]);

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}