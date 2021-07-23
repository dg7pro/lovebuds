<?php


namespace App\Controllers;


use App\Models\District;
use App\Models\UserVariables;

/**
 * Class AjaxLoad
 * @package App\Controllers
 */
class AjaxLoad extends Ajax
{

    /**
     * Limit the no. of married brothers
     */
    public function brosMarried(){

        $this->includeCheck();
        if(isset($_POST['bros_id'])){

            $bros_id = $_POST['bros_id'];
            $num = $bros_id;
            // Generate HTML of city options list
            if($num > 0){
                if($num == 100){
                    $opt = '<option value="">Sorry!</option>';
                    $flag = true;
                }else{
                    $opt = '<option value="">Brothers Married</option>';
                    for ($x = 1; $x <= $num; $x++) {
                        $opt .= '<option value="'.$x.'">'.$x.'</option>';
                    }
                    $flag = true;
                }

            }else{
                $opt = '<option value="">Select Brothers</option>';
                $flag = false;
            }
            $re = ['flag'=>$flag,'opt'=>$opt];
            echo json_encode($re);
        }

    }

    /**
     * Limit the no. of married sisters
     */
    public function sisMarried(){

        $this->includeCheck();
        if(isset($_POST['sis_id'])){

            $sis_id = $_POST['sis_id'];
            $num = $sis_id;
            // Generate HTML of city options list
            if($num > 0){
                if($num == 100){
                    $opt = '<option value="">Sorry!</option>';
                    $flag = true;
                }else{
                    $opt = '<option value="">Sisters Married</option>';
                    for ($x = 1; $x <= $num; $x++) {
                        $opt .= '<option value="'.$x.'">'.$x.'</option>';
                    }
                    $flag = true;
                }
            }else{
                $opt = '<option value="">Select Sisters</option>';
                $flag = false;
            }
            $re = ['flag'=>$flag,'opt'=>$opt];
            echo json_encode($re);
        }
    }

    /**
     *  Limit selection of max age dashboard
     */
    public function minmaxAgeAction(){

        $this->includeCheck();
        if(isset($_POST['min_age_val'])){

            $min_age = $_POST['min_age_val'];
            $num = $min_age;
            // Generate HTML of city options list
            if($num >= 18){
                $opt = '<option value="">max-age</option>';
                for ($x = $num; $x <= 72; $x++) {
                    $opt .= '<option value="'.$x.'">'.$x.'</option>';
                }
                $flag = true;
            }else{
                $opt = '<option value="">min-age first</option>';
                $flag = false;
            }
            $re = ['flag'=>$flag,'opt'=>$opt];
            echo json_encode($re);
        }
    }

    /**
     *  Limit selection of max height dashboard
     */
    public function minmaxHtAction(){

        $this->includeCheck();
        if(isset($_POST['min_ht_val'])){

            $heights = UserVariables::fetch('heights');
            $htArray = json_decode(json_encode($heights), true);
            $c = count($htArray);
            $mc = $c-1; // max count (mc) in array since index start from 0;

            $min_ht = $_POST['min_ht_val'];
            $num = $min_ht;
            // Generate HTML of city options list
            if($num >= $htArray[0]['id']){
                $opt = '<option value="">max-ht</option>';
                for ($x = $num; $x < $htArray[$mc]['id']; $x++) {
                    $opt .= '<option value="'.$x.'">'.$htArray[$x]['feet'].'</option>';
                }
                $flag = true;
            }else{
               $opt = '<option value="">min-ht first</option>';
               $flag = false;
            }
            $re = ['flag'=>$flag,'opt'=>$opt];
            echo json_encode($re);
        }
    }

    /**
     *  Select district for any state
     */
    public function selectDistrict(){

        $this->includeCheck();

        if(isset($_POST['state_id'])){

            $sid = $_POST['state_id'];
            //echo $sid;

            $districts = District::fetchAll($sid);
            $num = count($districts);

            // Generate HTML of city options list
            if($num > 0){
                $opt = '<option value="">Select city</option>';
                foreach ($districts as $district){
                    $opt .= '<option value="'.$district['text'].'" >'.$district['text'].'</option>';
                }
                $flag = true;
            }else{
                $opt = '<option value="">District not available</option>';
                $flag = false;
            }
            $re = ['flag'=>$flag,'opt'=>$opt];
            echo json_encode($re);
        }
    }

}