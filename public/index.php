<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Load env variables
 */
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Set default timezone to India
 */
date_default_timezone_set('Asia/Kolkata');


session_start();
/*if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}*/
$csrf = new App\Csrf();
$csrf_token = $csrf->getValue();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = $csrf_token;
}

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add('login', ['controller' =>'Login','action'=>'index']);
$router->add('register', ['controller' =>'Register','action'=>'index']);
$router->add('admin', ['controller' =>'Admin','action'=>'index']);
$router->add('pro', ['controller' =>'Pro','action'=>'index']);
$router->add('logout', ['controller' =>'Account','action'=>'logout']);

$router->add('dashboard', ['controller' =>'Account','action'=>'dashboard']);
$router->add('notifications', ['controller' =>'Account','action'=>'notifications']);
$router->add('settings', ['controller' =>'Account','action'=>'settings']);

$router->add('search', ['controller' =>'Search','action'=>'index']);
$router->add('my-profile', ['controller' =>'Profile','action'=>'index']);
$router->add('help', ['controller' =>'Company','action'=>'help']);
$router->add('promo', ['controller' =>'Home','action'=>'whatsapp-add']);

$router->add('{group:[a-z]+(?:-[a-z]+)*}', ['controller' => 'Group', 'action' => 'group-page']);

$router->add('{controller}/{action}');


//$router->add('{controller}/{action}/{un:[a-zA-Z0-9-\.]+}');
//$router->add('{controller}/{action}/{pid:([A-Z]{2}[0-9]{5})+}');
$router->add('profile/{pid:([A-Z]{2}[0-9]{5})+}',['controller' =>'Profile','action'=>'show']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('register/activate/{token:[\da-f]+}', ['controller' => 'Register', 'action' => 'activate']);

//$router->add('group/{slug:([A-Z]{2}[0-9]{5})+}',['controller' =>'Group','action'=>'page']);
$router->add('group/page/{slug:[a-zA-Z0-9-\.]+}',['controller' =>'Group','action'=>'page']);
$router->add('group/bride/{slug:[a-zA-Z0-9-\.]+}',['controller' =>'Group','action'=>'bride']);
$router->add('group/groom/{slug:[a-zA-Z0-9-\.]+}',['controller' =>'Group','action'=>'groom']);
$router->dispatch($_SERVER['QUERY_STRING']);

// Match the requested route
/*$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
} else {
    echo "No route found for URL '$url'";
}

// Display the routing table
echo '<pre>';
//var_dump($router->getRoutes());
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';*/



