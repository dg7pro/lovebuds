<?php

namespace App\Controllers;

use App\Auth;
use App\Models\RecordContact;
use App\Models\User;
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

    /**
     * Show the index page
     *
     * @return void
     */
    public function testAction()
    {
        //var_dump(Auth::getUser());
//        $visitors = User::recentVisitor(6);
//        var_dump($visitors);

        //var_dump(RecordContact::getRC());
//        $new = new RecordContact();
//        var_dump($new->checkEarlierRecord(6,1007));
        //var_dump($new);

//        $heights = UserVariables::fetch('heights');
//        $htArray = json_decode(json_encode($heights), true);
//        echo count($htArray);
//        echo "<br>";
//        print($htArray[0]['feet']);

        $user = Auth::getUser();
        var_dump(implode(',',json_decode($user->mycastes)));
    }

}
