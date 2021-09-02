<?php

namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Lib\Helpers;
use App\Models\Image;
use App\Models\Member;
use App\Models\Notification;
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
        var_dump($_SESSION);
       /* echo "<br>";
        var_dump(Auth::getUser());

        echo "<br>";
        var_dump(Auth::getUser());*/

//        $dt = Carbon::now();
//        echo $dt->toFormattedDateString();


//        $castes = UserVariables::getCountries();
//        Helpers::dnd($castes);

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

        //$cUser = User::findByID(1);
        //var_dump($cUser->langs);
        //echo $cUser->langs == "[]"? json_encode($cUser->langs):'false';


        $results = User::testSql2();
        Helpers::dnd($results);

    }

    public function fbImgAction(){

        echo '<img src="/img/showcase.jpg">';

    }

    public function font(){
        //View::renderBlade('home/font');

        /*$notice = new Notification();
        echo $notice->countDuplicateEntry(108,109);*/

        //echo date();
        $flag = 0;
        if(file_exists('uploaded/pics/60fe711bd4a8e_jhjh.jpg')){
            $f1 = unlink('uploaded/pics/60fe711bd4a8e_jhjh.jpg');
            $f2 = unlink('uploaded/tmb/tn_60fe711bd4a8e_jhjh.jpg');
            if($f1 && $f2){
                $flag = 1;
            }
        }

        echo $flag;
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

        //View::renderBlade('/register/verify_mobile');
        //View::renderBlade('home/checkbox');

//        $countries = UserVariables::getCountries();
//        Helpers::dnd($countries);

        $newImage = new Image();
        $user = Auth::getUser();

        var_dump($user);
        echo "<br><br><br>";
        $newImage->persistUserImage2($user);


    }

}
