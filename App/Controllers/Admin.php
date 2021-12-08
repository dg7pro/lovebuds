<?php


namespace App\Controllers;


use App\Flash;
use App\Mail;
use App\Models\Aadhar;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Setting;
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

        $settings = Setting::getAll();
        //var_dump($settings);;
        View::renderBlade('admin.site-settings',['settings'=>$settings]);
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

        $cards = Aadhar::pendingIds();
        //var_dump($cards);
        View::renderBlade('admin.verify-aadhaar',['cards'=>$cards]);
    }

    /**
     * Show admin bulk message page
     */
    public function bulkMessageAction(){

        $np = User::getNonPhotoUsers();// no. of non photo users
        $npc = count($np); // non photo user count

        $au = User::getAllActiveUsers();
        $auc = count($au);

        $iu = User::getAllInactiveUsers(); // inactive users
        $iuc = count($iu);                  // inactive users count

        View::renderBlade('admin.bulk_message',['npc'=>$npc,'auc'=>$auc,'iuc'=>$iuc]); // non photo user count

    }


    /**
     * For testing purpose
     * It's rough function
     * @return void
     */
    public function sendEmailMsgAction(){

        //View::renderBlade('admin.bulk_message');

        $nonPhotoUsers = User::getNonPhotoUsers();

        $recL = static::getEmailList($nonPhotoUsers);              // recipientList
        $profiles = static::getAssociativeArrayResult($nonPhotoUsers);      // recipientVariable

//        $recL = array('sg4739598@gmail.com','ps5505915@gmail.com');
//        $recV =  '{"sg4739598@gmail.com": {"first":"Suman", "id":1}, "ps5505915@gmail.com": {"first":"Pratiksha", "id": 2}}';

        //var_dump($profiles);
        //echo json_encode($nonPhotoUsers);
        $recV = json_encode($profiles);

        $result = Mail::sendBulk($recL,$recV);            // Tested
        var_dump($result);

//        var_dump($recL);
//        var_dump($recV);

    }

    /**
     * Send Bulk photo upload reminder emails
     */
    public function sendPhotoUploadReminderAction(){

        $nonPhotoUsers = User::getNonPhotoUsers();

        $recL = static::getEmailList($nonPhotoUsers);              // recipientList
        $profiles = static::getAssociativeArrayResult($nonPhotoUsers);      // recipientVariable

        $recV = json_encode($profiles);

        $text = View::getTemplate('mailgun/photo_upload_reminder.txt');
        $html = View::getTemplate('mailgun/photo_upload_reminder.html');

        $result = Mail::sendBulkEmail($recL,$recV,$text,$html);            // Tested

        if($result){
            Flash::addMessage('Message queued to be send','success');
            $this->redirect('/admin/bulkMessage');
        }

        //var_dump($result);

    }

    /**
     * Send Complete your profiles Bulk Reminder Emails
     */
    public function completeYourProfileReminderAction(){

        $allInactiveUsers = User::getAllInactiveUsers();

        $recL = static::getEmailList($allInactiveUsers);              // recipientList
        $profiles = static::getAssociativeArrayResult($allInactiveUsers);      // recipientVariable

        $recV = json_encode($profiles);

        $text = View::getTemplate('mailgun/complete_profile_reminder.txt');
        $html = View::getTemplate('mailgun/complete_profile_reminder.html');

        $result = Mail::sendBulkEmail($recL,$recV,$text,$html);            // Tested

        if($result){
            Flash::addMessage('Message queued to be send','success');
            $this->redirect('/admin/bulkMessage');
        }

    }

    /**
     * Send New Matches reminder emails
     */
    public function newMatchesReminderAction(){

        $allActiveUsers = User::getAllActiveUsers();

        $recL = static::getEmailList($allActiveUsers);              // recipientList
        $profiles = static::getAssociativeArrayResult($allActiveUsers);      // recipientVariable

        $recV = json_encode($profiles);

        $text = View::getTemplate('mailgun/new_matches_reminder.txt');
        $html = View::getTemplate('mailgun/new_matches_reminder.html');

        $result = Mail::sendBulkEmail($recL,$recV,$text,$html);            // Tested

        if($result){
            Flash::addMessage('Message queued to be send','success');
            $this->redirect('/admin/bulkMessage');
        }

    }

    /**
     * Send Bulk user inactive notice emails
     */
    public function sendUserInactivityNoticeAction(){

        // TODO

    }

    /**
     * Kept for future reference
     * @param $profiles
     * @return array
     */
    private static function getAssociativeArrayResult($profiles): array
    {

        $newProfilesInfo=array();
        $newProfileKey=array();

        foreach($profiles as $profileKey => $profileValue){

            if(!in_array($profileValue["email"],$newProfileKey)){
                $e=$profileValue['email'];
                $newProfilesInfo[$e]["pid"] = $profileValue["pid"];
                $newProfilesInfo[$e]["mail"] = $profileValue["email"];
                $newProfilesInfo[$e]["first_name"] = $profileValue["first_name"];
                $newProfilesInfo[$e]["last_name"] = $profileValue["last_name"];

            }
            $newProfileKey[]  = $profileValue["email"];
        }

        return $newProfilesInfo;

    }

    /**
     * Kept for future reference
     * @param $profiles
     * @return array
     */
    private static function getEmailList($profiles): array
    {
        $newProfileKey=array();
        foreach($profiles as $profileKey => $profileValue){
            $newProfileKey[] = $profileValue["email"];
        }
        return $newProfileKey;
    }

    /**
     * Groups Management Page
     */
    public function groupsManagerAction(){

        //$groups = GM::fetchAll();
        //var_dump($groups);
        View::renderBlade('admin.list_group');
    }

    /**
     * Order Details Page
     */
    public function orderDetailsAction(){

        //$orders = Order::fetchAll();
        //var_dump($groups);
        //View::renderBlade('admin.list_group',['orders'=>$orders]);
        View::renderBlade('admin.payment_orders');
    }

    /**
     * Offers Details Page
     */
    public function offersManagerAction(){

        //$orders = Order::fetchAll();
        //var_dump($groups);
        //View::renderBlade('admin.list_group',['orders'=>$orders]);
        View::renderBlade('admin.offers_manager');
    }


}