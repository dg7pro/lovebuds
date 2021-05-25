<?php


namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Textlocal;
use Core\View;

class VerifyMobile
{

    // ********************** Remove from this page
    /**
     * Show send otp page to user
     */
    public function sendOtpPageAction(){

        View::renderBlade('account/send-otp-page');

    }

    /**
     * Process Sending OTP to user mobile
     * @return bool
     */
    public function sendOtpAction(){

        $textlocal = new Textlocal('getkabirjaiswal@gmail.com', 'b1ee526126799c16b135126330b84f169dbba0f6479b5e27a52b3b353f5bd863');

        $otp = mt_rand(10000,99999);
        $message = "Your one time password is: ".$otp;
        $user = Auth::getUser();
        $user->updateOtp($otp);

        $numbers = array('91'.$user->mobile);
        $sender = 'TXTLCL';

        try {
            //$result = $textlocal->sendSms($numbers, $message, $sender);
            //print_r($result);
            //return true;
            View::renderBlade('account.mobile-verification');


        } catch (Exception $e) {
            return false;
            //die('Error: ' . $e->getMessage());
        }

        //TODO: change textlocal account for production
        //TODO: handle error message properly

    }

    /**
     * Process OTP verification by matching the
     * OTP entered and OTP saved in database
     */
    public function verifyOtpAction(){

        if(!isset($_POST['otp']) || $_POST['otp']==''){

            Flash::addMessage('OTP not entered');
            $this->redirect('/account/failure');
        }

        $user=Auth::getUser();

        if($_POST['otp']!==$user->otp){

            Flash::addMessage('OTP mismatched. Please enter the correct otp');
            $this->redirect('/account/failure');
        }
        else{

            Flash::addMessage('Mobile verified Successfully');
            $user->verifyMobile();
            $this->redirect('/account/success');
        }
    }

    /**
     * Show OTP failed verification page
     */
    public function failureAction(){
        View::renderBlade('account.mobile-verification');
    }

    /**
     *  Show OTP success verification page
     */
    public function successAction(){
        View::renderBlade('account.success');
    }


}