<?php


namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Models\User;
use App\Models\UserVariables;
use App\Token;
use Core\Controller;
use Core\View;

/**
 * Class Referral - Checked
 * @package App\Controllers
 */
class Referral extends Controller
{

    //TODO : Create new referral scheme

    /**
     *  Show the referral index page
     */
    public function indexAction(){

        $this->requireLogin();
        $user = Auth::getUser();
        if($user->referral_code=='' || $user->referral_hash==''){
            View::renderBlade('referral.index');
        }else{
            $this->redirect('/referral/my-referral');
        }

    }

    /**
     *  Join User to the referral program
     */
    public function joinAction(){

        $this->requireLogin();
        $token = new Token();
        $result = Auth::getUser()->insertUserReferral($token->getValue(),$token->getHash());
        if($result){
            $this->redirect('/referral/my-referral');
        }

    }

    /**
     *  Show private My referral page to user
     */
    public function myReferralAction(){

        $this->requireLogin();
        $ref = Auth::getUser()->referral_code;
        $url = 'http://matrimony.com/referral/page?code='.$ref;
        View::renderBlade('referral.my-referral',['url'=>$url]);

    }

    /**
     * Most Important Function
     *
     */
    public function pageAction(){

        // Code is user unique token
        $code = $_GET['code'];

        // If some user is logged in
        if(Auth::isLoggedIn()){

            if($this->selfPageCheck($code)){

                Flash::addMessage('This is your referral page, copy the url and send to your unmarried friends');
                $fors = UserVariables::fetch('fors');
                $rflag = true;                              // self referral flag
                View::renderBlade('referral.design',['fors'=>$fors,'referred_by'=>$code,'rflag'=>$rflag]);

            }else{
                Flash::addMessage('Someone has referred JU Matrimony for you, but you are already our member');
                $this->redirect('/Account/welcome');
            }

        }
        else{
            $fors = UserVariables::fetch('fors');

            $expiry_timestamp = time() + 60 * 60 * 24 * 30;
            if(!isset($_COOKIE['ju_referral'])){
                setcookie('ju_referral',$code,$expiry_timestamp,'/');
            }

            Flash::addMessage('Marriage or friendship join JustUnite.com');
            View::renderBlade('referral.design',['fors'=>$fors,'referred_by'=>$code]); // changed from referral.design to home.index
        }

    }

    /**
     * Check if referral page is of other or Auth user
     * @param $code
     * @return bool
     */
    public function selfPageCheck($code){

        $this->requireLogin();
        $referralUser = User::getUserFromReferralCode($code);
       /* var_dump($referralUser->id);
        exit();*/
        if($referralUser->id == Auth::getUser()->id){
            return true;
        }
        return false;
    }

    /**
     *  Dummy new account creation function
     *  Alternative to Register/create action on
     *  self referral
     */
    public function createAction(){

        // Since account is being created by self reference
        $this->redirect('/Referral/stoppage');
    }

    /**
     * Shows stoppage page with instruction
     */
    public function stoppage(){
        View::renderBlade('/Referral/stoppage');
    }


}