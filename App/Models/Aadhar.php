<?php

namespace App\Models;

use Core\Model;
use PDO;

class Aadhar extends Model
{

    /**
     * Fetch user aadhars
     * @param $id
     * @return array
     */
    public static function getUserUploadedAadhars($id): array
    {
        $imgSql = "SELECT * FROM aadhars WHERE user_id=? AND linked=1";
        $db = Model::getDB();
        $stmt = $db->prepare($imgSql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(pdo::FETCH_OBJ);

    }


    /**
     * @param $userId
     * @param $fileName
     * @return bool
     */
    public function persistUserAadhar(User $user, $fileName, $tag): bool
    {

        $img_id = self::random_token(5);

        $pdo = Model::getDB();
        $sql = "INSERT INTO aadhars (user_id,img_id,filename,tag) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$user->id,$img_id,$fileName,$tag]);


    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function fetchUserAadharFront($userId)
    {

        $sql = "SELECT * FROM aadhars WHERE user_id=? AND tag = 'front'";
        $pdo=Model::getDB();

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        //$num = $stmt->rowCount();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function fetchUserAadharBack($userId)
    {

        $sql = "SELECT * FROM aadhars WHERE user_id=? AND tag = 'back'";
        $pdo=Model::getDB();

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        //$num = $stmt->rowCount();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Generate token for Verification Purpose
     * @param $size
     * @return string
     */
    protected static function random_token($size): string
    {
        $token = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $size; $i++) {
            $token .= $keys[array_rand($keys)];
        }
        return $token;
    }

    public static function pendingIds(): array
    {

        /* $sql = "SELECT aadhars.*,
             users.id, users.pid, users.first_name, users.last_name, users.email
             FROM aadhars
             LEFT JOIN users ON aadhars.user_id = users.id
             WHERE users.id>100 GROUP BY aadhars.user_id";*/
        $sql = "SELECT uu.id as id, uu.first_name as fn, uu.last_name as ln, uu.dob, uu.mobile as mb, uu.mv, uu.aadhar, aa.user_id, aa.img_id, aa.dealt, GROUP_CONCAT(DISTINCT aa.filename) as images 
                FROM aadhars as aa
                LEFT JOIN users as uu ON uu.id=aa.user_id
                WHERE dealt=0 GROUP BY aa.user_id";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $new_results = array();
        foreach($results as $r){
            $a = [];
            $a = explode(',',$r['images']);
            $r['ids']=$a;
            array_push($new_results,$r);
        }
        return $new_results;
    }

    /**
     * @param $userId
     * @param $imgId
     * @return bool
     */
    public static function makeDealt($userId): bool
    {

        $sql = "UPDATE aadhars SET dealt=? WHERE user_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute([1,$userId]);

        if($status){
            /*$message = 'Photo approved by moderator <a href="/account/manage-photo"><strong> View </strong></a>';
            Notification::save($userId, $message);*/

            User::verifyMe($userId);
        }
        return $status;
    }



}