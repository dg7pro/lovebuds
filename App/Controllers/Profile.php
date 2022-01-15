<?php


namespace App\Controllers;


use App\Models\Image;
use App\Models\Reference;
use App\Models\User;
use Core\Controller;
use Core\View;
use Exception;

/**
 * Class Profile
 * @package App\Controllers
 */
class Profile extends Controller
{
    /**
     * @throws Exception
     */
    public function showAction(){

        $pid = $this->route_params['pid'];
        $profile = User::findByProfileId($pid);
        if(!$profile){
            throw new Exception('Profile does not exist with this profile id.', 404);
        }

        $cookie_name = "ju_reference_code";
        //$cookie_value = md5($pid);
        $cookie_value = uniqid();

        if($profile->is_pro && !isset($_COOKIE[$cookie_name])) {

            if($this->generateReference($profile->id,$cookie_value)){
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            }

        }

        /*$this->persistReference($profile->id);
        if(isset($_COOKIE['ju_reference_code'])){
            if(!Reference::checkEntry($_COOKIE['ju_reference_code'])){
                $this->persistReference($profile->id);
            }
        }*/

        $images = Image::fetchProfileImages($profile->id);

        View::renderBlade('profile.show',
            ['profile'=>$profile,'images'=>$images]);

    }

    public function generateReference($id,$code): bool
    {
        $user = User::findByID($id);
        $ref = new Reference();
        return $ref->save($user,$code);
    }


    /*public function persistReference($id): bool
    {
        $user = User::findByID($id);
        $ref = new Reference();
        $flag = false;

        if(isset($_COOKIE['ju_reference_code'])) {
            $flag=$ref->save($user,$_COOKIE['ju_reference_code']);
        }
        return $flag;
    }*/

}