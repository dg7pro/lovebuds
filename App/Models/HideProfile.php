<?php


namespace App\Models;


use Core\Model;

/**
 * Class HideProfile -- Checked
 * @package App\Models
 */
class HideProfile extends Model
{
    /**
     * @param $matri_id
     * @param $profile_id
     * @return bool
     */
    public static function insertNew($matri_id, $profile_id){

        $sql = "INSERT INTO hide_profile(matri_id,profile_id) VALUES (?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$matri_id, $profile_id]);

    }

    /**
     * @param $matri_id
     * @param $profile_id
     * @return int
     */
    public static function getUserHideStatus($matri_id, $profile_id){

        $sql = "SELECT * FROM hide_profile WHERE matri_id=? AND profile_id=?";
        $pdo = Model::getDB();
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$matri_id,$profile_id]);
        return $stmt->rowCount();
    }

}