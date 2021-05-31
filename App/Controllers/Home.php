<?php

namespace App\Controllers;


use App\Models\UserVariables;
use Core\Controller;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        //$this->requireGuest();

        View::renderBlade('home/index',[
            'languages'=>UserVariables::languages(),
            'religions'=>UserVariables::religions(),
            'age_rows'=>UserVariables::getAgeRows()
        ]);

    }

}
