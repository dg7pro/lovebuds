<?php


namespace App\Controllers;


use App\Models\ConnectProfile;
use App\Models\Image;
use App\Models\User;
use Core\Controller;
use Core\View;

class Profile extends Controller
{
    public function showAction(){

        $pid = $this->route_params['pid'];
        $profile = User::findByProfileId($pid);
        if(!$profile){
            throw new \Exception('Profile does not exist with this profile id.', 404);
        }

        $flag = '';
        if(isset($_SESSION['user_id'])){
            $flag = ConnectProfile::getUserConnectionFlag($_SESSION['user_id'],$profile->id);
            /*$like = User::getLikeStatusOff($_SESSION['user_id'],$profile->id);
            $fav = User::getFavStatusOff($_SESSION['user_id'],$profile->id);
            $hide = User::getHideStatusOff($_SESSION['user_id'],$profile->id);*/

        }
        $addressFlag = $flag;


        $images = Image::fetchProfileImages($profile->id);

        $pn='';
        $max='';
        if(isset($_SESSION['chain'])){
            $pn = array_search($profile->pid, $_SESSION['chain']);
            $max = count($_SESSION['chain']);
        }


        View::renderBlade('profile.show',
            ['profile'=>$profile,'flag'=>$flag,'addressFlag'=>$addressFlag,'images'=>$images,'pn'=>$pn,'max'=>$max]);

    }
    // TODO: Check Properly

}