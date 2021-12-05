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

    /**
     * Based on this parameter, offers are given
     * If set to 0 all offer closes
     * & vice versa
     *
     * @return mixed
     */
    public function is_ongoing_current_offer(){

        $param = 'ongoing_current_offer';
        $sql = "SELECT value FROM settings WHERE parameter =?";

        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$param]);

        return  $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Get all settings
     * @return array|false
     */
    public static function getAll(){

        $sql = "SELECT * FROM settings";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Revoke Offer
     * @param $id
     * @return bool
     */
    public static function revokeOffer($id): bool
    {

        if(Offer::revokeAllOffers()){

            $sql = "UPDATE settings SET value=? WHERE id=?";
            $db=Model::getDB();
            $stmt = $db->prepare($sql);
            return $stmt->execute([0,$id]);
        }

        return false;
    }

    /**
     * Enact Offer
     * @return bool
     */
    public static function enactOffer(): bool
    {
        $sql = "UPDATE settings SET value=? WHERE id=2";
        $db=Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([1]);

    }

    /**
     * Enable Partner Preference Search
     * @param $id
     * @return bool
     */
    public static function enablePps($id): bool
    {

        $sql = "UPDATE settings SET value=? WHERE id=?";
        $db=Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([1,$id]);
    }

    /**
     * Disable Partner Preference Search
     * @param $id
     * @return bool
     */
    public static function disablePps($id): bool
    {

        $sql = "UPDATE settings SET value=? WHERE id=?";
        $db=Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([0,$id]);
    }

}