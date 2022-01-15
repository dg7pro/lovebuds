<?php

namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Lib\Helpers;
use App\Models\Image;
use App\Models\Member;
use App\Models\Notification;
use App\Models\Reference;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserVariables;
use App\Sms;
use App\Textlocal\Textlocal;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Core\Controller;
use \Core\View;
use Exception;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        View::renderBlade('home/index',[
            'languages'=>UserVariables::languages(),
            'religions'=>UserVariables::religions(),
            'age_rows'=>UserVariables::getAgeRows()
        ]);

    }

    /*
     * Testing Functions
     * Just for reference and testing
     * tobe deleted
     * */

    public function wrongAction(){

        View::renderBlade('home/wrong');

    }

    public function session(){
        var_dump($_SESSION);
       /* echo "<br>";
        var_dump(Auth::getUser());

        echo "<br>";
        var_dump(Auth::getUser());*/

//        $dt = Carbon::now();
//        echo $dt->toFormattedDateString();


//        $castes = UserVariables::getCountries();
//        Helpers::dnd($castes);

    }

    public function whatsappAction(){

        $self1 = 918887610230;
        $self2 = 917565097233;
        $other = 919335333717;
        View::renderBlade('home/whatsapp',[
            'self1'=>$self1,
            'self2'=>$self2,
            'other'=>$other
        ]);
    }

    public function whatsappAddAction(){

        View::renderBlade('home/whatsapp_add');
    }

    public function secureAction(){

        /*$e = 'geeksforgeeks@gmail.com ';
        $e_san = filter_var($e,FILTER_SANITIZE_EMAIL);
        echo $e_san;
        echo "<br>";
        $flag = filter_var($e,FILTER_VALIDATE_EMAIL);
        echo $flag;*/

        /*$profiles = User::newlist(1503);
        var_dump($profiles);*/

        $s = new Setting();
        echo $s->get_partner_preference_search();

    }

    public function testAction(){

        //setcookie("ju_reference_code", "", time() - 3600, "/");
        //$cUser = User::findByID(1);
        //var_dump($cUser->langs);
        //echo $cUser->langs == "[]"? json_encode($cUser->langs):'false';


        /*$results = User::testSql2();
        Helpers::dnd($results);*/
        /*$notice = new Notification();
        $nos = $notice->fetchAll(Auth::getUser());
        var_dump($nos);*/
        $cookie_name = "ju_reference_code";

       /* if(isset($_COOKIE[$cookie_name])){
            setcookie("ju_reference_code", "", time() - 1);
        }*/
        if(!isset($_COOKIE[$cookie_name])) {
            echo "Cookie named '" . $cookie_name . "' is not set!";
        } else {
            echo "Cookie '" . $cookie_name . "' is set!<br>";
            echo "Value is: " . $_COOKIE[$cookie_name];
        }

    }

    public function removeReferenceAction(){
        setcookie("ju_reference_code", "", time() - 3600, "/");
    }

    public function testNewAction(){
        $cookie_value = uniqid();

        for($i=1;$i<=10;$i++){
            echo $cookie_value;
            echo "<br>";
        }
    }

    public function fbImgAction(){

        echo '<img src="/img/showcase.jpg">';

    }

    public function font(){
        //View::renderBlade('home/font');

        /*$notice = new Notification();
        echo $notice->countDuplicateEntry(108,109);*/

        //echo date();
        $flag = 0;
        if(file_exists('uploaded/pics/60fe711bd4a8e_jhjh.jpg')){
            $f1 = unlink('uploaded/pics/60fe711bd4a8e_jhjh.jpg');
            $f2 = unlink('uploaded/tmb/tn_60fe711bd4a8e_jhjh.jpg');
            if($f1 && $f2){
                $flag = 1;
            }
        }

        echo $flag;
    }

    public function short(){
        $results = User::testQuery($_SESSION['user_id'],0,10);
        //var_dump($results);
        Helpers::dnd($results);
        exit();
    }
    public function shortNew(){
        $results = User::testQuery2($_SESSION['user_id'],0,10);
        //var_dump($results);
        Helpers::dnd($results);
        exit();
    }

    public function checkbox(){

        //View::renderBlade('/register/verify_mobile');
        //View::renderBlade('home/checkbox');

//        $countries = UserVariables::getCountries();
//        Helpers::dnd($countries);

        $newImage = new Image();
        $user = Auth::getUser();

        var_dump($user);
        echo "<br><br><br>";
        $newImage->persistUserImage2($user);


    }

    public function testReferer(){

        /*$flag= false;
        if(isset($_COOKIE['ju_reference_code'])){
            $referer = new Reference();
            $flag = $referer->setSignup($_COOKIE['ju_reference_code'],99);
        }
        echo $flag;*/

        /*$referer = new Reference();
        $x = $referer->getPaid();
        var_dump($x);*/

        $user = User::findByID(120);
        //var_dump($user);
        //$user->becomePaid();
        if($user->becomePaid()){
            $ref = new Reference();
            $ref->setCommission($user->referral,710);
        }
    }

    public function testTextlocalAction(){

        $textlocal = new Textlocal(false,false,'NmI1NzM2NjM3NzYyNjU2NjQ4NGIzOTU4NGE2Mzc5NDg=');

        $otp = 7772;
        $number = 918887610230;

       /* $numbers = [];
        array_push($numbers,$number);*/
        $numbers = [$number];

        $sender = 'JUMARY';
        $message = 'Your one time password for activating your JuMatrimony account is '.$otp;

        try {
            $result = $textlocal->sendSms($numbers, $message, $sender,null,true);
            print_r($result);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function testBulksmsAction(){

        //error_reporting (E_ALL ^ E_NOTICE);
        /*$otp = 2277;
        $username="JUNITE";
        $password ="titanic2021";
        $number=7565097233;
        $sender="JUMARY";
        $message='Your one time password for activating your JuMatrimony account is '.$otp;

        $template_id='1507162868231309659';
        $url="http://api.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($number)."&sender=".urlencode($sender)."&message=".urlencode($message)."&type=".urlencode('3')."&template_id=".urlencode($template_id);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        echo $curl_scraped_page = curl_exec($ch);
        if(json_decode($curl_scraped_page)->status){
            throw new Exception('Sms failed to send due to some reason.', 500);
        }*/

    }

    /*public function testSmsAction(){
        $number=7565097233;
        $otp=3456;
        $re = Sms::sendOtp($number,$otp);
        if($re){
            echo "Sms sent successfully";
        }else{
            echo "Sorry unable to send";
        }
    }*/

    public function sendPhotoUploadReminderAction(){
        $mobile=9335683398;
        $name = 'Dhananjay';
        $result = Sms::sendPhotoUploadReminderSms($mobile,$name);
        if($result){
            echo 'Message send';
        }else{
            echo 'Unable to send message';
        }
    }


}
