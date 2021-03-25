<?php


namespace App\Models;


use Carbon\Carbon;
use Core\Model;
use PDO;

/**
 * Class ConnectProfile
 * @package App\Models
 */
class ConnectProfile extends Model
{

    /**
     * @param $id
     * @return array    eg. {[0]=>137, [1]=>318}
     * It returns ordinary array
     */
    public function interestSendToIds($id){

        $sql = "SELECT profile_id FROM connect_profile WHERE matri_id=? ORDER BY created_at DESC";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }

    /**
     * @param $id
     * @return array    eg. {[0]=>137, [1]=>318}
     * It returns ordinary array
     */
    public static function interestReceivedFromIds($id){

        $sql = "SELECT matri_id FROM connect_profile WHERE profile_id=? ORDER BY created_at DESC ";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }

    /**
     * @param $matri_id
     * @param $profile_id
     * @return bool
     */
    public static function insertNew($matri_id, $profile_id){

        $sql = "INSERT INTO connect_profile(matri_id,profile_id) VALUES (?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute([$matri_id, $profile_id]);

        if($status){
            Notification::save('interest_received',$profile_id);
            if(self::getUserConnectionFlag($matri_id, $profile_id)==9){
                Notification::save('connected_profile',$profile_id);
            }
        }

        return $status;

    }


    /**
     * @param $user1
     * @param $user2
     * @return int
     */
    public static function getUserConnectionFlag($user1, $user2){


        $sql = "SELECT * FROM connect_profile WHERE matri_id=? AND profile_id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$user1,$user2]);
        $A = $stmt->rowCount();

        /*$sql = "SELECT * FROM connect_profile WHERE matri_id=? AND profile_id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);*/
        $stmt->execute([$user2,$user1]);
        $B = $stmt->rowCount();

        $flag=6;
        if(!$A && !$B){
            $flag = 6;  // Initiate
        }elseif ($A && !$B){
            $flag = 7;   // Sent
        }elseif (!$A && $B){
            $flag = 8;  // Accept
        }else {
            $flag = 9;  // Connected
        }

        return $flag;

    }

    public static function getReminderFlag($matri_id, $profile_id){

        $sql = "SELECT * FROM connect_profile WHERE matri_id=? AND profile_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$matri_id, $profile_id]);

        $result = $stmt->fetch(PDO::FETCH_OBJ); // simple fetch gives array

        $flag = false;
        if($result){
            $t = Carbon::now()->subDays(15);
            if($result->reminder==1 || $result->created_at > $t){
                $flag = 1;
            }
            //$flag = ($result->reminder==1); // flag is true when reminder == 1
        }
        return $flag;
    }



}