<?php

namespace App\Controllers;

use App\Csrf;
use App\Flash;
use App\Models\Group as GM;
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
        View::renderBlade('group/index');
    }

    public function createAction()
    {
        $this->requireLogin();
        View::renderBlade('group/create');
    }

    /**
     * @throws Exception
     */
    public function pageAction(){

        $slug = $this->route_params['slug'];

        $gr = GM::findBySlug($slug);
        if(!$gr){
            throw new Exception('This group does not exist.', 404);
        }

        $grp = $gr->id;
        $profiles = GM::getProfiles($grp);
        //var_dump($profiles);

        View::renderBlade('group.list_profiles',['profiles'=>$profiles]);

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

}