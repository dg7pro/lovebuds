<?php


namespace App\Models;


use Core\Model;
use PDO;

class Kyc extends Model
{
    public static function getUnapprovedList(){

        /*$sql1 = "SELECT * FROM kycs WHERE approved=?";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql1);
        $stmt->execute([0]);

        return $stmt->fetchAll();*/

        $sql= "SELECT k.user_id, k.img_id, k.filename, u.name, u.pid, u.mobile FROM kycs AS k
                LEFT JOIN users AS u ON u.id=k.user_id
                WHERE k.approved = ? ORDER BY user_id ASC LIMIT 50";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([0]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getUserKyc($userId){

        $sql="SELECT * FROM kycs WHERE user_id=? and linked=1";
        $pdo=Model::getDB();
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public static function persistUserKyc($userId,$fileName){

        $imgId= self::random_token(5);
        $sql = "INSERT INTO kycs (user_id,img_id,filename) VALUES (?,?,?)";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId,$imgId, $fileName]);
    }

    public static function fetchUserKycsForDisplay($userId){

        $sql = "SELECT * FROM kycs WHERE user_id=? AND linked = 1";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function approveUserKycStatus($userId,$imgId,$fileName){

        $sql2 = "UPDATE kycs SET approved=1 WHERE user_id=? AND img_id=? AND filename=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql2);
        $status =  $stmt->execute([$userId,$imgId,$fileName]);

        if($status){
            Notification::save('account_verified',$userId);
        }

        return $status;
    }

    /**
     * Generate token for Verification Purpose
     * @param $size
     * @return string
     */
    protected static function random_token($size){
        $token = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $size; $i++) {
            $token .= $keys[array_rand($keys)];
        }
        return $token;
    }



}