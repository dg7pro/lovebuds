<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Image;
use App\Models\MoveProfile;
use App\Models\Notification;
use App\Models\RecordContact;
use App\Models\User;
use App\Models\VisitProfile;
use App\Sms;

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

        $msg='';
        $flag=false;
        if(isset($_POST['uid']) && isset($_POST['pid'])){

            $userId=$_POST['uid'];
            $profileId = $_POST['pid'];

            $notification = new Notification();

            if($userId!=$profileId){

                $vp = new VisitProfile();
                $con = $vp->checkRow($profileId);

                if($con){
                    $flag = $vp->updateRow($profileId);
                }else{
                    $flag = $vp->insertRow($profileId);
                    $notification->informAboutProfileVisitor($profileId);
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

        //$usr = Auth::getUser();
        //$uid = $_SESSION['user_id'];
        if(isset($_POST['fb'])){
            $user = Auth::getUser();
            $result = $user->markFB();
            if($result){
                echo 'Your account credited with 100 contacts with no time expiry';
            }else{
                echo 'Some thing went wrong';
            }
        }

    }

    /*protected function createContact($oid){

        $info = User::getContact($oid);

        if($info->one_way){
            $output = '<span><i class="fab fa-info-circle"></i> Member has been informed that you are interested</span>';
        }else {
            $output = '<span><i class="fab fa-whatsapp"></i> ' . $info->whatsapp . '</span>
                                <span class="mr-1"><i class="fas fa-phone-alt"></i>  ' . $info->mobile . '</span>
                                <span class="ml-3"><i class="far fa-envelope"></i> ' . $info->email . '</span>';
            $output = '';
        }
        return $output;
    }*/


    /**
     * Deprecated
     *  Show & record viewed Contact
     */
    public function showContactOld(){

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])){

            $uid = $_SESSION['user_id'];
            $oid = $_POST['other_id'];
            $flag = '';

            $cc = false;
            $info = User::getContact($oid);
            if($info->one_way){
                $addr = '<span><i class="fab fa-info-circle"></i> Member has been informed that you are interested</span>';
                $cc = true;
            }else {
                $addr = '';
                $cc = false;
            }
            //$addr = self::createContact($oid);

            if($uid != $oid){
                $rc = new RecordContact();
                if($rc->create($uid,$oid)){

                    $user = Auth::getUser();
                    $flag = $user->incrementAc();
                    $msg = ($flag)?'Success You viewed the contact info of profile: it\'s counted':'Unable to fetch contact info';

                }else{
                    $msg = 'You have already viewed the contact info of this profile earlier: not counted';
                }
            }else{
                $msg = "This is your profile: not Counted!";
            }
        }else{
            $msg = 'Please Login';
            $addr = 'Please login to see contact info';
            $cc = true;
        }
        $_data_arr = ['flag'=>$flag, 'msg'=>$msg, 'addr'=>$addr, 'cc'=>$cc];
        echo json_encode($_data_arr);

    }


    /**
     *  Show & record viewed Contact
     */
    public function showContact(){

        $addr = '';
        $flag = '';
        $cc = false;

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])){

            $otherId = $_POST['other_id'];              // Other member
            $notification = new Notification();         // Get Notification instance
            $user = Auth::getUser();                    // Get Auth User

            if($otherId==$_SESSION['user_id']){

                $msg = "This is your profile: not Counted!";
                $json_data = ['flag'=>$flag, 'msg'=>$msg, 'addr'=>$addr, 'cc'=>$cc];
                $this->echoJson($json_data);

            }

            if($this->isOnewayEnabled($otherId)){

                $notification->informAboutInterestedMember($otherId);

                $msg = "You can't see address of this user due to his/her privacy settings";
                $addr = '<span><i class="fab fa-info-circle"></i> Member has been informed that you are interested</span>';
                $cc = true;
                $json_data = ['flag'=>$flag, 'msg'=>$msg, 'addr'=>$addr, 'cc'=>$cc];
                $this->echoJson($json_data);

            }

            if($this->isCBlocked($user)){

                $msg = "Verification is done to safeguard interest of all users";
                $addr = '<span><i class="fab fa-info-circle"></i> Please verify your account to see address <a href="/account/aadhar-verification">click me</a> </span>';
                $cc = true;
                $json_data = ['flag'=>$flag, 'msg'=>$msg, 'addr'=>$addr, 'cc'=>$cc];
                $this->echoJson($json_data);

            }

            if(!$this->haveCredits($user)){
                $msg = "You do not have enough credits to see address ";
                $addr = '<span><i class="fab fa-info-circle"></i> Please make onetime payment of just Rs. 200 <a href="/account/pay">Pay now </a> </span>';
                $cc = true;
                $json_data = ['flag'=>$flag, 'msg'=>$msg, 'addr'=>$addr, 'cc'=>$cc];
                $this->echoJson($json_data);
            }else{
                $rc = new RecordContact();
                if($rc->create($user->id,$otherId)){

                    $notification->informAboutContactViewed($otherId);

                    $flag = $user->incrementAc();
                    $msg = ($flag)?'Success You viewed the contact info of profile: Counted':'Unable to fetch record';
                }else{
                    $msg = 'You have already viewed the contact info of this profile earlier: Not counted';
                }
                $json_data = ['flag'=>$flag, 'msg'=>$msg, 'addr'=>$addr, 'cc'=>$cc];
                $this->echoJson($json_data);
            }


        }else{
            $msg = "Please login to continue.";
            $json_data = ['flag'=>$flag, 'msg'=>$msg, 'addr'=>$addr, 'cc'=>$cc];
            $this->echoJson($json_data);
        }

    }

    public function acceptInterest(){

        if(isset($_SESSION['user_id']) && isset($_POST['notice_id'])){

            $noticeId = $_POST['notice_id'];

            $notification = new Notification();

            if($notification->informAboutAcceptInterest($noticeId)){
                $msg = "We have send your contact details to the member";
                $flag = true;
                $json_data = ['flag'=>$flag, 'msg'=>$msg];
                $this->echoJson($json_data);
            }

        }

    }

    private function echoJson($json_data){
        echo json_encode($json_data);
        exit();
    }

    private function isOnewayEnabled($oid): bool
    {
        $otherUser = User::getContact($oid);
        if($otherUser->one_way){
            return true;
        }
        return false;
    }

    private function isCBlocked(User $user): bool
    {
        if($user->c_block){
            return true;
        }
        return false;
    }

    private function haveCredits(User $user): bool
    {
        $credits = $user->credits;
        $address_count = $user->ac;
        $num = $credits-$address_count;
        if($num>0){
            return true;
        }
        return false;

    }

    public function generatePersistOtp(){

        $user = Auth::getUser();
        $result = $user->createNewOtp();

        if($result){
            $flag = true;
            $msg = "Otp generated successfully";
            // temporary
            //$_SESSION['otp']=$user->otp;
            Sms::sendOtp($user->mobile,$user->otp);

        }else{
            $flag = false;
            $msg = "Sorry! Otp can't be generated";
        }


        $json_data = ['msg'=>$msg,'flag'=>$flag];
        echo json_encode($json_data);
    }

}