<?php

namespace Core;

use App\Auth;
use App\Flash;
use Jenssegers\Blade\Blade;

/**
 * View
 *
 * PHP version 7.0
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        echo static::getTemplate($template, $args);

    }

    /**
     * Get the contents of a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return string
     */
    public static function getTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('session', $_SESSION);
            $twig->addGlobal('isLoggedIn', Auth::isLoggedIn());
            $twig->addGlobal('current_user', Auth::getUser());
            $twig->addGlobal('is_admin', Auth::isAdmin());
        }

        return $twig->render($template, $args);

    }


    public static function renderView(){

        static $blade = null;

        if($blade === null){
            $blade = new Blade(dirname(__DIR__) . '/App/Views',dirname(__DIR__) . '/App/Views/cache');
        }
        /*$user =Auth::getUser();
        $displayName = $user->name==''?$user->pid:$user->name;

        $blade->share('authUser',$user);
        $blade->share('displayName',$displayName);*/

        $blade->share('authUser',Auth::getUser());
        $blade->share('displayName',Auth::displayName());

        return $blade;
    }

    public static function createBlade(){

        static $blade = null;

        if($blade === null){
            $blade = new Blade(dirname(__DIR__) . '/App/Views',dirname(__DIR__) . '/App/Views/cache');
        }
        /*$user =Auth::getUser();
        $displayName = $user->name==''?$user->pid:$user->name;

        $blade->share('authUser',$user);
        $blade->share('displayName',$displayName);*/

        $user = Auth::getUser();

        $blade->share('authUser',$user);
        $blade->share('displayName',Auth::displayName());
        $blade->share('flash_messages',Flash::getMessage());

        if($user) {
            $blade->share('user_likes_array', $user->likesArr());
            $blade->share('user_shorts_array', $user->shortsArr());
            $blade->share('user_hides_array', $user->hidesArr());
        }
        else{
            $blade->share('user_likes_array', []);
            $blade->share('user_shorts_array', []);
            $blade->share('user_hides_array', []);
        }
        return $blade;
    }

    public static function renderBlade($page,$data=[]){

        echo self::createBlade()->make($page,$data);

    }
}
