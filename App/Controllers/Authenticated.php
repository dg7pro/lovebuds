<?php


namespace App\Controllers;


use Core\Controller;

/**
 * Class Authenticated
 * @package App\Controllers
 */
abstract class Authenticated extends Controller
{

    /**
     * Requires Login functionality
     * to class that inherits this class
     */
    protected function before()
    {
        parent::before();
        $this->requireLogin();
    }

}