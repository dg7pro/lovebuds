<?php


namespace App\Controllers;

use App\Csrf;
use App\Flash;
use App\Models\User;
use App\Models\UserVariables;
use Core\Controller;
use Core\View;

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

            $user->sendActivationEmail();
            $this->redirect('/register/success');

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
        User::activate($this->route_params['token']);

        $this->redirect('/register/activated');
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

}