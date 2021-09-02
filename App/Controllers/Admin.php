<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Aadhaar;
use App\Models\Image;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserVariables;
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
        // TODO: Proper links at all links
    }

    /**
     * List all Users
     */
    public function listUsersAction(){

        View::renderBlade('admin.list_users');

    }

    /**
     * List all Users
     */
    public function listUserTypesAction(){

        View::renderBlade('admin.list_user_types');

    }

    public function editUserAction(){

//        $id = $this->route_params['id'];
        $id = $_GET['id'];
        $user = User::findByID($id);
        View::renderBlade('admin.edit_user', [
            'user'=>$user,
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
    public function editUserAlbumAction(){


        $id = $_GET['id'];
        $user = User::findByID($id);
        $images = Image::getUserUploadedImages($user->id);
        $num = count($images);
        View::renderBlade('admin/edit_user_album',['images'=>$images,'num'=>$num,'user'=>$user]);
    }

    /**
     * Show self-manage album-page
     * to the user
     */
    public function adjustUserAlbumAction(){


        $id = $_GET['id'];
        //$user = User::findByID($id);
        $images = Image::getUserUploadedImages($id);
        $num = count($images);
        View::renderBlade('admin/adjust_user_album',['images'=>$images,'num'=>$num]);
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

    /**
     * Show Site Settings page
     */
    public function siteSettingsAction(){

        View::renderBlade('admin.site-settings');
    }

    /**
     * Show Site Settings page
     */
    public function siteCleanerAction(){

        $image = new Image();
        $images = $image->unlinkedImagesCount();
        /*var_dump($images);
        exit();*/

        $notification = new Notification();
        $notifications = $notification->unlinkedNoticesCount();
        /*var_dump($notifications);
        exit();*/

        View::renderBlade('admin.site_cleaner',['del_images'=>$images,'del_notices'=>$notifications]);
    }

    public function verifyAadhaarAction(){

        $cards = Aadhaar::pendingIds();
        //var_dump($cards);
        View::renderBlade('admin.verify-aadhaar',['cards'=>$cards]);
    }

}