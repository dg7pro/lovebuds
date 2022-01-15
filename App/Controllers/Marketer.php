<?php

namespace App\Controllers;

use Core\Controller;
use Exception;

abstract class Marketer extends Controller
{
    /**
     *  Requires Administrator functionality
     *  to classes that extends this class
     * @throws Exception
     */
    protected function before()
    {
        parent::before();
        $this->requirePro();
    }

}