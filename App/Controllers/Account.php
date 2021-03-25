<?php


namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Lib\Helpers;
use App\Models\Image;
use App\Models\Kyc;
use App\Models\Notification;
use App\Models\UserConnections;
use App\Models\UserVariables;
use App\Textlocal;
use Core\View;
use App\Models\User;
use Exception;

/**
 * Account Controller
 *
 * @package App\Controllers
 */
class Account extends Authenticated
{

    /**
     * Logout user
     * and redirect to home page
     */
    public function logoutAction()
    {

        Auth::logout();
        $this->redirect('/');
    }

    /**
     * Show all Statistics
     * of user activity
     */
    public function statsAction()
    {

        // Fetch user and shorted profiles ids
        $user = Auth::getUser();
        $short_array = $user->shortsArr();
        $hide_array = $user->hidesArr();

        // Interest send and received array of ids
        $interest_send_array = Connection::interestSend();
        $interest_received_array = Connection::interestReceived();

        // Combine arrays into one
        $combinedArray = array_merge($short_array,$hide_array,$interest_send_array,$interest_received_array);

        // Remove duplicates from array if any
        $combinedArray = array_unique($combinedArray);

        // fetch combined user details
        $results = UserConnections::getUserCombinedDetails($combinedArray);

        // getting separate arrays
        $connectedPre = array_intersect($interest_send_array,$interest_received_array);
        $send = array_diff($interest_send_array,$connectedPre);
        $received = array_diff($interest_received_array,$connectedPre);
        $connected = array_diff($connectedPre,$hide_array);

        // get values array
        $connected = Helpers::getValueIndexedArray($connected);
        $send = Helpers::getValueIndexedArray($send);
        $received = Helpers::getValueIndexedArray($received);
        $shorted = Helpers::getValueIndexedArray($short_array);
        $hided = Helpers::getValueIndexedArray($hide_array);

        // get list in same order as received form database
        // so as to maintain created at sequence
        $profiles = self::getorderedList(array_intersect_key($results,$send),$send);
        $profiles2 = self::getOrderedList(array_intersect_key($results,$received),$received);
        $profiles3 = self::getOrderedList(array_intersect_key($results,$connected),$connected);
        $profiles4 = self::getOrderedList(array_intersect_key($results,$shorted),$shorted);
        $profiles5 = self::getOrderedList(array_intersect_key($results,$hided),$hided);

        View::renderBlade('account.stats',[
            'profiles'=>$profiles,
            'profiles2'=>$profiles2,
            'profiles3'=>$profiles3,
            'profiles4'=>$profiles4,
            'profiles5'=>$profiles5
        ]);
    }

    /**
     * Set order of the main array elements as list array
     * @param $main
     * @param $list
     * @return array
     */
    public static function getOrderedList($main, $list){
        $newArray=array();
        foreach($list as $k=>$v){
            $newArray[$k]=$main[$k];
        }
        $newArray = array_slice($newArray,0,3);
        return $newArray;
    }

    /**
     * Show self dashboard
     * to the user
     */
    public function welcomeAction()
    {
        if(Auth::getUser()->name==''){
            $this->redirect('/account/create-profile');
        }
        // Unset done to remove errors
        unset($_SESSION['chain']);

        // Fetch user and shorted profiles ids
        $user = Auth::getUser();
        $short_array = $user->shortsArr();

        // Interest send and received array of ids
        $interest_send_array = Connection::interestSend();
        $interest_received_array = Connection::interestReceived();

        // Fetch Images
        $image = Image::getUserImages($_SESSION['user_id']);

        // Combine arrays into one
        $combinedArray = array_merge($interest_send_array,$interest_received_array,$short_array,
            $_SESSION['recommended_profiles'],$_SESSION['new_profiles'],$_SESSION['visitor_profiles']);

        // Remove duplicates from array if any
        $combinedArray = array_unique($combinedArray);

        // fetch combined user details
        $results = UserConnections::getUserCombinedDetails($combinedArray);

        // Get final send received and connected arrays
        $connected = array_intersect($interest_send_array,$interest_received_array);
        $send = array_diff($interest_send_array,$connected);
        $received = array_diff($interest_received_array,$connected);

        // Get value indexed array
        $connected = Helpers::getValueIndexedArray($connected);
        $send = Helpers::getValueIndexedArray($send);
        $received = Helpers::getValueIndexedArray($received);
        $shorted = Helpers::getValueIndexedArray($short_array);
        $recommended = Helpers::getValueIndexedArray($_SESSION['recommended_profiles']);
        $new = Helpers::getValueIndexedArray($_SESSION['new_profiles']);
        $visitors = Helpers::getValueIndexedArray($_SESSION['visitor_profiles']);

        // Get in required chronological order
        $isToProfiles = self::getOrderedList(array_intersect_key($results,$send),$send);
        $irFromProfiles = self::getOrderedList(array_intersect_key($results,$received),$received);
        $cProfiles = self::getOrderedList(array_intersect_key($results,$connected),$connected);
        $sProfiles = self::getOrderedList(array_intersect_key($results,$shorted),$shorted);
        $rProfiles = self::getOrderedList(array_intersect_key($results,$recommended),$recommended);
        $nProfiles = self::getOrderedList(array_intersect_key($results,$new),$new);
        $vProfiles = self::getOrderedList(array_intersect_key($results,$visitors),$visitors);

        // Render view
        View::renderBlade('account.welcome',[
            'image'=>$image,
            'isToProfiles'=>$isToProfiles,
            'irFromProfiles'=>$irFromProfiles,
            'cProfiles'=>$cProfiles,
            'sProfiles'=>$sProfiles,
            'rProfiles'=>$rProfiles,
            'nProfiles'=>$nProfiles,
            'vProfiles'=>$vProfiles,
            'authUser'=>$user
        ]);

    }

    /**
     * Show self profile to
     * the user for updating
     */
    public function myProfileAction(){

        $profile = User::findByID($_SESSION['user_id']);

        View::renderBlade('account/my-profile',[
            'profile'=>$profile,
            'maritals'=>UserVariables::fetch('maritals'),
            'religions'=>UserVariables::fetch('religions'),
            'languages'=>UserVariables::fetch('languages'),
            'heights'=>UserVariables::fetch('heights'),
            'educations'=>UserVariables::getEducations(),
            'degrees'=>UserVariables::fetch('degrees'),
            'sectors'=>UserVariables::fetch('sectors'),
            'occupations'=>UserVariables::getOccupations(),
            'universities'=>UserVariables::fetch('universities'),
            'incomes'=>UserVariables::fetch('incomes'),
            'fathers'=>UserVariables::fetch('fathers'),
            'mothers'=>UserVariables::fetch('mothers'),
            'famAffluence'=>UserVariables::fetch('fam_affluence'),
            'famValues'=>UserVariables::fetch('fam_values'),
            'famTypes'=>UserVariables::fetch('fam_types'),
            'famIncomes'=>UserVariables::fetch('fam_incomes'),
            'diets'=>UserVariables::fetch('diets'),
            'smokes'=>UserVariables::fetch('smokes'),
            'drinks'=>UserVariables::fetch('drinks'),
            'bodies'=>UserVariables::fetch('bodies'),
            'complexions'=>UserVariables::fetch('complexions'),
            'wts'=>UserVariables::getWts(),
            'challenges'=>UserVariables::fetch('challenged'),
            'bGroups'=>UserVariables::fetch('blood_groups'),
            'thalassemia'=>UserVariables::fetch('thalassemia'),
            'citizenship'=>UserVariables::fetch('citizenship'),
            'hobbies'=>UserVariables::fetch('hobbies'),
            'interests'=>UserVariables::fetch('interests'),
            'states'=>UserVariables::fetch('states'),
            'allCastes'=>UserVariables::fetch('castes'),
            'mangliks'=>UserVariables::fetch('mangliks'),
            'signs'=>UserVariables::fetch('signs'),
            'nakshatras'=>UserVariables::fetch('nakshatras'),
            'tongues'=>UserVariables::getTongues(),
            'countries'=>UserVariables::getCountries(),
            'userDistricts'=>UserVariables::fetch('districts'),
        ]);
    }

    /**
     * Show self manage album-page
     * to the user
     */
    public function myAlbumAction(){

        $images = Image::getUserUploadedImages($_SESSION['user_id']);
        $num = count($images);
        View::renderBlade('account/my-album',['images'=>$images,'num'=>$num]);
    }

    /**
     * Show self photo management-page
     * to the user
     */
    public function managePhotoAction(){

        $images = Image::getUserUploadedImages($_SESSION['user_id']);
        View::renderBlade('account.manage-photo',['images'=>$images]);
    }

    /**
     * Show self account info-page
     * to the user
     */
    public function infoAction(){

        View::renderBlade('account/info');

    }

    /**
     * Show self all notifications
     * page to the user
     */
    public function myNotificationAction(){

        $notifications = Notification::fetchAll(Auth::getUser()->id);
        View::renderBlade('account.my-notification',['notifications'=>$notifications]);
    }

    /**
     * Show self kyc-page
     * to the user
     */
    public function myKycAction(){

        $kycs = Kyc::getUserKyc($_SESSION['user_id']);
        $num = count($kycs);
        View::renderBlade('account/my-kyc',['kycs'=>$kycs,'num'=>$num]);
    }

    /**
     * Show self create-profile
     * page to the new user
     */
    public function createProfileAction(){

        if(Auth::getUser()->name=='') {

            $date_rows = UserVariables::dates();
            $months = UserVariables::months();
            $years = UserVariables::years();
            $religions = UserVariables::religions();
            $maritals = UserVariables::maritals();
            $heights = UserVariables::heights();
            $mangliks = UserVariables::mangliks();
            $languages = UserVariables::languages();
            $educations = UserVariables::getEducations();
            $occupations = UserVariables::getOccupations();

            View::renderBlade('account/create-profile', [
                'dates' => $date_rows,
                'months' => $months,
                'years' => $years,
                'religions' => $religions,
                'maritals' => $maritals,
                'heights' => $heights,
                'mangliks' => $mangliks,
                'languages' => $languages,
                'educations' => $educations,
                'occupations' => $occupations

            ]);

        }else{
            $this->redirect('/account/welcome');
        }
    }

    /**
     * Save create-profile info
     * to database
     */
    public function saveProfileAction(){

        if(isset($_POST['create-profile-submit'])){

            $user = Auth::getUser();
            $result = $user->saveUserProfile($_POST);

            if($result){
                Flash::addMessage('Profile created successfully', Flash::SUCCESS);
                Notification::save('profile_created',$user->id);
                $this->redirect('/account/welcome');
            }
        }
    }

    /**
     * Show send otp page to user
     */
    public function sendOtpPageAction(){

        View::renderBlade('account/send-otp-page');

    }

    /**
     * Process Sending OTP to user mobile
     * @return bool
     */
    public function sendOtpAction(){

        $textlocal = new Textlocal('getkabirjaiswal@gmail.com', 'b1ee526126799c16b135126330b84f169dbba0f6479b5e27a52b3b353f5bd863');

        $otp = mt_rand(10000,99999);
        $message = "Your one time password is: ".$otp;
        $user = Auth::getUser();
        $user->updateOtp($otp);

        $numbers = array('91'.$user->mobile);
        $sender = 'TXTLCL';

        try {
            //$result = $textlocal->sendSms($numbers, $message, $sender);
            //print_r($result);
            //return true;
            View::renderBlade('account.mobile-verification');


        } catch (Exception $e) {
            return false;
            //die('Error: ' . $e->getMessage());
        }

        //TODO: change textlocal account for production
        //TODO: handle error message properly

    }

    /**
     * Process OTP verification by matching the
     * OTP entered and OTP saved in database
     */
    public function verifyOtpAction(){

        if(!isset($_POST['otp']) || $_POST['otp']==''){

            Flash::addMessage('OTP not entered');
            $this->redirect('/account/failure');
        }

        $user=Auth::getUser();

        if($_POST['otp']!==$user->otp){

            Flash::addMessage('OTP mismatched. Please enter the correct otp');
            $this->redirect('/account/failure');
        }
        else{

            Flash::addMessage('Mobile verified Successfully');
            $user->verifyMobile();
            $this->redirect('/account/success');
        }
    }

    /**
     * Show OTP failed verification page
     */
    public function failureAction(){
        View::renderBlade('account.mobile-verification');
    }

    /**
     *  Show OTP success verification page
     */
    public function successAction(){
        View::renderBlade('account.success');
    }

    // ********************************************************************************************************

    public function interestReceivedAction(){

        // Interest send and received array of ids
        $interest_send_array = Connection::interestSend();
        $interest_received_array = Connection::interestReceived();

        //TODO: Throws error when array is empty in this and all next functions;

        // Combine arrays into one
        $combinedArray = array_merge($interest_received_array);

        // Remove duplicates from array if any
        $combinedArray = array_unique($combinedArray);

        if(!empty($combinedArray)){

            // fetch combined user details
            $results = UserConnections::getUserCombinedDetails($combinedArray);

            // getting separate arrays
            $connected = array_intersect($interest_send_array,$interest_received_array);
            $received = array_diff($interest_received_array,$connected);

            // get values array
            $received = Helpers::getValueIndexedArray($received);

            // get list in same order as received form database
            // so as to maintain created at sequence
            $profiles2 = self::getOrderedList(array_intersect_key($results,$received),$received);

            View::renderBlade('account.interest-received',['profiles2'=>$profiles2]);
        }

        $profiles2 = [];
        View::renderBlade('account.interest-received', ['profiles2'=>$profiles2]);

    }

    public function interestSendAction(){


        // Interest send and received array of ids
        $interest_send_array = Connection::interestSend();
        $interest_received_array = Connection::interestReceived();

        // Combine arrays into one
        $combinedArray = array_merge($interest_send_array);

        // Remove duplicates from array if any
        $combinedArray = array_unique($combinedArray);

        // fetch combined user details
        $results = UserConnections::getUserCombinedDetails($combinedArray);

        // getting separate arrays
        $connected = array_intersect($interest_send_array,$interest_received_array);
        $send = array_diff($interest_send_array,$connected);


        // get values array

        $send = Helpers::getValueIndexedArray($send);

        // get list in same order as received form database
        // so as to maintain created at sequence
        $profiles = self::getorderedList(array_intersect_key($results,$send),$send);

        View::renderBlade('account.interest-send',['profiles'=>$profiles]);
    }

    public function connectedProfilesAction(){

        $user = Auth::getUser();
        $hide_array = $user->hidesArr();

        $interest_send_array = Connection::interestSend();
        $interest_received_array = Connection::interestReceived();


        $combinedArray = array_merge($interest_send_array,$interest_received_array);    // Combine arrays into one
        $combinedArray = array_unique($combinedArray);                                  // Remove duplicates from array if any
        $results = UserConnections::getUserCombinedDetails($combinedArray);             // fetch combined user details


        $connected = array_intersect($interest_send_array,$interest_received_array);    // getting separate arrays
        $connected = array_diff($connected,$hide_array);


        $connected = Helpers::getValueIndexedArray($connected);                         // get values array
        $profiles3 = self::getOrderedList(array_intersect_key($results,$connected),$connected);


        View::renderBlade('account.connected-profiles',['profiles3'=>$profiles3]);

    }

    public function shortlistedProfilesAction(){

        $user = Auth::getUser();                                    // Fetch user and shorted profiles ids
        $short_array = $user->shortsArr();

        $combinedArray = array_merge($short_array);                 // Combine arrays into one
        $combinedArray = array_unique($combinedArray);              // Remove duplicates from array if any

        $results = UserConnections::getUserCombinedDetails($combinedArray);     // fetch combined user details

        $shorted = Helpers::getValueIndexedArray($short_array);              // get values array

        $profiles4 = self::getOrderedList(array_intersect_key($results,$shorted),$shorted);   // get list in same order

        View::renderBlade('account.shortlisted-profiles',['profiles4'=>$profiles4]);

    }



    public function hidedProfilesAction(){

        $user = Auth::getUser();                                    // Fetch user and shorted profiles ids
        $hide_array = $user->hidesArr();

        $combinedArray = array_merge($hide_array);                 // Combine arrays into one
        $combinedArray = array_unique($combinedArray);              // Remove duplicates from array if any

        $results = UserConnections::getUserCombinedDetails($combinedArray);     // fetch combined user details

        $hided = Helpers::getValueIndexedArray($hide_array);              // get values array

        $profiles5 = self::getOrderedList(array_intersect_key($results,$hided),$hided);   // get list in same order

        View::renderBlade('account.hided-profiles',['profiles5'=>$profiles5]);

    }

}