<?php


namespace App\Controllers;


use App\Models\Image;
use App\Models\Kyc;
use App\Models\User;
use Core\View;

/**
 * Class Admin
 * @package App\Controllers
 */
class Admin extends Administered
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function dashboardAction()
    {
        $paidUC = User::getPaidUserCount();
        $total_revenue = 200*$paidUC;
        $newMembers = count(User::newMembers());
        $unApprovedPhoto = count(Image::getUnApprovedImages());
        $unApprovedKYC = count(Kyc::getUnapprovedList());
        $avatarUpdateCount = count(Image::imagesForAvatarUpdate());
        View::renderBlade('admin.dashboard',['total_revenue'=>$total_revenue, 'uak'=>$unApprovedKYC, 'uap'=>$unApprovedPhoto, 'auc'=>$avatarUpdateCount, 'new'=>$newMembers,]);
    }

    /**
     * Show new members list
     * to admin
     */
    public function newAccountAction(){

        $newMembers = User::newMembers();
        View::renderBlade('admin.new-members',['newMembers'=>$newMembers]);
    }

    /**
     * Show the total
     * Revenue generated
     */
    public function totalRevenueAction(){

        $paidMembers = User::recentPaidMembers();
        View::renderBlade('admin.revenue',['paidMembers'=>$paidMembers]);

    }

    /**
     * Show list of all
     * pending photo approval request
     */
    public function photoApprovalAction(){

        $unApprovedUserImages = Image::getUnApprovedImages();
        $num = count($unApprovedUserImages);
        View::renderBlade('admin.photo-approval',['images'=>$unApprovedUserImages, 'num'=>$num]);
    }

    /**
     *
     */
    public function makeAvatarAction(){

        $images = Image::imagesForAvatarUpdate();
        //var_dump($images);
        $num = count($images);
        View::renderBlade('admin.make-avatar',['images'=>$images,'num'=>$num]);

    }

    /**
     *
     */
    public function pendingKycAction(){

        View::renderBlade('admin.pending-kyc');

    }

}