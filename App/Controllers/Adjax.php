<?php


namespace App\Controllers;


use App\Models\Image;
use App\Models\Kyc;
use App\Models\User;

class Adjax extends Administered
{
    public function approvePhoto(){

        if( isset($_POST['code']) && ($_POST['code']=="approve-photo") ) {

            $iid = $_POST['iid'];
            $uid = $_POST['uid'];

            $status = Image::approveUserPhoto($uid,$iid);

            if($status){
                $msg = "Photo Approved Successfully!";
                $pas = 1;                                                           // photo approval status
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];

            }else{
                $msg = "Sorry something went wrong!";
                $pas = 0;
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];
            }
            echo json_encode($idata);
        }
    }

    public function rejectPhoto(){

        if( isset($_POST['code']) && ($_POST['code']=="reject-photo") ) {

            $iid = $_POST['iid'];
            $uid = $_POST['uid'];

            // Reject the image
            $status = Image::rejectUserPhoto($uid,$iid);

            if($status){

                $msg = "Photo Rejected Successfully!";
                $pas = 1;
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];

            }else{
                $msg = "Sorry something went wrong!";
                $pas = 0;
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];
            }

            echo json_encode($idata);
        }
    }

    public function changeAvatar(){

        if( isset($_POST['code']) && ($_POST['code']=="set-avatar") ) {

            $iid = $_POST['iid'];
            $uid = $_POST['uid'];

            $status = Image::changeUserAvatar($uid,$iid);                  // is put into session without difficulty

            if($status){
                $msg = " Avatar updated Successfully for this user!";
                $pas = 1;                                                           // photo approval status
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];

            }else{
                $msg = "Sorry something went wrong!";
                $pas = 0;
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];
            }
            echo json_encode($idata);
        }
    }

    public function clearAvatar(){

        if( isset($_POST['code']) && ($_POST['code']=="clear-avatar") ) {

            $iid = $_POST['iid'];
            $uid = $_POST['uid'];
            $gen = $_POST['gen'];

            $status = Image::defaultUserAvatar($uid,$iid,$gen);

            if($status){
                $msg = " Avatar cleared Successfully, User will chose avatar himself!";
                $pas = 1;                                                           // photo approval status
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];

            }else{
                $msg = "Sorry something went wrong!";
                $pas = 0;
                $idata = ['msg'=>$msg,'iid'=>$iid,'pas'=>$pas];
            }
            echo json_encode($idata);
        }

    }

    public function getUnApprovedKycDocs(){

        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>                
                    <th scope="col">Mobile</th>    
                    <th scope="col">View Docs</th>                 
                    <th scope="col">Approval</th>                    
                </tr></thead><tbody>';

            $results = Kyc::getUnApprovedList();
            $num = count($results);
            if($num>0){
                foreach($results as $row) {
                    $fin=$row['filename'];
                    $data .= '<tr>
                    <td>'.$row['user_id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['pid'].'</td>
                    <td><button onclick="getKYCImage('."'$fin'".')" type="button" class="mb-1 btn btn-sm btn-secondary">View Docs</button></td>
                    <td><button href="#" class="btn btn-sm btn-outline-success chgAvt" id="approve-'.$row['img_id'].'" 
                    onclick="approveKycDocs('.$row['img_id'].','.$row['user_id'].')" data-id="'.$row['img_id'].'" data-name="'.$row['filename'].'" 
                    value="'.$row['filename'].'">Approve</button></td>
                </tr>';
                }
            }else{
                $data .= '<tr><td class="text-muted text-center" colspan="5"><span class="badge badge-danger text-wrap">No user in this table present right now</span></td></tr>';
            }

            $data .='</tbody></table>';
            echo $data;
        }

    }

    public function approveKyc(){

        if(isset($_POST['fn']) && isset($_POST['iid'])) {

            $fn = $_POST['fn'];
            $iid = $_POST['iid'];
            $uid =$_POST['uid'];

            $status = Kyc::approveUserKycStatus($uid,$iid,$fn);

            if($status){

                $flag = User::verifyUser($uid);
                if($flag){
                    $msg = "Kyc Approved Successfully";
                    $idata = ['msg'=>$msg,'iid'=>$iid];
                    echo json_encode($idata);
                }

            }
        }
    }

}