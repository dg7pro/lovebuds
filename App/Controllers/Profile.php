<?php


namespace App\Controllers;


use App\Models\Image;
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

        $images = Image::fetchProfileImages($profile->id);

        View::renderBlade('profile.show',
            ['profile'=>$profile,'images'=>$images]);

    }

}