<?php


namespace App\Controllers;

use App\Auth;
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
        // TODO: CSRF Protection of all forms
        $this->requireGuest();
        View::renderBlade('login/index');
    }

    /**
     *  Authenticate User
     */
    public function authenticateAction()
    {
        $user = User::authenticate($_POST['uid'],$_POST['password']);
        $remember_me = isset($_POST['remember_me']);   // true or false

        if($user){

            Auth::login($user,$remember_me);

            if($user->name==''){
                Flash::addMessage('Login Successful. Please complete the form');
                $this->redirect('/account/create-profile');
            }
            Flash::addMessage('Login Successful', Flash::SUCCESS);
            //Notification::addMessage($user->id,'Login Successful','You have successfully logged in','mdi mdi-nuke');
            //Notification::save('just_testing',$user->id);
            $this->redirect(Auth::getReturnToPage());

        }
        else{
            // TODO: Proper message why the user is unable to login
            Flash::addMessage('Login Un-Successful. Please try again', Flash::WARNING);
            View::renderBlade('login/index',['uid'=>$_POST['uid'],'remember_me'=>$remember_me]);
        }
    }

}