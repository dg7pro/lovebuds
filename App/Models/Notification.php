<?php


namespace App\Models;


use App\Auth;
use Core\Model;
use PDO;

class Notification extends Model
{

    /**
     *
     */
    const SUCCESS = 'success';

    /**
     *
     */
    const INFO = 'info';

    /**
     *
     */
    const WARNING = 'warning';

    /**
     *
     */
    const HASH = '#';

    /**
     *
     */
    const IO = 'mdi mdi-information-outline';


    /**
     * Deprecated
     *
     * @param $uid
     * @param $sub
     * @param $msg
     * @param string $icon
     * @param string $color
     * @param string $url
     * @return bool
     */
    public static function addMessage($uid, $sub, $msg, $icon=self::IO, $color=self::INFO, $url=self::HASH){

        $sql = "INSERT INTO notifications (user_id, sub, msg, icon, color, url) 
                VALUES(:user_id, :sub, :msg, :icon, :color, :url)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $uid, PDO::PARAM_INT);
        $stmt->bindValue(':sub', $sub, PDO::PARAM_STR);
        //$stmt->bindValue(':pid', $this->pid, PDO::PARAM_STR);
        $stmt->bindValue(':msg', $msg, PDO::PARAM_STR);
        $stmt->bindValue(':icon', $icon, PDO::PARAM_STR);
        $stmt->bindValue(':color', $color, PDO::PARAM_STR);
        $stmt->bindValue(':url', $url, PDO::PARAM_STR);

        return $stmt->execute();

    }

    /**
     * Save notification for the specific user
     * @param $type
     * @param $id
     * @return bool
     */
    public static function save($type, $id){

        $sql = "INSERT INTO notifications (user_id, sub, msg, icon, color, url) 
                VALUES(:user_id, :sub, :msg, :icon, :color, :url)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $authUser = Auth::getUser();
        $auth_profile_id = $authUser->pid;
        $auth_first_name = $authUser->first_name;
        $params = self::getParamList($type,$auth_profile_id,$auth_first_name);

        $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
        foreach ($params as $k => $v){
            $stmt->bindValue(':'.$k, $v,PDO::PARAM_STR);
        }

        /*$stmt->bindValue(':user_id', $uid, PDO::PARAM_INT);
        $stmt->bindValue(':sub', $sub, PDO::PARAM_STR);
        //$stmt->bindValue(':pid', $this->pid, PDO::PARAM_STR);
        $stmt->bindValue(':msg', $msg, PDO::PARAM_STR);
        $stmt->bindValue(':icon', $icon, PDO::PARAM_STR);
        $stmt->bindValue(':color', $color, PDO::PARAM_STR);
        $stmt->bindValue(':url', $url, PDO::PARAM_STR);*/

        return $stmt->execute();

    }

    /**
     * @param $type
     * @param string $pid
     * @param string $fn
     * @return string[]
     */
    protected static function getParamList($type, $pid='', $fn=''){

        switch ($type) {

            case "profile_created":
                return $param_array = [
                    'sub'=>'Profile Created',
                    'msg'=> 'Marriage Profile created successfully',
                    'url'=> '/account/my-profile',
                    'icon'=>'mdi-account-card-details',
                    'color'=>'success'
                ];
                break;

            case "account_verified":
                return $param_array = [
                    'sub'=>'Account Verified',
                    'msg'=> 'KYC details verified successfully',
                    'url'=> '/account/my-kyc',
                    'icon'=>'mdi-account-card-details',
                    'color'=>'success'
                ];
                break;

            case "account_activated":
                // not implemented due to not possible
                return $param_array = [
                    'sub'=>'Account Activated',
                    'msg'=> 'Your account activated successfully',
                    'url'=> '/account/info',
                    'icon'=>'mdi-account-check',
                    'color'=>'success'
                ];
                break;

            case "connected_profile":
                return $param_array = [
                    'sub'=>'Connected Profile',
                    'msg'=> $fn.' and you are now connected',
                    'url'=> '/account/stats',
                    'icon'=>'mdi-swap-horizontal-bold',
                    'color'=>'success'
                ];
                break;

            case "interest_received":
                return $param_array = [
                    'sub'=>'Interest Received',
                    'msg'=> $fn.' is interested in you',
                    'url'=> '/profile/'.$pid,
                    'icon'=>'mdi-telegram mdi-rotate-180',
                    'color'=>'info'
                ];
                break;

            case "interest_reminder":
                return $param_array = [
                    'sub'=>'Interest Reminder',
                    'msg'=> $fn.' has send you interest reminder',
                    'url'=> '/profile/'.$pid,
                    'icon'=>'mdi-telegram mdi-rotate-180',
                    'color'=>'info'
                ];
                break;

            case "photo_approved":
                return $param_array = [
                    'sub'=>'Photo Approved',
                    'msg'=> 'Photo approved by moderator',
                    'url'=> '/account/my-album',
                    'icon'=>'mdi-image',
                    'color'=>'primary'
                ];
                break;

            case "photo_rejected":
                return $param_array = [
                    'sub'=>'Photo Rejected',
                    'msg'=> 'Photo rejected by moderator',
                    'url'=> '/account/my-album',
                    'icon'=>'mdi-image',
                    'color'=>'warning'
                ];
                break;

            case "profile_visited":
                return $param_array = [
                    'sub'=>'Profile Visitor',
                    'msg'=> $fn.' viewed your profile',
                    'url'=> '/profile/'.$pid,
                    'icon'=>'mdi-eye-plus',
                    'color'=>'info'
                ];
                break;

            case "profile_liked":
                return $param_array = [
                    'sub'=>'Profile Liked',
                    'msg'=> $fn.' has liked your profile',
                    'url'=> '/profile/'.$pid,
                    'icon'=>'mdi-thumb-up-outline',
                    'color'=>'danger'
                ];
                break;

            case "payment_successful":
                return $param_array = [
                    'sub'=>'Payment Successful',
                    'msg'=> 'You are now Paid Member',
                    'url'=> '/account/info',
                    'icon'=>'mdi-currency-inr',
                    'color'=>'success'
                ];
                break;
            default:
                return $param_array = [
                    'sub'=>'Just Testing',
                    'msg'=> 'Just Testing Notifications from Admin',
                    'url'=> '/profile/'.$pid,
                    'icon'=>'mdi mdi-nuke',
                    'color'=>'info'
                ];

        }

    }


    /**
     * @param $userId
     * @return array
     */
    public static function fetchAll($userId){

        $sql = "SELECT * FROM notifications where user_id=? ORDER BY status desc,created_at";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}