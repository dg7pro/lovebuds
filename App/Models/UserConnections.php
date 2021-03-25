<?php


namespace App\Models;

use PDO;
use App\Auth;
use Core\Model;

class UserConnections extends Model
{
    /**
     * Recommended Profiles
     *
     * @return array
     */
    public static function recommendedIds(){
        $authId = Auth::getUser()->id;
        $authGn = Auth::getUser()->gender;

        $sql = "SELECT id FROM users WHERE users.id!=? AND gender!=? ORDER BY users.id desc LIMIT 3";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$authId,$authGn]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }

    /**
     * New Profiles
     *
     * @return array
     */
    public static function newProfileIds(){

        $authId = Auth::getUser()->id;
        $authGn = Auth::getUser()->gender;

        $sql = "SELECT id FROM users WHERE users.id!=? AND gender!=? AND created_at > DATE_SUB(NOW(), INTERVAL 6 WEEK)
        ORDER BY rand() desc LIMIT 3";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$authId,$authGn]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }

    /**
     * Visitors Profile
     *
     * @return array
     */
    public static function visitorIds(){

        $authId = Auth::getUser()->id;

        $sql = "SELECT matri_id FROM visit_profile WHERE profile_id=? ORDER BY created_at desc LIMIT 3";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$authId]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }

    /**
     * User Detailed Information
     *
     * @param $cArray
     * @return array
     */
    public static function getUserCombinedDetails($cArray){

        $sql = 'SELECT users.id,
                users.id,
                users.pid,
                users.avatar,
                users.mobile,
                users.email,
                users.first_name as fn,
                users.last_name as ln,
                users.dob,
                heights.ft as ft,
                religions.name as rel,
                occupations.name as occ,
                educations.name as edu,
                districts.text as dis,
                communities.name as com,
                languages.text as lan
                FROM `users` 
                LEFT JOIN heights ON users.height_id=heights.id
                LEFT JOIN religions ON users.religion_id=religions.id
                LEFT JOIN occupations ON users.occupation_id=occupations.id            
                LEFT JOIN educations ON users.education_id=educations.id
                LEFT JOIN districts ON users.district_id=districts.id
                LEFT JOIN communities ON users.community_id=communities.id
                LEFT JOIN languages ON users.language_id=languages.value
                WHERE users.id IN (' . implode(',', array_map('intval', $cArray)) . ')';

        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_UNIQUE|PDO::FETCH_OBJ);

    }

}