<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Image;
use App\Models\MoveProfile;
use App\Models\RecordContact;
use App\Models\User;
use App\Models\VisitProfile;

/**
 * Class AjaxActivity
 * @package App\Controllers
 */
class AjaxActivity extends Ajax
{
    /**
     *  Move profile to shortlist/downlist
     */
    public function moveProfileToAction(){

        $this->includeCheck();
        if(isset($_SESSION['user_id']) && isset($_POST['receiver'])) {

            $sender = $_SESSION['user_id'];
            $receiver = $_POST['receiver'];
            $index = $_POST['i'];

            if($index==1){
                $downlist_array = Connection::currentDownlist();

                if(in_array($receiver,$downlist_array)) {

                    $msg = 'You have already hide this profile';
                    $flag = false;

                    $re = ['flag'=>$flag,'msg'=>$msg];
                    echo json_encode($re);
                    exit();
                }
            }elseif($index==2){

                $shortlist_array = Connection::currentShortlist();
                if(in_array($receiver,$shortlist_array)) {

                    $msg = 'You have already shorted this profile';
                    $flag = false;

                    $re = ['flag'=>$flag,'msg'=>$msg];
                    echo json_encode($re);
                    exit();

                }

            }else{
                $msg = 'Something is not right';
                $flag = false;

                $re = ['flag'=>$flag,'msg'=>$msg];
                echo json_encode($re);
                exit();
            }

            if($sender != $receiver){
                $result = MoveProfile::create($sender,$receiver,$index);
                if($result){

                    $msg = ($index==1)?'Profile moved to hidden list':'Profile moved to shortlist';
                    $flag = true;
                    //array_push($_SESSION['user_likes'],$profile_id);
                }else{
                    $msg= 'You have already moved this profile';
                    $flag = false;
                }
            }else{
                $msg = "It is your profile";
                $flag = false;
            }

        }else{
            $msg = 'Please login to continue';
            $flag = false;
        }
        $re = ['flag'=>$flag,'msg'=>$msg];
        echo json_encode($re);
    }

    /**
     *  Deprecated ~ kept for reference
     *  Move profile to shortlist/downlist
     */
    public function moveProfileAction(){

        $this->includeCheck();
        if(isset($_SESSION['user_id']) && isset($_POST['receiver'])) {

            $sender = $_SESSION['user_id'];
            $receiver = $_POST['receiver'];
            $index = $_POST['i'];

            if($index==1){
                $downlist_array = Connection::currentDownlist();

                if(in_array($receiver,$downlist_array)) {

                    $message = 'You have already hide this profile';
                    echo $message;
                    exit();
                }
            }elseif($index==2){

                $shortlist_array = Connection::currentShortlist();
                if(in_array($receiver,$shortlist_array)) {

                    $message = 'You have already shorted this profile';
                    echo $message;
                    exit();
                }

            }else{
                $message = 'Something is not right';
                echo $message;
                exit();
            }

            if($sender != $receiver){
                $result = MoveProfile::create($sender,$receiver,$index);
                if($result){

                    $message = ($index==1)?'Profile moved to hidden list':'Profile moved to shortlist';
                    //array_push($_SESSION['user_likes'],$profile_id);
                }else{
                    $message= 'You have already moved this profile';
                }
            }else{
                $message = "It is your profile";
            }

        }else{
            $message = 'Please login to continue';
        }
        echo $message;
    }

    /**
     * Delete image functionality for users
     */
    public function deleteImage(){

        $this->includeCheck();
        if(isset($_SESSION['user_id'])) {

            $userId = $_SESSION['user_id'];
            if (isset($_POST['fn']) && isset($_POST['iid'])) {

                $ds = 0;
                $fn = $_POST['fn'];                                 // File name of the image to be deleted
                $iid = $_POST['iid'];                               // Image Id: Unique number assigned during upload

                $row = Image::getImageFromImageId($userId,$iid);

                if ($row->pp == 0) {

                    $statusD = Image::unlinkImage($userId,$iid);
                    //$statusD = 1;

                    if($statusD){
                        $msg = "Image deleted successfully";
                        $ds = 1;
                    }else {
                        $msg = "Image Could not be deleted";
                        $ds = 0;
                    }


                }else{
                    $msg = "Profile Image can not be deleted";
                    $ds = 0;
                }
                $data = ['msg'=>$msg,'ds'=>$ds,'iid'=>$iid];
                echo json_encode($data);
            }
        }
    }

    /**
     *  Change avatar functionality for users
     */
    public function changeAvatar(){

        $this->includeCheck();
        $userId = $_SESSION['user_id'];

        if(isset($_POST['fn']) && isset($_POST['iid'])) {

            $fn = $_POST['fn'];
            $iid = $_POST['iid'];

            $status = Image::changeSelfAvatar($userId,$iid,$fn);

            if($status){
                $msg = "Avatar Changed successfully";
            }else{
                $msg = "Something went wrong please try after sometime";
            }

            $idata = ['msg'=>$msg,'iid'=>$iid];
            echo json_encode($idata);

        }
    }

    /**
     * Record Profile Visitors
     */
    public function recordVisitorAction(){

        $this->includeCheck();
        $msg='';
        $flag=false;
        if(isset($_POST['uid']) && isset($_POST['pid'])){

            $userId=$_POST['uid'];
            $profileId = $_POST['pid'];

            if($userId!=$profileId){

                $con = VisitProfile::checkRow($profileId);

                if($con){
                    $flag = VisitProfile::updateRow($profileId);
                }else{
                    $flag = VisitProfile::insertRow($profileId);
                }

                $msg = ($flag)?"Recorded profile visitor":"Something went wrong!";


            }else{
                $msg = "This is your profile";
                $flag = false;
            }
        }
        $data = ['msg'=>$msg,'uid'=>$userId,'flag'=>$flag];
        echo json_encode($data);

    }


    /**
     * Record Facebook Add post
     */
    public function setFBAdd(){

        $this->includeCheck();

        //$usr = Auth::getUser();
        $uid = $_SESSION['user_id'];
        if(isset($_POST['fb'])){
            $result = User::markFB($uid);
            if($result){
                echo 'Your account credited with 100 contacts with no time expiry';
            }else{
                echo 'Some thing went wrong';
            }
        }

    }

    protected function createContact($oid){

        $info = User::getContact($oid);

        if($info->one_way){
            $output = '<span><i class="fab fa-info-circle"></i> Member has been informed that you are interested</span>';
        }else {
            $output = '<span><i class="fab fa-whatsapp"></i> ' . $info->whatsapp . '</span>
                                <span class="mr-1"><i class="fas fa-phone-alt"></i>  ' . $info->mobile . '</span>
                                <span class="ml-3"><i class="far fa-envelope"></i> ' . $info->email . '</span>';
        }
        return $output;
    }


    /**
     *  Show & record viewed Contact
     */
    public function showContact(){

        $this->includeCheck();

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])){

            $uid = $_SESSION['user_id'];
            $oid = $_POST['other_id'];
            $flag = '';

            $addr = self::createContact($oid);

            if($uid != $oid){
                $rc = new RecordContact();
                if($rc->create($uid,$oid)){

                    $user = Auth::getUser();
                    $flag = $user->incrementAc();
                    $msg = ($flag)?'Success You viewed the contact info of profile':'Not Increment';

                }else{
                    $msg = 'Already in record';
                }
            }else{
                $msg = "This is your profile. Not Counted!";
            }
        }else{
            $msg = 'Please Login';
            $addr = 'Please login to see address';
        }
        $_data_arr = ['flag'=>$flag,'msg'=>$msg, 'addr'=>$addr];
        echo json_encode($_data_arr);

    }

}