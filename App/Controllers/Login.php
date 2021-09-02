<?php


namespace App\Controllers;

use App\Auth;
use App\Csrf;
use App\Flash;
use App\Models\User;
use Core\Controller;
use Core\View;

/**
 * Class Login
 * @package App\Controllers
 */
class Login extends Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        $this->requireGuest();

        //Flash::addMessage('Enter your account credentials to login...', Flash::WARNING);

        View::renderBlade('login/index');

    }

    /**
     *  Authenticate User
     */
    public function authenticateAction()
    {
        $csrf = new Csrf($_POST['token']);
        if(!$csrf->validate()){
            unset($_SESSION["csrf_token"]);
            die("CSRF token validation failed");
        }

        $this->checkEmail($_POST);
        $user = User::authenticate($_POST['uid'],$_POST['password']);
        $remember_me = isset($_POST['remember_me']);   // true or false

        if($user){

            // If both email and mobile is not verified we can't continue
            if(!$user->ev && !$user->mv){
                echo "Your account is not activated yet please verify your email or mobile to continue...";
                exit();
                // TODO: new page to be created
                /*$this->redirect('/login/activate-account?email='.$user->email);
                exit();*/
            }

            if($user->is_block){
                //$this->redirect('/login/activate-account?email='.$user->email);
                echo "We can't login you, your account has been blocked";
                exit();
            }

            Auth::login($user,$remember_me);

            if(!$user->is_active){
                Flash::addMessage('Login Successful. Please complete the form');
                $this->redirect('/account/create-profile');
            }
            Flash::addMessage('Login Successful', Flash::SUCCESS);

            $this->redirect(Auth::getReturnToPage());

        }
        else{

            Flash::addMessage('Invalid Credentials. Enter correct email & password', Flash::DANGER);
            View::renderBlade('login/index',['uid'=>$_POST['uid'],'remember_me'=>$remember_me]);
        }
    }

    /**
     * Sanitize and validate email
     * @param $arr
     */
    protected function checkEmail($arr){

        $email = filter_var($arr['uid'],FILTER_SANITIZE_EMAIL);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            Flash::addMessage('Invalid Email. Please enter a valid email', Flash::DANGER);
            View::renderBlade('login/index');
        }

    }

    /**
     * Ask inactive user to resend activation link
     */
    public function activateAccountAction(){

        $email = $_GET['email'] ?? '';
        View::renderBlade('login/resend_activation_link',['email'=>$email]);
    }

}