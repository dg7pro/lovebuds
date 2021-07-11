<?php


namespace App\Models;


use App\Auth;
use Core\Model;

/**
 * Class VisitProfile
 * @package App\Models
 */
class VisitProfile extends Model
{

    /**
     * @param $profileId
     * @return int
     */
    public static function checkRow($profileId): int
    {
        $user = Auth::getUser();

        $sql = "SELECT * FROM visit_profile WHERE sender=? AND receiver=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$user->id,$profileId]);
        return $stmt->rowCount();
    }

    /**
     * @param $profileId
     * @return bool
     */
    public static function updateRow($profileId): bool
    {

        $user = Auth::getUser();

        $sql="UPDATE visit_profile SET updated_at=? WHERE sender=? AND receiver=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([\Carbon\Carbon::now(),$user->id,$profileId]);

    }

    /**
     * @param $profileId
     * @return bool
     */
    public static function insertRow($profileId): bool
    {
        $user = Auth::getUser();

        $sql = "INSERT INTO visit_profile (sender,receiver) VALUES (?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$user->id,$profileId]);

        if($result){
            $message = '<a href="/profile/'.$user->pid.'" ><strong> '.$user->first_name.' </strong></a> visited your profile';
            Notify::save($profileId,$message,$user->id,$user->pid);
        }
        return $result;

    }

}