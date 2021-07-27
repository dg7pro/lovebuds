<?php


namespace App\Controllers;


use App\Models\User;

/**
 * Class AjaxRegistration
 * @package App\Controllers
 */
class AjaxRegistration extends Ajax
{

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

        if(isset($_POST['pw'])){

            $pw = $_POST['pw'];

            if($pw == '' ){
                $n=0;
                $ht = 'Empty value';
            }
            elseif (!preg_match("/^(?=.*[A-Za-z])[A-Za-z\d@$!%*^#?&]{8,32}$/",$pw)) {
                $n=0;
                $ht = 'Minimum 8 digits alphabet, number and special character !@#$%^&*?';
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

    /**
     * Select User Gender
     */
    public function selectAstroAction(){

        $ind = [1,3,5,6];
        $oth = [2,4,7,8,9];

        if(isset($_POST['rel'])){

            $rel = $_POST['rel'];
            if(in_array($rel,$ind)){
                $ash = 'indian';
                $val = 1;
            }elseif (in_array($rel,$oth)){
                $ash = 'other';
                $val = 2;
            }else{
                $ash = 'ambiguous';
                $val = '';
            }

        }

        $_data_arr = ['ash'=>$ash,'val'=>$val];
        echo json_encode($_data_arr);

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



}