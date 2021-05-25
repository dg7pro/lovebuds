<?php


namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Notify;
use App\Models\UserVariables;
use Core\View;


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
     * Show self dashboard
     * to the user
     */
    public function dashboardAction()
    {
        if(Auth::getUser()->name==''){
            $this->redirect('/account/create-profile');
        }
        // Unset done to remove errors
        unset($_SESSION['chain']);

        // Fetch user and shorted profiles ids
        $user = Auth::getUser();

        // Fetch Images
        $image = Image::getUserImages($_SESSION['user_id']);

        $notifications = Notify::fetchAll($_SESSION['user_id']);

        // Render view
        View::renderBlade('account.dashboard',[
            'allCastes'=>UserVariables::fetch('castes'),
            'heights'=>UserVariables::fetch('heights'),
            'age_rows'=>UserVariables::getAgeRows(),
            'image'=>$image,
            'authUser'=>$user,
            'notifications'=>$notifications
        ]);

    }

    public function testAction(){
        // Render view
        View::renderBlade('account.test');

    }

    public function formResultAction(){

        var_dump($_POST);
    }

    public function editProfileAction(){

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
            'allCastes'=>UserVariables::fetch('castes'),
            'mangliks'=>UserVariables::fetch('mangliks'),
            'signs'=>UserVariables::fetch('signs'),
            'nakshatras'=>UserVariables::fetch('nakshatras'),
            'tongues'=>UserVariables::getTongues(),
            'countries'=>UserVariables::getCountries(),
            'userDistricts'=>UserVariables::fetch('districts'),


        ]);
    }


    public function partnerPreferenceAction(){

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

        // Render view
        View::renderBlade('account.partner-preference',[
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

            View::renderBlade('account/createProfile', [
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
            $this->redirect('/account/dashboard');
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
                //Notification::save('profile_created',$user->id);
                $this->redirect('/account/dashboard');
            }
        }
    }

}