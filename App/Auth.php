<?php


namespace App;


use App\Lib\Helpers;
use App\Models\Profile;
use App\Models\RememberedLogin;
use App\Models\User;
use App\Models\UserConnections;
use Core\Controller;

class Auth extends Controller
{
    public static function login($user, $remember_me){

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user->id;

        $_SESSION['recommended_profiles'] = UserConnections::recommendedIds();
        $_SESSION['new_profiles'] = UserConnections::newProfileIds();
        $_SESSION['visitor_profiles'] = UserConnections::visitorIds();
        $_SESSION['reminder_send'] = [];


        if($remember_me){

            if($user->rememberLogin()){

                setcookie('remember_me',$user->remember_token,$user->expiry_timestamp,'/');

            }
        }


    }

    public static function logout(){

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        static::forgetLogin();

    }

    public static function isLoggedIn(){

        return isset($_SESSION['user_id']);

    }

    public static function rememberRequestedPage(){

        $_SESSION['return_to']=$_SERVER['REQUEST_URI'];
    }

    public static function getReturnToPage(){

//        return isset($_SESSION['return_to']) ? $_SESSION['return_to'] :'/';
        return $_SESSION['return_to'] ?? '/account/welcome';

    }

    public static function getUser(){

        if(isset($_SESSION['user_id'])){
            return User::findByID($_SESSION['user_id']);
        }else{

            return self::loginFromRememberCookie();
        }

    }

    /**
     * Login the user from a remembered login cookie
     *
     * @return mixed The user model if login cookie found; null otherwise
     */
    protected static function loginFromRememberCookie()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = RememberedLogin::findByToken($cookie);

            if ($remembered_login && ! $remembered_login->hasExpired()) {

                $user = $remembered_login->getUser();

                static::login($user, false);

                return $user;
            }
        }
    }

    /**
     * Forget the remembered login, if present
     *
     * @return void
     */
    protected static function forgetLogin()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = RememberedLogin::findByToken($cookie);

            if ($remembered_login) {

                $remembered_login->delete();

            }

            setcookie('remember_me', '', time() - 3600,'/');  // set to expire in the past
        }
    }



    public static function displayName(){

        if(isset($_SESSION['user_id'])) {
//            return (self::getUser()->name == '') ? (self::getUser()->pid) : (self::getUser()->name);
            return (self::getUser()->first_name == '') ? (self::getUser()->pid) :
                (self::getUser()->first_name.' '.self::getUser()->last_name);
        }
    }

    public static function isAdmin(){
        return self::isLoggedIn() && self::getUser()->is_admin;
    }

    public static function isGuest(){

        return self::isLoggedIn() !== true;

    }

    public static function id(){

        return self::getUser()->id;

    }

    /*public static function userLikes(){

        if(isset($_SESSION['user_id'])) {
            $user_likes = self::getUser()->like_array;
            return Helpers::emptyStringIntoArray($user_likes);
        }
    }

    public static function userShorts(){

        if(isset($_SESSION['user_id'])) {
            $user_shorts = self::getUser()->short_array;
            return Helpers::emptyStringIntoArray($user_shorts);
        }
    }

    public static function userHides(){

        if(isset($_SESSION['user_id'])) {
            $user_hides = self::getUser()->hide_array;
            return Helpers::emptyStringIntoArray($user_hides);
        }

    }*/



}