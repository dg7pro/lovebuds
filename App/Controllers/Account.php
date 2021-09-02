<?php


namespace App\Controllers;


use App\Auth;
use App\Csrf;
use App\Flash;
use App\Models\Aadhar;
use App\Models\Contact;
use App\Models\Image;
use App\Models\Notification;
use App\Models\UserVariables;
use Core\View;


/**
 * Class Account
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
     * Show self dashboard
     * to the user
     */
    public function dashboardAction()
    {
        if(!Auth::getUser()->is_active){
            $this->redirect('/account/create-profile');
        }
        // Unset done to remove errors
        //unset($_SESSION['chain']);

        // Fetch user and shorted profiles ids
        $user = Auth::getUser();

        // Fetch Images
        $image = Image::getUserImages($_SESSION['user_id']);

        $notice = new Notification();
        $notifications = $notice->fetchAll($user);
        $pf = '<em>Please fill</em>';

        $num = 0;
        if($user->fb_add){
            $contact = new Contact();
            $num = $contact->numbersGivenByUser($user);
        }

        // Render view
        View::renderBlade('account.dashboard',[
            'allCastes'=>UserVariables::fetch('castes'),
            'heights'=>UserVariables::fetch('heights'),
            'age_rows'=>UserVariables::getAgeRows(),
            'image'=>$image,
            'authUser'=>$user,
            'notifications'=>$notifications,
            'pf'=>$pf,
            'num'=>$num,
            'i'=>1
        ]);

    }

    /**
     * Edit User Profile
     */
    public function editProfileAction(){

        $user = Auth::getUser();
        View::renderBlade('account.edit-profile', [
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
            'castes'=>UserVariables::getCastesInOrder($user->religion_id),
            'allCastes'=>UserVariables::getCastes($user->religion_id),
            'mangliks'=>UserVariables::fetch('mangliks'),
            'signs'=>UserVariables::fetch('signs'),
            'nakshatras'=>UserVariables::fetch('nakshatras'),
            'tongues'=>UserVariables::getTongues(),
            'countries'=>UserVariables::getCountries(),
            'userDistricts'=>UserVariables::fetch('districts'),

        ]);
    }

    /**
     * Show self-manage album-page
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
     * Show self create-profile
     * page to the new user
     */
    public function createProfileAction(){

        if (Auth::getUser()->is_active) {

            $this->redirect('/account/dashboard');
        }

        $arr = isset($_GET['arr'])?json_decode($_GET['arr'],true):'';
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
        $incomes = UserVariables::incomes();
        $communities = UserVariables::communities();
        $countries = UserVariables::getCountries();
        $districts = UserVariables::districts();
        //$castes = UserVariables::getCastes(1);
        $states = UserVariables::states();

        View::renderBlade('account/createProfile', [
            'arr'=>$arr,
            'dates' => $date_rows,
            'months' => $months,
            'years' => $years,
            'religions' => $religions,
            'maritals' => $maritals,
            'heights' => $heights,
            'mangliks' => $mangliks,
            'languages' => $languages,
            'educations' => $educations,
            'occupations' => $occupations,
            'incomes'=> $incomes,
            'communities'=>$communities,
            'countries'=>$countries,
            'districts'=>$districts,
            'states'=>$states

        ]);

    }

    /**
     * Save create-profile info
     * to database
     */
    public function saveProfileAction(){

        $csrf = new Csrf($_POST['token']);
        if(!$csrf->validate()){
            unset($_SESSION["csrf_token"]);
            die("CSRF token validation failed");
        }

        if (isset($_POST['create-profile-submit'])) {

            $user = Auth::getUser();
            $result = $user->saveUserProfile($_POST);

            if($result){
                Flash::addMessage('Profile created successfully', Flash::SUCCESS);

                // Notify user
                $notification = new Notification();
                $notification->informAboutSuccessfulProfileCreation($user);

                $this->redirect('/account/dashboard');
            }else{
                $arr = json_encode($_POST);

                foreach ($user->errors as $error) {
                    Flash::addMessage($error, 'danger');
                }
                $this->redirect('/account/create-profile?arr='.$arr);
            }
        }

    }

    public function savePersonAction(){

//        var_dump($_POST);
//        echo "<br><br>";
        /*foreach($_POST['contact'] as $c){

            echo $c['name'].' '.$c['mobile'];

        }*/
        $pairs = $_POST['contact'];
        $con= new Contact();
        if($con->save(Auth::getUser(),$pairs)){

            Flash::addMessage('Thanks! Contacts has been saved','success');
            foreach($con->errors as $error){
                Flash::addMessage($error,'danger');
            }
            $this->redirect('/account/dashboard');
        }else{
            foreach($con->errors as $error){
                Flash::addMessage($error,'danger');
            }
            $this->redirect('/account/dashboard');

        }
    }

    public function aadharVerificationAction(){

        View::renderBlade('account/aadhar-verification');
    }

    public function saveAadharAction(){

        var_dump($_POST['aadhar']);

        if(isset($_POST['aadhar']) && $_POST['aadhar']!=''){

            $user=Auth::getUser();

            if($user->saveAadhar($_POST)){

                Flash::addMessage('Aadhar saved successfully. Please upload front and back image of aadhar as shown below','success');
                $this->redirect('/account/upload-aadhar');
            }else{
                foreach ($user->errors as $error) {
                    Flash::addMessage($error, 'danger');
                }
                $this->redirect('/account/aadhar-verification');
            }

        }

    }

    public function uploadAadharAction(){

        $front = Aadhar::fetchUserAadharFront($_SESSION['user_id']);

        $back = Aadhar::fetchUserAadharBack($_SESSION['user_id']);

        if(count($front) && count($back)){
            $msg = "Pending verification by moderator. Will be checked and updated very soon";
        }else{
            $msg = "Please upload your aadhar front and back image both. Verified account get better response";
        }
        //Flash::addMessage('It just takes less than 2 minutes to upload your aadhar', 'danger');

        Flash::addMessage($msg, 'info');
        View::renderBlade('account/my-aadhar',['front'=>$front, 'back'=>$back]);

    }

}