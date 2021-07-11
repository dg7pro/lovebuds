<?php


namespace App\Controllers;


use App\Models\Image;
use App\Models\User;

/**
 * Class Adjax
 * @package App\Controllers
 */
class Adjax extends Administered
{
    /**
     *  Approve User photo from admin
     */
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

    /**
     * Reject User photo from admin
     */
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

    /**
     * Change Avatar image from admin if
     * avatar photo was rejected
     */
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