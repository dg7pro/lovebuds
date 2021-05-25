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

    /**
     * Search user dynamically
     */
    public function searchUser(){

        $limit = 10;
        $page = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $results = User::liveSearch($start,$limit);
        $total_data = User::liveSearchCount();

        $output = '<label>Total Records - '.$total_data.'</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>first name</th>
                    <th>last name</th>                   
                    <th>mobile</th>
                    <th>email</th> 
                    <th>active</th>                                                   
                    <th>edit</th></tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>
                <td>'.$row->first_name.'</td>
                <td>'.$row->last_name.'</td>                
                <td>'.$row->mobile.'</td>
                <td>'.$row->email.'</td>
                <td>'.$row->is_active.'</td>
                <td><button onclick="getContentInfo('.$row->id.')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>
                </tr>';
            }

        }
        else{

            $output .= '<tr><td colspan="4">No data found</td></tr>';

        }

        $output .= '</table></br>
            <div align="center">
                <ul class="pagination">
        ';

        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link ='';

        if($total_links > 4){
            if($page<5){
                for($count=1; $count<=5; $count++){

                    $page_array[]=$count;
                }
                $page_array[]='...';
                $page_array[]=$total_links;
            }else{
                $end_limit = $total_links - 5 ;
                if($page > $end_limit){

                    $page_array[] = 1;
                    $page_array[] = '...';

                    for($count=$end_limit; $count<=$total_links; $count++){
                        $page_array[]=$count;
                    }
                }else{
                    $page_array[]=1;
                    $page_array[]='...';
                    for($count = $page-1; $count<=$page+1; $count++){
                        $page_array[]=$count;
                    }
                    $page_array[]=1;
                    $page_array[]=$total_links;
                }
            }
        }
        else{
            for($count=1; $count <= $total_links; $count++){
                $page_array[] = $count;
            }
        }
        // checked

        for($count = 0; $count < count($page_array); $count++)
        {
            if($page == $page_array[$count])
            {
                $page_link .= '<li class="page-item active">
                      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
                    </li>
                    ';

                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0)
                {
                    $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                }
                else
                {
                    $previous_link = '<li class="page-item disabled">
                        <a class="page-link" href="#">Previous</a>
                      </li>
                      ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id >= $total_links)
                {
                    $next_link = '<li class="page-item disabled">
                        <a class="page-link" href="#">Next</a>
                      </li>';
                }
                else
                {
                    $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            }
            else
            {
                if($page_array[$count] == '...')
                {
                    $page_link .= '
                      <li class="page-item disabled">
                          <a class="page-link" href="#">...</a>
                      </li>
                      ';
                }
                else
                {
                    $page_link .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" 
                    data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>';
                }
            }
        }

        $output .= $previous_link . $page_link . $next_link;
        $output .= '</ul></div>';

        echo $output;
    }

}