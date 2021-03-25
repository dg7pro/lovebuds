<?php


namespace App\Models;


use Core\Model;

/**
 * Class VisitProfile
 * @package App\Models
 */
class VisitProfile extends Model
{

    /**
     * @param $userId
     * @param $profileId
     * @return int
     */
    public static function checkRow($userId, $profileId){

        $sql = "SELECT * FROM visit_profile WHERE matri_id=? AND profile_id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$userId,$profileId]);
        return $stmt->rowCount();
    }

    /**
     * @param $userId
     * @param $profileId
     * @return bool
     */
    public static function updateRow($userId, $profileId){

        $sql="UPDATE visit_profile SET updated_at=? WHERE matri_id=? AND profile_id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([\Carbon\Carbon::now(),$userId,$profileId]);

    }

    /**
     * @param $userId
     * @param $profileId
     * @return bool
     */
    public static function insertNew($userId, $profileId){

        $sql = "INSERT INTO visit_profile (matri_id,profile_id) VALUES (?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$userId,$profileId]);

        if($result){
            Notification::save('profile_visited',$profileId);
        }
        return $result;

    }

}