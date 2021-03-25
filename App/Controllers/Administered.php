<?php


namespace App\Controllers;


use Core\Controller;

/**
 * Class Administered
 * @package App\Controllers
 */
abstract class Administered extends Controller
{

    /**
     *  Requires Administrator functionality
     *  to classes that extends this class
     */
    protected function before()
    {
        parent::before();
        $this->requireAdmin();
    }

}