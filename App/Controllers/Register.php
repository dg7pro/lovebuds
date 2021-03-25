<?php


namespace App\Controllers;

use App\Flash;
use App\Models\User;
use Core\Controller;
use Core\View;

/**
 * Class Register
 * @package App\Controllers
 */
class Register extends Controller
{

    //TODO : Create Separate Registration page

    /**
     * Shows the registration page or index
     * page where register form is present
     */
    public function indexAction()
    {
        $this->requireGuest();
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/home/index');

    }

    /**
     * Persist and register new user
     */
    public function createAction()
    {
        $user = new User($_POST);
        if($user->save()){

            $user->sendActivationEmail();
            $this->redirect('/register/success');

        }else{

            foreach($user->errors as $error){
                Flash::addMessage($error,'danger');
            }
            $this->redirect('/home/index');

        }

    }

    /**
     * Shows success page
     */
    public function successAction(){
        View::renderBlade('Register/success');
    }

    /**
     * Activate a new account
     *
     * @return void
     */
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/Register/activated');
    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activatedAction()
    {
        View::renderBlade('Register/activated');
    }

}