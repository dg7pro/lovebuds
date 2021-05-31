<?php


namespace App\Controllers;


use App\Models\Image;
use Core\View;

/**
 * Class Admin
 * @package App\Controllers
 */
class Admin extends Administered
{
    /**
     * Admin index page
     */
    public function indexAction(){

        View::renderBlade('admin.index');

    }

    /**
     * List all Users
     */
    public function listUsersAction(){

        View::renderBlade('admin.list_users');

    }


    /**
     * Show list of images for approval
     */
    public function photoApprovalAction(){

        $unApprovedUserImages = Image::getUnApprovedImages();
        $num = count($unApprovedUserImages);
        View::renderBlade('admin.photo-approval',['images'=>$unApprovedUserImages, 'num'=>$num]);
    }

    /**
     * Show list of images for Avatar update
     */
    public function makeAvatarAction(){

        $images = Image::imagesForAvatarUpdate();
        //var_dump($images);
        $num = count($images);
        View::renderBlade('admin.make-avatar',['images'=>$images,'num'=>$num]);

    }

}