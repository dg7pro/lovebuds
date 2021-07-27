<?php

namespace App\Controllers;


use App\Flash;
use App\Lib\Helpers;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserVariables;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
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

        View::renderBlade('home/index',[
            'languages'=>UserVariables::languages(),
            'religions'=>UserVariables::religions(),
            'age_rows'=>UserVariables::getAgeRows()
        ]);

    }

    /*
     * Testing Functions
     * Just for reference and testing
     * tobe deleted
     * */

    public function wrongAction(){

        View::renderBlade('home/wrong');

    }

    public function session(){
        //var_dump($_SESSION);

//        $dt = Carbon::now();
//        echo $dt->toFormattedDateString();


        $castes = UserVariables::getCountries();
        Helpers::dnd($castes);

    }

    public function whatsappAction(){

        $self1 = 918887610230;
        $self2 = 917565097233;
        $other = 919335333717;
        View::renderBlade('home/whatsapp',[
            'self1'=>$self1,
            'self2'=>$self2,
            'other'=>$other
        ]);
    }

    public function secureAction(){

        /*$e = 'geeksforgeeks@gmail.com ';
        $e_san = filter_var($e,FILTER_SANITIZE_EMAIL);
        echo $e_san;
        echo "<br>";
        $flag = filter_var($e,FILTER_VALIDATE_EMAIL);
        echo $flag;*/

        /*$profiles = User::newlist(1503);
        var_dump($profiles);*/

        $s = new Setting();
        echo $s->get_partner_preference_search();

    }

    public function testAction(){

        $cUser = User::findByID(1);
        //var_dump($cUser->langs);
        echo $cUser->langs == "[]"? json_encode($cUser->langs):'false';

    }

    public function fbImgAction(){

        echo '<img src="/img/showcase.jpg">';

    }

    public function font(){
        View::renderBlade('home/font');
    }

    public function short(){
        $results = User::testQuery($_SESSION['user_id'],0,10);
        //var_dump($results);
        Helpers::dnd($results);
        exit();
    }
    public function shortNew(){
        $results = User::testQuery2($_SESSION['user_id'],0,10);
        //var_dump($results);
        Helpers::dnd($results);
        exit();
    }

    public function checkbox(){

        //View::renderBlade('home/checkbox');

//        $countries = UserVariables::getCountries();
//        Helpers::dnd($countries);


    }

}
