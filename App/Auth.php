<?php


namespace App;


use App\Models\RememberedLogin;
use App\Models\User;
use Core\Controller;

/**
 * Class Auth
 * @package App
 */
class Auth extends Controller
{
    /**
     * @param $user
     * @param $remember_me
     */
    public static function login($user, $remember_me){

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user->id;

        if($remember_me){

            if($user->rememberLogin()){

                setcookie('remember_me',$user->remember_token,$user->expiry_timestamp,'/');

            }
        }

    }

    /**
     *  Destroy user session and logout
     */
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

    /**
     * Check if user is logged in
     * @return bool
     */
    public static function isLoggedIn(): bool
    {

        return isset($_SESSION['user_id']);

    }

    /**
     * Remembers page where user intended
     * to go before login
     */
    public static function rememberRequestedPage(){

        $_SESSION['return_to']=$_SERVER['REQUEST_URI'];
    }

    /**
     * Used for redirection to intended page
     * @return mixed|string
     */
    public static function getReturnToPage(){

        return $_SESSION['return_to'] ?? '/account/dashboard';

    }

    /**
     * Get Auth User
     * @return mixed
     */
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

    /**
     * Check if current user is admin
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return self::isLoggedIn() && self::getUser()->is_admin;
    }

    /**
     * Check is current user is Guest
     * @return bool
     */
    public static function isGuest(): bool
    {

        return self::isLoggedIn() !== true;

    }

    /**
     * get primary key of logged user
     * @return mixed
     */
    public static function id(){

        return self::getUser()->id;

    }

}