<?php


namespace App\Controllers;


use App\Models\MoveProfile;

/**
 * Class Connection
 * @package App\Controllers
 */
class Connection extends Authenticated
{

    /**
     * @return MoveProfile|null
     */
    protected static function getMP(){

        static $mp = null;
        if($mp===null) {
            $mp = new MoveProfile();
        }
        return $mp;
    }

    /**
     * @return int[]|string[]
     */
    public static function currentDownlist(){

        $mp = self::getMP();
        $id = $_SESSION['user_id'];
        return $mp->getDownlist($id);
    }

    /**
     * @return int[]|string[]
     */
    public static function currentShortlist(){

        $mp = self::getMP();
        $id = $_SESSION['user_id'];
        return $mp->getShortlist($id);
    }

}