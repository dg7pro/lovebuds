<?php


namespace App\Controllers;

use App\Auth;
use App\Csrf;
use App\Flash;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserVariables;
use App\Sms;
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
            //$_SESSION['otp']=$user->otp;
            Sms::sendOtp($user->mobile,$user->otp);

            $this->redirect('/sriganesh/verify-mobile');

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
        $message = isset($_SESSION['user_id'])?'Email verified successfully':'Email verified successfully. Please login to continue...';

        $result = User::activate($this->route_params['token']);

        if($result){
            Flash::addMessage($message, 'success');
            $this->redirect('/account/dashboard');
        }else{
            //echo "Could not verify you sorry!";
            throw new Exception('Something went wrong or server is too busy.', 500);
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

    public function verifyEmailAction(){

        if(isset($_SESSION['user_id'])){
            $user=Auth::getUser();
        }elseif(isset($_SESSION['un_active_user_id'])){
            $user=User::findByID($_SESSION['un_active_user_id']);
        }else{
            throw new Exception('Please login to access this page/url.', 404);
        }
        if($user->ev){
            throw new Exception('Page is no more available for you. Your email is already verified', 404);
        }
        $user->sendVerificationEmail();
        View::renderBlade('register/verify_email');

    }

}