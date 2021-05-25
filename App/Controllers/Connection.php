<?php


namespace App\Controllers;


use App\Models\AddressRequest;
use App\Models\ConnectProfile;
use App\Models\MoveProfile;
use App\Models\PhotoRequest;
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

    protected static function getCP(){

        static $cp = null;
        if($cp===null) {
            $cp = new ConnectProfile();
        }
        return $cp;
    }

    protected static function getAR(){

        static $ar = null;
        if($ar===null) {
            $ar = new AddressRequest();
        }
        return $ar;
    }

    protected static function getPR(){

        static $pr = null;
        if($pr===null) {
            $pr = new PhotoRequest();
        }
        return $pr;
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


    public static function interestSend(){

        $cp = self::getCP();
        $id = $_SESSION['user_id'];
        return $cp->interestSendToIds($id);
    }

    public static function addressRequestSend(){

        $ar = self::getAR();
        $id = $_SESSION['user_id'];
        return $ar->addressRequestSendToIds($id);
    }

    public static function photoRequestSend(){

        $pr = self::getPR();
        $id = $_SESSION['user_id'];
        return $pr->photoRequestSendToIds($id);
    }

    public static function interestReceived(){

        $cp = self::getCP();
        $id = $_SESSION['user_id'];
        return $cp->interestReceivedFromIds($id);
    }

    public static function recordContact($oid): bool
    {
        $rc = self::getRC();
        $uid = $_SESSION['user_id'];
        return $rc->create($uid,$oid);
    }



}