<?php


namespace App\Models;


use Core\Model;
use PDO;

/**
 * Class Setting
 * @package App\Models
 */
class Setting extends Model
{

    /**
     * Based on this parameter, search of users depends
     * If set to 0 partner preferences is not taken into account
     * & vice versa
     *
     * @return mixed
     */
    public function get_partner_preference_search(){

        $param = 'partner_preference_search';
        $sql = "SELECT value FROM settings WHERE parameter =?";

        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$param]);

        return  $stmt->fetch(PDO::FETCH_COLUMN);
    }

}