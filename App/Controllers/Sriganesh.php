<?php

namespace App\Controllers;

use App\Auth;
use App\Flash;
use App\Models\User;
use App\Sms;
use Core\Controller;
use Core\View;
use Exception;

/**
 *
 */
class Sriganesh extends Controller
{

    /**
     * For Unauthorized users:
     * New Registration & pending activation
     */
    public function throughMobile(){

        // Get unverified User
        $un_active_user = User::findByID($_SESSION['un_active_user_id']);

        // Regenerate & persist otp
        $result = $un_active_user->createNewOtp();

        if($result){

            // putting relevant info into session
            $_SESSION['otp_user_id']=$un_active_user->id;
            $_SESSION['mobile']=$un_active_user->mobile;

            // Verify without sending
            //$_SESSION['otp']=$un_active_user->otp;

            // verify by actual sending ---- comment for testing
            Sms::sendOtp($un_active_user->mobile,$un_active_user->otp);

            $this->redirect('/sriganesh/verify-mobile');

        }
    }

    /**
     * Show verify mobile page for user to enter otp
     * @throws Exception
     */
    public function verifyMobileAction(){

        if($user=Auth::getUser()){
            if(!$user->mv){
                $result = $user->createNewOtp();

                if($result){
                    // temporary
                    //$_SESSION['otp']=$user->otp;

                    // Actual sending production server
                    Sms::sendOtp($user->mobile,$user->otp);
                }
            }
            $mobile = $user->mobile;
            $mv = $user->mv;
        }else{
            $mobile = $_SESSION['mobile'] ?? '';
            $mv = false;
        }
        if($mobile=='' || $mv){
            throw new Exception('Page is no more available for you.', 404);
        }
        View::renderBlade('sriganesh/verify_mobile', ['mobile'=>$mobile]);

    }

    /**
     * Match and verify mobile through otp
     */
    public function matchOtpAction(){

        if($_POST['submit-otp']){

            $otp = $_POST['txt1'].$_POST['txt2'].$_POST['txt3'].$_POST['txt4'];
            $otp = (int)$otp;

            if($user=Auth::getUser()){
                if($user->otp==$otp){

                    if($user->verifyMobile()){
                        Flash::addMessage('Mobile verified successfully...', 'success');
                        $this->redirect('/account/dashboard');
                    }
                }else{
                    Flash::addMessage('Otp not-matched please submit correct otp sg', 'danger');
                    $this->redirect('/sriganesh/verify-mobile');
                }
            }else{
                $user = User::findByID($_SESSION['otp_user_id']);
                if(($user->otp==$otp) && ($user->mobile==$_SESSION['mobile'])){

                    if($user->verifyMobile()){
                        Flash::addMessage('Mobile verified successfully. Please login to continue...', 'success');
                        Auth::logout();
                        $this->redirect('/login/index');
                    }
                }else{
                    Flash::addMessage('Otp Not-matched please submit correct otp sg', 'danger');
                    $this->redirect('/sriganesh/verify-mobile');
                }
            }

        }
    }


}