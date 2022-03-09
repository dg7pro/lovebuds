<?php

namespace App\Controllers;

use App\Csrf;
use App\Flash;
use App\Models\Group as GM;
use App\Models\GroupUser;
use App\Models\Image;
use App\Models\User;
use Core\Controller;
use Core\View;
use Exception;

class Group extends Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderBlade('group.index');
    }

    public function createAction()
    {
        $this->requireLogin();
        View::renderBlade('group.create');
    }

    public function groupPageAction(){

        $this_group = $this->route_params['group'];
        //echo $this_group;

        $gr = GM::findBySlug($this_group);
        if(!$gr){
            throw new Exception('This group does not exist.', 404);
        }

        $grp = $gr->id;
        $profiles = GM::getNewProfiles($grp);
        $newProfiles = self::getAssociativeArrayResult($profiles);

        $num = count($newProfiles);
        //var_dump($profiles);

        View::renderBlade('group.list_profiles',['profiles'=>$newProfiles,'num'=>$num,'title'=>$gr->title]);

    }

    /**
     * @throws Exception
     */
    /*public function pageAction(){

        $slug = $this->route_params['slug'];

        $gr = GM::findBySlug($slug);
        if(!$gr){
            throw new Exception('This group does not exist.', 404);
        }

        $grp = $gr->id;
        $profiles = GM::getNewProfiles($grp);
        $newProfiles = self::getAssociativeArrayResult($profiles);

        $num = count($newProfiles);
        //var_dump($profiles);

        View::renderBlade('group.list_profiles',['profiles'=>$newProfiles,'num'=>$num]);

    }*/

    /**
     * @param $profiles
     * @return array
     */
    public static function getAssociativeArrayResult($profiles): array
    {
        $newProfilesInfo=array();
        $newProfileKey=array();
        $newKey = 0;

        foreach($profiles as $profileKey => $profileValue){

            if(!in_array($profileValue["id"],$newProfileKey)){
                ++$newKey;
                $newProfilesInfo[$newKey]["id"] = $profileValue["id"];
                $newProfilesInfo[$newKey]["pid"] = $profileValue["pid"];
                $newProfilesInfo[$newKey]["email"] = $profileValue["email"];
                $newProfilesInfo[$newKey]["first_name"] = $profileValue["first_name"];
                $newProfilesInfo[$newKey]["last_name"] = $profileValue["last_name"];
                $newProfilesInfo[$newKey]["mobile"] = $profileValue["mobile"];
                $newProfilesInfo[$newKey]["whatsapp"] = $profileValue["whatsapp"];
                $newProfilesInfo[$newKey]["gender"] = $profileValue["gender"];
                $newProfilesInfo[$newKey]["dob"] = $profileValue["dob"];
                $newProfilesInfo[$newKey]["edu"] = $profileValue["edu"];
                $newProfilesInfo[$newKey]["occ"] = $profileValue["occ"];
                $newProfilesInfo[$newKey]["ht"] = $profileValue["ht"];
                $newProfilesInfo[$newKey]["manglik"] = $profileValue["manglik"];
                $newProfilesInfo[$newKey]["religion"] = $profileValue["religion"];
                $newProfilesInfo[$newKey]["caste"] = $profileValue["caste"];
                $newProfilesInfo[$newKey]["lang"] = $profileValue["lang"];
                $newProfilesInfo[$newKey]["mstatus"] = $profileValue["mstatus"];
                $newProfilesInfo[$newKey]["income"] = $profileValue["income"];
                $newProfilesInfo[$newKey]["country"] = $profileValue["country"];
                $newProfilesInfo[$newKey]["state"] = $profileValue["state"];
                $newProfilesInfo[$newKey]["district"] = $profileValue["district"];
                $newProfilesInfo[$newKey]["group"] = $profileValue["gid"];

            }
            if($profileValue['filename']!=null && $profileValue['approved']==1 && $profileValue['linked']!=0){
                $newProfilesInfo[$newKey]['pics'][$profileKey]["fn"] = $profileValue["filename"];
                $newProfilesInfo[$newKey]['pics'][$profileKey]["pp"] = $profileValue["pp"];
            }
            $newProfileKey[]  = $profileValue["id"];
        }
        return $newProfilesInfo;

    }

    /**
     * @throws Exception
     */
    public function brideAction(){

        $pid = $this->route_params['slug'];
        var_dump($pid);

    }

    /**
     * @throws Exception
     */
    public function groomAction(){

        $pid = $this->route_params['slug'];
        var_dump($pid);

    }

    public function saveAction(){

//        var_dump($_POST);
//        exit();

        $this->requireLogin();

        $csrf = new Csrf($_POST['token']);
        if(!$csrf->validate()){
            unset($_SESSION["csrf_token"]);
            die("CSRF token validation failed");
        }

        $gm = new GM($_POST);   // Group Model
        if($gm->persist()){

            $this->redirect('/group/success');

        }else{

            foreach($gm->errors as $error){
                Flash::addMessage($error,'danger');
            }
            $this->redirect('/register/index');

        }

    }

    public function successAction(){
         echo 'success';
    }

    public function addUserAction(){

        $user_id = $_POST['user_id'];
        $gu = new GroupUser();
        if($gu->save($_POST)){
            Flash::addMessage('User added to selected groups','success');
            $this->redirect('/admin/add-user-to-group?id='.$user_id);
        }else{
            Flash::addMessage('Something went wrong could not add to groups','success');
            $this->redirect('/admin/add-user-to-group?id='.$user_id);
        }
        /*if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check) {
                echo $check; //echoes the value set in the HTML form for each checked checkbox.
                //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                //in your case, it would echo whatever $row['Report ID'] is equivalent to.
            }
        }*/
    }

}