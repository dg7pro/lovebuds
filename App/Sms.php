<?php

namespace App;

//use Exception;

class Sms
{
    public static function sendOtp($mobile,$otp): bool
    {

        //error_reporting (E_ALL ^ E_NOTICE);
        //$otp = 2277;
        //$number=7565097233;

        $username = $_ENV['SMS_USERNAME'];
        $password = $_ENV['SMS_PASSWORD'];
        $sender = $_ENV['SMS_SENDER'];
        $template_id = $_ENV['SMS_TEMPLATE_ID'];
        $message='Your one time password for activating your JuMatrimony account is '.$otp;


        $url="http://api.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($mobile)."&sender=".urlencode($sender)."&message=".urlencode($message)."&type=".urlencode('3')."&template_id=".urlencode($template_id);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        $response = json_decode($curl_scraped_page);
        if($response->status=='failed'){
            return false;
        }
        return true;

    }

}