<?php


namespace App\Controllers;


use App\Auth;
use App\Lib\Helpers;
use App\Models\ConnectProfile;
use App\Models\HideProfile;
use App\Models\Image;
use App\Models\LikeProfile;
use App\Models\Notification;
use App\Models\ShortlistProfile;
use App\Models\User;
use App\Models\VisitProfile;
use Core\Controller;
use Core\Model;


/**
 * Class Ajax -- To do
 *
 * @package App\Controllers
 */
class Ajax extends Controller
{

    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    /* ***************************************
     *  Ajax User Registration Functions
     * ***************************************
     * */

    /**
     * Select User Gender
     */
    public function selectGenderAction(){

        $male = [2,4];
        $female = [3,5];
        $ambiguous = [1,6,7];

        if(isset($_POST['cfor'])){

            $cfor = $_POST['cfor'];
            if(in_array($cfor,$male)){
                $gender = 'male';
                $val = 1;
            }elseif (in_array($cfor,$female)){
                $gender = 'female';
                $val = 2;
            }else{
                $gender = 'ambiguous';
                $val = '';
            }

        }

        $_data_arr = ['gender'=>$gender,'val'=>$val];
        echo json_encode($_data_arr);

    }

    /**
     * Check User Email Input
     */
    public function checkEmailAction(){

        if(isset($_POST['em'])){

            $em = $_POST['em'];

            if($em=='' ){
                $n=0;
                $ht = 'Empty value';
            }
            elseif (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                $n=0;
                $ht = 'Enter valid email address';
            }
            else{

                $user = User::findByEmail($em);

                //var_dump($num);
                if($user){
                    $n=0;
                    $ht = 'This email exist in our database';
                }else{
                    $n=1;
                    $ht = 'Looks Good!';
                }
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);
    }

    /**
     * Check User Mobile Input
     */
    public function checkMobileAction(){

        if(isset($_POST['mb'])){

            $mb = $_POST['mb'];

            if($mb == '' ){
                $n=0;
                $ht = 'Empty value';
            }
            elseif (!preg_match("/^[6-9]\d{9}$/",$mb)) {
                $n=0;
                $ht = 'Enter 10 digits valid mobile';
            }
            else{

                $user = User::findByMobile($mb);

                if($user){
                    $n=0;
                    $ht = 'This mobile exist in our database';
                }else{
                    $n=1;
                    $ht = 'Looks Good!';
                }
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);

    }

    /**
     * Check User Password Input
     */
    public function checkPassword(){

        // TODO: regular expression for password easier
        if(isset($_POST['pw'])){

            $pw = $_POST['pw'];

            if($pw == '' ){
                $n=0;
                $ht = 'Empty value';
            }
            elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*^#?&]{7,}$/",$pw)) {
                $n=0;
                $ht = 'Min: (7 digits) & 1 number';
            }
            else{
                $n=1;
                $ht = 'Looks Good!';
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);
    }


    /* ***************************************
     *  Ajax User Activity Functions
     * ***************************************
     * */

    /**
     * Like other user profile
     */
    public function likeProfileAction(){

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])) {

            $matri_id = $_SESSION['user_id'];
            $profile_id = $_POST['other_id'];

            if($matri_id != $profile_id){
                //$result = LikeProfile::insertNew($matri_id,$profile_id);
                $user = Auth::getUser();
                $like_array = Helpers::emptyStringIntoArray($user->like_array);
                array_push($like_array,$profile_id);
                $result = $user->likeProfile($like_array,$profile_id);

                if($result){
                    $message = 'Successfully Liked Profile';
                    //array_push($_SESSION['user_likes'],$profile_id);
                }else{
                    $message= 'You have already liked this profile';
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
     * Shortlist Profile
     */
    public function favProfileAction(){

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])) {

            $matri_id = $_SESSION['user_id'];
            $profile_id = $_POST['other_id'];

            if($matri_id != $profile_id){

                $user = Auth::getUser();
                $short_array = Helpers::emptyStringIntoArray($user->short_array);
                array_push($short_array,$profile_id);
                $result = $user->shortProfile($short_array);

                //$result = ShortlistProfile::insertNew($matri_id,$profile_id);

                if($result){
                    //array_push($_SESSION['user_shorts'],$profile_id);
                    $message = 'Successfully Shortlist Profile';
                }else{
                    $message= 'You have already shortlisted this profile';
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
     * Hide OtherUser Profile
     */
    public function hideProfileAction(){

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])){

            $matri_id = $_SESSION['user_id'];
            $profile_id = $_POST['other_id'];

            if($matri_id!=$profile_id){

                $user = Auth::getUser();
                $hide_array = Helpers::emptyStringIntoArray($user->hide_array);
                array_push($hide_array,$profile_id);
                $result = $user->hideProfile($hide_array);

                //$result = HideProfile::insertNew($matri_id,$profile_id);

                if($result){
                    //array_push($_SESSION['user_hides'],$profile_id);
                    $message = 'Hidden Profile Successfully';
                }else{
                    $message = 'You have already hidden this profile';
                }

            }else{
                $message = "It is your profile";
            }
        }else{
            $message =  'Please login to continue';


            //$message='love you kusum '.$profile_id;
        }
        echo $message;
    }

    /**
     * Connect with other User
     */
    public function connectProfileAction(){

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])) {

            $matri_id = $_SESSION['user_id'];
            $profile_id = $_POST['other_id'];

            $interest_send_array = Connection::interestSend();

            if(in_array($profile_id,$interest_send_array)){

                $message='You have already sent connection to this profile';

            }else{

                if($matri_id != $profile_id){
                    $result = ConnectProfile::insertNew($matri_id,$profile_id);
                    $result = true;
                    if($result){
                        $message = 'Connection Successfully Sent/Accepted';
                        array_push($interest_send_array,$profile_id);
                    }else{
                        $message='You have already sent connection to this profile';
                    }
                }else{
                    $message = "It is your profile";
                }
            }

        }else{
            $message = 'Please login to continue';
        }
        echo $message;

    }

    public function remindProfileAction(){

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])) {

            $matri_id = $_SESSION['user_id'];
            $profile_id = $_POST['other_id'];

            if(in_array($profile_id,$_SESSION['reminder_send'])){

                $message='You have already sent reminder to this profile';

            }else{

                if($matri_id != $profile_id){

                    $flag = ConnectProfile::getReminderFlag($matri_id,$profile_id);
                    // if flag is set  reminder has been already send
                    if(!$flag){
                        // Process sending reminder
                        $message = 'Reminder send successfully';
                        array_push($_SESSION['reminder_send'],$profile_id);
                        $url = '/profile/'.Auth::getUser()->pid;
                        Notification::save('interest_reminder',$profile_id);
                    }else{
                        $message='You have already sent reminder to this profile';
                    }
                }else{
                    $message = "It is your profile";
                }
            }

        }else{
            $message = 'Please login to continue';
        }
        echo $message;



    }

    /* ***************************************
     *  Ajax Other Important Function
     * ***************************************
     * */

    /**
     * Record last user activity
     */
    public function lastUserActivityAction(){

        //TODO: time is saved in GMT not IST
        if(isset($_POST['action']) && $_POST['action']==='update_time'){

            $user = Auth::getUser();
            $last_activity = date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
            $result = $user->updatelastUserActivity($last_activity);

            if($result){
                echo "User is currently active";
            }


        }
    }


    public function addRandomShortlistAction(){

        if(isset($_POST['uid']) && isset($_POST['gen'])){

            $userId=$_POST['uid'];
            $userGen=$_POST['gen'];
            $shortedArr = User::getFiveRandomProfiles($userGen);
            $shortedArr = json_encode($shortedArr);

            $user = Auth::getUser();

            $result = $user->updateRandomShortlist($shortedArr);

            if($result){
                echo "Random Shortlist Added";
            }






        }

    }

    /**
     * Record Profile Visitors
     */
    public function recordVisitorAction(){

        if(isset($_POST['uid']) && isset($_POST['pid'])){

            $userId=$_POST['uid'];
            $profileId = $_POST['pid'];

            if($userId!=$profileId){

               $con = VisitProfile::checkRow($userId,$profileId);

                if($con){
                    $flag = VisitProfile::updateRow($userId,$profileId);
                }else{
                    $flag = VisitProfile::insertNew($userId,$profileId);
                }

                if($flag){

                    /*
                     * Notification Postponed
                     * */
                    /*$sql = "INSERT INTO notifications(user_id,sub,pid,msg,icon,color) VALUES(?,?,?,?,?,?)";
                    $stmt=$pdo->prepare($sql);
                    $stmt->execute([$currentUser,'Profile Visitor',$pid,'visited your profile','mdi mdi-swap-horizontal-bold','info']);*/

                    //Notification::addMessage($profileId,'Someone viewed your Profile','Someone has viewed your Profile','mdi mdi-nuke');


                    $msg = "Recorded profile visitor";
                    $data = ['msg'=>$msg,'uid'=>$userId];
                }else{
                    $msg = "Something went wrong!";
                    $data = ['msg'=>$msg,'uid'=>$userId];
                }
                echo json_encode($data);

            }
        }
    }

    /**
     * Loads User Notifications
     */
    public function loadNotificationAction(){

        if(!isset($_SESSION['user_id'])){
            $output='<li class="dropdown-header">Latest notifications</li>';
            $output .= '<li><a href="'.'/login/index'.'"><i class="mdi mdi-account-key"></i>Please Login to see..</a></li>';
            $output .= '<li class="dropdown-footer">
                            <a class="text-center" href="'.'/account/my-notification'.'"> View All </a>
                        </li>';
            echo json_encode($output);
        }else {

            $userId = $_SESSION['user_id'];
            $notifications = Notification::fetchAll($_SESSION['user_id']);
            $num = count($notifications);
            $output = '<li class="dropdown-header">Latest notifications</li>';

            if ($num > 0) {
                foreach ($notifications as $notice) {
                    //$url = isset($notice->pid)?'/profile/'.$notice->pid:$notice->url;

                    $output .= '<li><a href="'.$notice->url.'"><i class="mdi ' . $notice->icon . '"></i>' . $notice->msg . '</a></li>';
                }
            }
            else {
                $output .= '<li><a href="/account/my-notification"><i class="mdi mdi-information-outline"></i>No new notification..</a></li>';

            }
            $output .= '<li class="dropdown-footer">
                            <a class="text-center" href="'.'/account/my-notification'.'"> View All </a>
                        </li>';
            echo json_encode($output);
        }

    }

    /* ***************************************
     *  Ajax Fetch User Function
     * TODO: Checking Required of this section
     * ***************************************
     * */

    public function userMobileAction(){

        if(isset($_POST['id']) && isset($_POST['id'])!='') {

            $user = Auth::getUser();
            if($user->id==$_POST['id']){
                $result = ['mobile'=>$user->mobile];
                echo json_encode($result);
            }
        }
    }

    public function updateMobileAction(){

        if(isset($_POST['mobile'])){

            $mobile = $_POST['mobile'];
            $user = Auth::getUser();

            $check = $user->mobileExists($mobile, $user->id);

            if(!$check){
                $result = User::updateMobile($user->id,$mobile);
                if($result){
                    $msg = "Mobile updated successfully";
                    $res = ['mobile'=>$mobile,'msg'=>$msg];
                    echo json_encode($res);
                }
            }else{
                $msg = "This mobile number already exist in our database. please give some other number";
                $res = ['mobile'=>$user->mobile,'msg'=>$msg];
                echo json_encode($res);

            }


        }
    }




    protected function validateMobile($mobile){

        // mobile address
        if (!preg_match("/^[6-9]\d{9}$/",$mobile)) {
            $this->errors[] = 'Invalid mobile number';

        }

        if(Auth::getUser()->mobileExists($mobile)){
            $this->errors[] = 'Email already exists';
        }
    }

    public function changeMobileAction(){

        if(isset($_POST['mb']) && $_POST['mb']!=''){
            $huid = $_POST['hidden_user_id'];
            $mb = $_POST['mb'];

            self::validateMobile($mb);
            if(empty($this->errors)){
                $result = User::updateMobile($huid,$mb);
                if($result){
                    $msg = "User updated successfully";
                    $flag = true;
                    $res = ['mb'=>$mb,'msg'=>$msg,'flag'=>$flag];
                    echo json_encode($res);
                }else{
                    $msg = "Database Server Busy";
                    $flag = false;
                    $res = ['mb'=>$mb,'msg'=>$msg,'flag'=>$flag];
                    echo json_encode($res);
                }

            }else{
                $msg = $this->errors[0];
                $flag = false;
                $res = ['mb'=>$mb,'msg'=>$msg,'flag'=>$flag];
                echo json_encode($res);
            }
        }


    }



    /* ***************************************
     *  Ajax Fetch User Function
     * TODO: Checking Required of this section
     * ***************************************
     * */

    public function profileDescriptionAction(){

        if(isset($_POST['other_id'])){

            $other_id = $_POST['other_id'];

            $flag=''; $like=''; $fav=''; $hide='';

            if(isset($_SESSION['user_id'])){

                $auth_user = Auth::getUser();
                $likesArr = $auth_user->likesArr();
                $shortsArr = $auth_user->shortsArr();
                $hidesArr = $auth_user->hidesArr();

                /*$flag = ConnectProfile::getUserConnectionFlag($_SESSION['user_id'],$other_id);
                $like = LikeProfile::getUserLikeStatus($_SESSION['user_id'],$other_id);
                $fav = ShortlistProfile::getUserFavStatus($_SESSION['user_id'],$other_id);
                $hide = HideProfile::getUserHideStatus($_SESSION['user_id'],$other_id);*/

                $flag = ConnectProfile::getUserConnectionFlag($_SESSION['user_id'],$other_id);
                $like = in_array($other_id,$likesArr);
                $fav = in_array($other_id,$shortsArr);
                $hide = in_array($other_id,$hidesArr);

            }

            $basicInfo = User::getProfileBasicInfo($other_id);
            $count = count($basicInfo);

            $basicInfo=(array)$basicInfo;
            $basicInfo['flag']=$flag;
            $basicInfo['like']=$like;
            $basicInfo['fav']=$fav;
            $basicInfo['hide']=$hide;
            $basicInfo['iso']= \Carbon\Carbon::parse($basicInfo['dob'])->isoFormat('MMMM Do YYYY');
            $basicInfo['age']= "(".\Carbon\Carbon::parse($basicInfo['dob'])->age.' '.'yrs'.")";

            $basicInfo = (object)$basicInfo;


            if($count>0){
                $response = $basicInfo;
            }else{
                $response['status']=200;
                $response['message']="No data found!";
            }
            echo json_encode($response);
        }
    }



    /* ***************************************
     *  Ajax Profile Update Functions
     * ***************************************
     * */


    /**
     *
     */
    public function updateBasicInfoAction(){

        if(isset($_POST['bis'])){

            $user = Auth::getUser();
            $result = $user->updateBasicInfo($_POST);

            $msg = (!$result)?'Server busy! Please try after sometime':'Basic information updated successfully';
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }


    }

    /**
     *
     */
    public function updateCasteInfoAction(){

        if(isset($_POST['cas'])){

            if(empty($_POST['mycastes'])){
                $msg = "Castes field is empty";
            }else{
                $user = Auth::getUser();
                $result = $user->updateCasteInfo($_POST);
                $msg = (!$result)?'Server busy! Please try after sometime':'Preferred Castes updated successfully';
            }
            $re = ['msg'=>$msg];
            echo json_encode($re);

        }
    }

    /**
     *
     */
    public function updateEduCareerInfoAction(){

        if(isset($_POST['ecs'])){

            $user = Auth::getUser();
            $result = $user->updateEduCareerInfo($_POST);

            if(!$result){
                $msg = 'Server busy! Please try after sometime';
            }else{
                $msg = 'Education & Career updated successfully';
            }
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }
    }

    /**
     *
     */
    public function updateFamilyInfoAction(){


        if(isset($_POST['fis'])){

            $user = Auth::getUser();
            $result = $user->updateFamilyInfo($_POST);

            if(!$result){
                $msg = 'Server busy! Please try after sometime';
            }else{
                $msg = 'Family Details updated successfully';
            }
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }
    }

    /**
     *
     */
    public function lifestyleInfoAction(){

        if(isset($_POST['lis'])){

            $user = Auth::getUser();
            $result = $user->updateLifestyleInfo($_POST);

            $msg = (!$result)?'Server busy! Please try after sometime':'Lifestyle Info updated successfully';
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }
    }

    /**
     *
     */
    public function likesInfoAction(){

        if(isset($_POST['lik'])){

            if(empty($_POST['myhobbies']) || empty($_POST['myinterests'])){
                $msg = "Select your hobbies and Interests both";
            }else{
                $user = Auth::getUser();
                $result = $user->updateLikesInfo($_POST);
                $msg = (!$result)?'Server busy! Please try after sometime':'Likes & Hobbies updated successfully';
            }

            $re = ['msg'=>$msg];
            echo json_encode($re);
        }
    }

    /**
     *
     */
    public function horoscopeInfoAction(){

        if(isset($_POST['his'])){

            $user = Auth::getUser();
            $result = $user->updateAstroDetails($_POST);

            $msg = (!$result)?'Server busy! Please try after sometime':'Astrological details updated successfully';
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }

    }

    /**
     *
     */
    public function brosMarried(){

        if(isset($_POST['bros_id'])){

            $bros_id = $_POST['bros_id'];
            $num = $bros_id;
            // Generate HTML of city options list
            if($num > 0){
                echo '<option value="">Brothers Married</option>';
                for ($x = 1; $x <= $num; $x++) {
                    echo '<option value="'.$x.'">'.$x.'</option>';
                }
            }else{
                echo '<option value="">Select Brothers</option>';
            }
        }
    }

    /**
     *
     */
    public function sisMarried(){

        if(isset($_POST['sis_id'])){

            $sis_id = $_POST['sis_id'];
            $num = $sis_id;
            // Generate HTML of city options list
            if($num > 0){
                echo '<option value="">Sisters Married</option>';
                for ($x = 1; $x <= $num; $x++) {
                    echo '<option value="'.$x.'">'.$x.'</option>';
                }

            }else{
                echo '<option value="">Select Sisters</option>';
            }
        }
    }

    /* ***************************************
     *  Ajax Manage Photo Functions
     * ***************************************
     * */

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





}