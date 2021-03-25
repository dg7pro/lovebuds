<?php


namespace App\Models;


use Core\Model;

class ShortlistProfile extends Model
{
    public static function insertNew($matri_id,$profile_id){

        $sql = "INSERT INTO shortlist_profile(matri_id,profile_id) VALUES (?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$matri_id, $profile_id]);

    }

    public static function getUserFavStatus($matri_id,$profile_id){

        $sql = "SELECT * FROM shortlist_profile WHERE matri_id=? AND profile_id=?";
        $pdo = Model::getDB();
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$matri_id,$profile_id]);
        return $stmt->rowCount();
    }

}