<?php


namespace App\Controllers;

use App\Auth;
use App\Csrf;
use App\Flash;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserVariables;
use Core\Controller;
use Core\View;
use Exception;

class Register extends Controller
{

    /**
     * Signup form
     */
    public function indexAction()
    {
        $this->requireGuest();

        $fors = UserVariables::fetch('fors');

        View::renderBlade('/register/index',['fors'=>$fors]);

    }

    /**
     * Persist and register new user
     */
    public function createAction()
    {
        /*var_dump($_POST);
        exit();*/
        $csrf = new Csrf($_POST['token']);
        if(!$csrf->validate()){
            unset($_SESSION["csrf_token"]);
            die("CSRF token validation failed");
        }

        $user = new User($_POST);
        if($user->save()){

            // Send email
            //$user->sendActivationEmail();

            // Notify user
            $notification = new Notification();
            $notification->informAboutAccountCreation($user->id);


            // Redirect success
            //$this->redirect('/register/success');
            $_SESSION['otp_user_id']=$user->id;
            $_SESSION['mobile']=$user->mobile;

            // Send mobile otp message
            $_SESSION['otp']=$user->otp;

            $this->redirect('/register/verify-mobile');

        }else{

            foreach($user->errors as $error){
                Flash::addMessage($error,'danger');
            }
            $this->redirect('/register/index');

        }

    }

    /**
     * Shows success page
     */
    public function successAction(){
        View::renderBlade('register/success');
    }

    /**
     * Activate a new account
     *
     * @return void
     */
    public function activateAction()
    {
        //var_dump($this->route_params['token']);
        //exit();
        $result = User::activate($this->route_params['token']);

        if($result){
            Flash::addMessage('Email verified successfully. Please login to continue...', 'success');
            $this->redirect('/account/dashboard');
        }else{
            echo "Could not verify you sorry!";
        }


    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activatedAction()
    {
        View::renderBlade('register/activated');
    }

    /**
     * @throws Exception
     */
    public function verifyMobileAction(){

        if($user=Auth::getUser()){
            $mobile = $user->mobile;
            $mv = $user->mv;
        }else{
            $mobile = $_SESSION['mobile'] ?? '';
            $mv = false;
        }
        if($mobile=='' || $mv){
            throw new Exception('Page is no more available for you.', 404);
        }
        View::renderBlade('register/verify_mobile', ['mobile'=>$mobile]);

    }

    public function matchOtpAction(){

        if($_POST['submit-otp']){

            $otp = $_POST['txt1'].$_POST['txt2'].$_POST['txt3'].$_POST['txt4'];
            $otp = (int)$otp;

            if($user=Auth::getUser()){
                if($user->otp==$otp){
                    $user->verifyMobile();
                    Flash::addMessage('Mobile verified successfully. Please login to continue...', 'success');
                    $this->redirect('/login/index');
                }else{
                    Flash::addMessage('Otp Not-matched please submit correct otp ff', 'danger');
                    $this->redirect('/register/verify-mobile');
                }
            }else{

                $user = User::findByID($_SESSION['otp_user_id']);
                if(($user->otp==$otp) && ($user->mobile==$_SESSION['mobile'])){
                    //echo 'matched';
                    if($user->verifyMobile()){
                        Flash::addMessage('Mobile verified successfully. Please login to continue...', 'success');
                        $this->redirect('/login/index');
                    }
                }else{
                    Flash::addMessage('Otp Not-matched please submit correct otp', 'danger');
                    $this->redirect('/register/verify-mobile');
                }

            }

        }

    }

    /*public function matchOtpAction(){

        if($_POST['submit-otp']){

            $user = User::findByID($_SESSION['otp_user_id']);

            $otp = $_POST['txt1'].$_POST['txt2'].$_POST['txt3'].$_POST['txt4'];
            //echo $otp;
            $otp = (int)$otp;
            if(($user->otp==$otp) && ($user->mobile==$_SESSION['mobile'])){
                //echo 'matched';
                if($user->verifyMobile()){

                    Flash::addMessage('Mobile verified successfully. Please login to continue...', 'success');
                    $this->redirect('/login/index');
                }

            }else{
                Flash::addMessage('Otp Not-matched please submit correct otp', 'danger');
                $this->redirect('/register/verify-mobile');
            }


        }

    }*/

    public function verifyEmailAction(){

        $user=Auth::getUser();
        $user->sendVerificationEmail();
        View::renderBlade('register/verify_email');

    }

}