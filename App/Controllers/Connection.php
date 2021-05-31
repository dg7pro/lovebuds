<?php


namespace App\Controllers;


use App\Models\MoveProfile;
use App\Models\RecordContact;

class Connection extends Authenticated
{
    protected static function getRC(){

        static $rc = null;
        if($rc===null) {
            $rc = new RecordContact();
        }
        return $rc;
    }

    public static function recordContact($oid): bool
    {
        $rc = self::getRC();
        $uid = $_SESSION['user_id'];
        return $rc->create($uid,$oid);
    }

    protected static function getMP(){

        static $mp = null;
        if($mp===null) {
            $mp = new MoveProfile();
        }
        return $mp;
    }

    public static function currentDownlist(){

        $mp = self::getMP();
        $id = $_SESSION['user_id'];
        return $mp->getDownlist($id);
    }

    public static function currentShortlist(){

        $mp = self::getMP();
        $id = $_SESSION['user_id'];
        return $mp->getShortlist($id);
    }

}