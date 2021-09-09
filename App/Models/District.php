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
    public static function fetchAll($sid): array
    {

        $sql = "SELECT * FROM districts WHERE state_id =?";

        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sid]);

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $sid
     * @return array
     */
    public static function fetchNames($sid): array
    {

        $sql = "SELECT districts.id AS did, districts.text AS sahar, states.text as rajya FROM districts 
                LEFT JOIN states ON states.id = districts.state_id
                WHERE state_id =?";

        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sid]);

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}