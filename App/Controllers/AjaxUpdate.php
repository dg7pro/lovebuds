<?php


namespace App\Controllers;


use App\Auth;

/**
 * Class AjaxUpdate
 * @package App\Controllers
 */
class AjaxUpdate extends Ajax
{
    /**
     * Update contact info dashboard
     */
    public function contactInfoAction(){

        $this->includeCheck();
        if(isset($_POST['ciu'])){

            $user = Auth::getUser();
            $result = $user->updateContactInfo($_POST);

            $mb= $_POST['mobile'];
            $wa= $_POST['whatsapp'];
            if($result){
                $msg = 'Contact details updated successfully';
                $uok = true;
            }else{
                $msg = 'Something is wrong with your number or server is busy';
                $uok = false;
            }
            $re = ['uok'=>$uok,'msg'=>$msg,'mb'=>$mb,'wa'=>$wa];
            echo json_encode($re);
        }

    }

    /**
     * Update Partner Preferences dashboard
     */
    public function updatePartnerPreferenceAction(){

        $this->includeCheck();
        if(isset($_POST['pp'])){

            $user = Auth::getUser();
            $result = $user->updatePartnerPreference($_POST);
            $msg = (!$result)?'Server busy! Please try after sometime':'Partner Preference updated successfully';
            //$msg = json_encode($msg);

            $re = ['msg'=>$msg];
            echo json_encode($re);

        }

    }

    /**
     *  Update basic info edit profile
     */
    public function updateBasicInfoAction(){

        $this->includeCheck();
        if(isset($_POST['bis'])){

            $user = Auth::getUser();
            $result = $user->updateBasicInfo($_POST);

            $error_string ='';
            if(!$result){
                foreach ($user->errors as $error) {
                    $error_string .= $error.', ';
                }
            }
            $msg = (!$result)?$error_string:'Basic information updated successfully';
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }

    }

    /**
     * Update caste info edit profile
     */
    public function updateCasteInfoAction(){

        $this->includeCheck();
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

        $this->includeCheck();
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

        $this->includeCheck();
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

        $this->includeCheck();
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

        $this->includeCheck();
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

        $this->includeCheck();
        if(isset($_POST['his'])){

            $user = Auth::getUser();
            $result = $user->updateAstroDetails($_POST);

            $msg = (!$result)?'Server busy! Please try after sometime':'Astrological details updated successfully';
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }

    }


}