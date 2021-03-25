<?php


namespace App\Controllers;


use App\Models\ConnectProfile;

class Connection extends Authenticated
{

    protected static function getCP(){

        static $cp = null;
        if($cp===null) {
            $cp = new ConnectProfile();
        }
        return $cp;
    }

    public static function interestSend(){

        $cp = self::getCP();
        $id = $_SESSION['user_id'];
        return $cp->interestSendToIds($id);
    }

    public static function interestReceived(){

        $cp = self::getCP();
        $id = $_SESSION['user_id'];
        return $cp->interestReceivedFromIds($id);
    }



}