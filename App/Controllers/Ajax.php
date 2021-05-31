<?php


namespace App\Controllers;


use App\Auth;
use App\Lib\Helpers;
use App\Models\AddressRequest;
use App\Models\ConnectProfile;
use App\Models\District;
use App\Models\Image;
use App\Models\MoveProfile;
use App\Models\Notification;
use App\Models\Notify;
use App\Models\PhotoRequest;
use App\Models\RecordContact;
use App\Models\User;
use App\Models\UserVariables;
use App\Models\VisitProfile;
use Core\Controller;


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

    /**
     * Resend Activation Email
     */
    public function resendActivationEmail(){

        if(isset($_POST['em']) && $_POST['em']!=''){

            if (filter_var($_POST['em'], FILTER_VALIDATE_EMAIL) === false) {
                echo '<span class="text-danger">Invalid email, please enter proper email</span>';
            }else{
                $user = User::findByEmail($_POST['em']);
                if($user){
                    if($user->is_active){
                        echo '<span class="text-success">Your account is already active</span>';
                    }else{
                        $flag = $user->processNewActivationCode();
                        if($flag){
                            $user->sendActivationEmail();
                        }
                        echo '<span class="text-success">Activation link send, please check your email</span>';
                    }

                }else{
                    echo '<span class="text-danger">No User found with this email</span>';
                }
            }

        }else{
            echo '<span class="text-danger">Wrong Input</span>';;
        }

    }

    /**
     *  Select district for any state
     */
    public function selectDistrict(){

        if(isset($_POST['state_id'])){

            $sid = $_POST['state_id'];
            //echo $sid;

            $districts = District::fetchAll($sid);
            $num = count($districts);

            // Generate HTML of city options list
            if($num > 0){
                echo '<option value="">Select city</option>';
                foreach ($districts as $district){
                    echo '<option value="'.$district['id'].'">'.$district['text'].'</option>';
                }
            }else{
                echo '<option value="">District not available</option>';
            }

        }
    }

    /**
     *  Select Gender for popup registration
     */
    public function selectGenderPopup(){

        $male = [2,4];
        $female = [3,5];
        $ambiguous = [1,6,7];
        $htm='';

        if(isset($_POST['for_id'])){

            $for_id = $_POST['for_id'];
            if(in_array($for_id,$male)){
                //$gender = 'male';
                //$val = 1;
                $htm = '<option value=1>Male</option>';
            }elseif (in_array($for_id,$female)){
                $htm = '<option value=2>Female</option>';
            }else{
                $htm = '<option value="">Gender</option>
                        <option value=1>Male</option>
                        <option value=2>Female</option>';
            }
        }
        echo $htm;

    }


    /* ***************************************
     *  Ajax User Activity Functions
     * ***************************************
     * */

    /**
     * Mark notifications read
     */
    public function marNotification(){

        if(isset($_POST['aid'])){
            $result = Notify::markAsRead($_POST['aid']);
            if($result){
               echo 'Marked as read, will be automatically deleted in 30days ';
            }else{
               echo 'Some thing went wrong';
            }
        }

    }

    /**
     *  Fetch all unread notifications
     */
    public function unreadNotifications(){

        if(isset($_POST['readrecord'])){

            $data = '';
            $results = Notify::fetchAll($_SESSION['user_id']);
            $num = count($results);

            if($num>0){
                foreach($results as $notify) {
                    $data .= '<div data-id="'.$notify->id.'" class="alert alert-info alert-dismissible fade show" role="alert">
                        '. $notify->message .'
                        <button type="button" class="close" data-dismiss="alert" onclick="marNotification('.$notify->id.')" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';

                }
            }else{
                $data .= '<div class="alert alert-light" role="alert">
                              -- No new notification found --
                            </div>';
                //$data .= '<a class="btn btn-pink" href="/account/thrash" role="button">Trash Box</a>';
            }
            echo $data;
        }
    }


    /**
     *  Show & record viewed Contact
     */
    public function showContact(){

        if(isset($_SESSION['user_id']) && isset($_POST['other_id'])){

            $uid = $_SESSION['user_id'];
            $oid = $_POST['other_id'];
            $flag = '';

            if($uid != $oid){
                $rc = new RecordContact();
                if($rc->create($uid,$oid)){
                    $user = Auth::getUser();
                    $flag = $user->incrementAc();
                    $msg = ($flag)?'Success success':'Not Increment';
                }else{
                    $msg = 'Already in record';
                }
            }
        }else{
            $msg = 'Please Login';
        }
        echo $msg;

    }


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
     *  Move profile to shortlist or downlist
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


    /* ***************************************
     *  Ajax Profile Update Functions
     * ***************************************
     * */

    /**
     *  Update basic info edit profile
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
     * Update caste info edit profile
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
     * Update education and career info edit profile
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
     * Update Family details edit profile
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
     *  Update lifestyle info edit profile
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
     *  Update likes & interests edit profile
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
     * update Astro-details edit profile
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
     * Limit the no. of married brothers
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
     * Limit the no. of married sisters
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

    /**
     * Update Partner Preferences dashboard
     */
    public function updatePartnerPreferenceAction(){

        if(isset($_POST['pp'])){

            $user = Auth::getUser();
            $result = $user->updatePartnerPreference($_POST);
            $msg = (!$result)?'Server busy! Please try after sometime':'Partner Preference updated successfully';
            $msg = json_encode($msg);

            $re = ['msg'=>$msg];
            echo json_encode($re);

        }

    }

    /**
     *  Limit selection of max age dashboard
     */
    public function minmaxAge(){

        if(isset($_POST['min_age_val'])){

            $min_age = $_POST['min_age_val'];
            $num = $min_age;
            // Generate HTML of city options list
            if($num >= 18){
                echo '<option value="">max-age</option>';
                for ($x = $num; $x <= 72; $x++) {
                    echo '<option value="'.$x.'">'.$x.'</option>';
                }
            }else{
                echo '<option value="">min-age first</option>';
            }
        }
    }

    /**
     *  Limit selection of max height dashboard
     */
    public function minmaxHt(){

        if(isset($_POST['min_ht_val'])){

            $heights = UserVariables::fetch('heights');
            $htArray = json_decode(json_encode($heights), true);
            $c = count($htArray);
            $mc = $c-1; // max count (mc) in array since index start from 0;

            $min_ht = $_POST['min_ht_val'];
            $num = $min_ht;
            // Generate HTML of city options list
            if($num >= $htArray[0]['id']){
                echo '<option value="">max-ht</option>';
                for ($x = $num; $x < $htArray[$mc]['id']; $x++) {
                    echo '<option value="'.$x.'">'.$htArray[$x]['feet'].'</option>';
                }
            }else{
                echo '<option value="">min-ht first</option>';
            }
        }
    }


    /* ***************************************
     *  Ajax Manage Photo Functions
     * ***************************************
     * */

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



    /* *************************************************************************************************************
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









}