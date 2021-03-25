<?php

namespace App\Controllers;

use App\Auth;
use App\Lib\Helpers;
use App\Mail;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserConnections;
use App\Models\UserVariables;
use Carbon\Carbon;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $this->requireGuest();
        $fors = UserVariables::fetch('fors');

        $referred_by = $_COOKIE['ju_referral'] ?? '';

        View::renderBlade('home/index',['fors'=>$fors,'referred_by'=>$referred_by]);

    }

    public function sessionAction()
    {
        var_dump($_SESSION);
      /* $user = Auth::getUser();
       Helpers::dnd($user);*/

//        $fors = UserVariables::fetch('fors');
//        Helpers::dnd($fors);
        /*$filename =Image::getImageFilename(6,6627);
        var_dump($filename);*/
//        View::renderBlade('test');
    }

    public function messageAction(){

        $start_time = microtime(true);

        Mail::send('dgkashi@gmail.com','Test JU Msg777','This is test message777','<h2>This is test Message 9.52</h2>');

        $end_time = microtime(true);
        $time = number_format($end_time - $start_time, 5);

        echo $time;

    }

    public function phpMailerAction(){

        $start_time = microtime(true);
        $result = Mail::sendEmailThroughPHPMailer();

        $end_time = microtime(true);
        $time = number_format($end_time - $start_time, 5);

        echo $result;
        echo $time;
    }

    public function testAction(){

//        $ht = array_rand(UserVariables::heights());
        /*$ht = array_rand(UserVariables::getOccupations());
        var_dump($ht);*/

        //var_dump($_SESSION['chain'][-1]);
        /*$A = array();
        $B = array();
        $C =array();*/
       /* $A = UserConnections::interestSendToIds(2);
        $B = UserConnections::interestReceivedFromIds(2);
        $C = array_intersect($A,$B);
        Helpers::dnd($C);*/

        $A_keys = UserConnections::interestSendToArray(2);

        Helpers::dnd($A_keys);
        //var_dump($A_keys);
        exit();
        $B_keys = UserConnections::interestReceivedFromArray(2);
        //$C = array_intersect($A,$B);


        /*Helpers::dnd($A_keys);*/

        $A_name = UserConnections::interestSendToKeysArray(2);
        $B_name = UserConnections::interestReceivedFromKeysArray(2);
        //Helpers::dnd($A_name);
        print_r($A_name);
        exit();

        $results = UserConnections::connectedProfiles2(2);
        //Helpers::dnd($results);

        //$D = [137,103];
/*
        $rin = array_intersect_key($results,$A_name);
        Helpers::dnd($rin);*/

    }

    public function notificationAction(){

        $notifications = Notification::fetchAll(Auth::getUser()->id);
        Helpers::dnd($notifications);
    }

    public function testeAction(){

        $user = Auth::getUser();
        /*var_dump($user->like_array);
        exit();*/

        //$like_arr = str_replace('"','', (array)json_decode($user->like_array));


        /*array_push($like_arr,555);

        var_dump(json_encode($like_arr));*/

       /* $two = array();
        $one = array(1,2,3,4,5,6,7);
        if(empty($two)){
            echo "array is empty";
        }
        $one_je = json_encode($one);
        $two_je = json_encode($two);
        echo $two_je;
        if(empty($two_je)){
            echo "array is empty2";
        }
        echo "<br>";
        var_dump(json_decode($one_je));*/


        //echo ConnectProfile::getReminderFlag(2,1008);

        //echo Carbon::now()->subDays(10);

       /* $result = ConnectProfile::getReminderFlag(2,1008);
        var_dump($result->profile_id);
        exit();*/

       /* $user = Auth::getUser();
        $mobile=7565097233;
        $res = $user->mobileExists($mobile,$user->id);

        echo $res;*/

        /*$res = User::findByMobile($mobile);
        if($res){
            var_dump($res->id);

        }*/


    }

    public function timestamp(){

        $t =  Carbon::now()->subDays(7);

        /*$users = User::getUsersByTimestamp($t);
        Helpers::dnd($users);*/

        echo $t;
        $results = User::timeQuery($t);
        Helpers::dnd($results);
    }

    public function rose(){

        /*$cp = UserConnections::getCP();
        var_dump($cp);*/

        $user = Auth::getUser();
        Helpers::dnd($user->shortsArr());

        //Helpers::dnd($cp->test(2));

    }

    public function allUsers(){

        $users = User::getFiveRandomProfiles(2);
        Helpers::dnd($users);


    }
}
