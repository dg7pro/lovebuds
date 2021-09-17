<?php


namespace App\Controllers;


use App\Models\Aadhar;
use App\Models\Image;
use App\Models\Notification;
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
     *  Approve User photo from admin
     */
    public function verifyAadhaar(){

        if( isset($_POST['code']) && ($_POST['code']=="verify-aadhaar") ) {

            $iid = $_POST['iid'];
            $uid = $_POST['uid'];

            $status = Aadhar::makeDealt($uid);

            if($status){
                $msg = "Aadhaar Approved Successfully!";
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

            $output .= '<tr><td colspan="7">No data found</td></tr>';

        }

        $output .= '</table></br>
            <div align="center">
                <ul class="pagination">
        ';

        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link ='';
        if(!$total_data){
            $page_array[]=1;
        }

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


    /**
     * Search user dynamically
     */
    public function searchUserBlockedAction(){

        $limit = 10;
        $page = 1;
        $type = $_POST['category'];

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $results = User::liveSearchType($start,$limit,$type);
        $total_data = User::liveSearchTypeCount($type);


        // cv- contacts viewed; ac- address count
        $output = '<label>Total Records - '.$total_data.'</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>cfor</th>  
                    <th>full name</th>                                  
                    <th>mobile</th>
                     <th>mv</th>
                    <th>email</th> 
                    <th>ev</th> 
                    <th>credits</th> 
                    <th>ac</th>
                    <th>is_a</th>  
                    <th>is_b</th>  
                    <th>is_v</th>  
                    <th>is_p</th>                                                   
                    <th>edit</th>
                    <th>image</th>   
                </tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>
                <td>'.$row->cfor.'</td>
                <td>'.$row->first_name.' '.$row->last_name.'</td>                                
                <td>'.$row->mobile.'</td>
                <td>'.$row->mv.'</td>
                <td>'.$row->email.'</td>
                <td>'.$row->ev.'</td>
                <td>'.$row->credits.'</td>
                <td>'.$row->ac.'</td>
                <td>'.$row->is_active.'</td>
                <td>'.$row->is_block.'</td>
                <td>'.$row->is_verified.'</td>
                <td>'.$row->is_paid.'</td>
                <td><a href="/admin/edit-user?id='.$row->id.'" type="button" class="mb-1 btn btn-sm btn-green">edit</a></td>
                <td><a href="/admin/edit-user-album?id='.$row->id.'" type="button" class="mb-1 btn btn-sm btn-pink">view</a></td>
                </tr>';
            }

        }
        else{

            $output .= '<tr><td colspan="12">No data found</td></tr>';

        }

        $output .= '</table></br>
            <div align="center">
                <ul class="pagination">
        ';

        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link ='';
        if(!$total_data){
            $page_array[]=1;
        }

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
                    $page_array[]='...';
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

    public function delUselessNoticesAction(){

        $notification = new Notification();
        $nc = $notification->unlinkedNoticesCount();
        $result =  $notification->delUselessNotices();

        if($result){
            $nc = $notification->unlinkedNoticesCount();
            $msg = "Notices deleted successfully";
            $flag = true;
            $json_data = ['msg'=>$msg, 'flag'=>$flag, 'nc'=>$nc];
        }
        else{
            $msg = "Something went wrong";
            $flag = false;
            $json_data = ['msg'=>$msg, 'flag'=>$flag, 'nc'=>$nc];
        }

        echo json_encode($json_data);

    }

    public function delUselessImagesAction(){

        $image = new Image();
        $ic = $image->unlinkedImagesCount();
        $result =  $image->deleteUnlinkedImages();

        if($result){
            $ic = $image->unlinkedImagesCount();
            $msg = "Images deleted successfully";
            $flag = true;
            $json_data = ['msg'=>$msg, 'flag'=>$flag, 'ic'=>$ic];
        }
        else{
            $msg = "Something went wrong";
            $flag = false;
            $json_data = ['msg'=>$msg, 'flag'=>$flag, 'ic'=>$ic];
        }

        echo json_encode($json_data);

    }

    /*
     * ============================================
     * Control Section
     * Control User Activity
     * =====================================================
     */

    public function blockUserAction(){

        if(isset($_POST['id'])){

            $result = User::actOfBlockingUser($_POST['id']);
            if($result){
                $msg = "User Blocked Successfully";
            }

        }
        $json_data = ['msg'=>$msg];
        echo json_encode($json_data);

    }

    public function unblockUserAction(){

        if(isset($_POST['id'])){

            $result = User::actOfUnblockingUser($_POST['id']);
            if($result){
                $msg = "User Un-Blocked Successfully";
            }

        }
        $json_data = ['msg'=>$msg];
        echo json_encode($json_data);

    }

    public function cBlockUserAction(){

        if(isset($_POST['id'])){

            $result = User::actOfCBlockingUser($_POST['id']);
            if($result){
                $msg = "User can't view contacts of others";
            }

        }
        $json_data = ['msg'=>$msg];
        echo json_encode($json_data);

    }

    public function cUnblockUserAction(){

        if(isset($_POST['id'])){

            $result = User::actOfCUnblockingUser($_POST['id']);
            if($result){
                $msg = "Now contact of others are visible";
            }

        }
        $json_data = ['msg'=>$msg];
        echo json_encode($json_data);

    }

    /*
     * ============================================
     * Update Section
     * Updating User information by Admin
     * =====================================================
     */

    /**
     *  Admin update basic info
     */
    public function updateBasicInfoAction(){

        if(isset($_POST['bis'])){

            $user = User::findByID($_POST['uid']);
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
     * Admin update caste info
     */
    public function updateCasteInfoAction(){

        if(isset($_POST['cas'])){

            if(empty($_POST['mycastes'])){
                $msg = "Castes field is empty";
            }else{
                $user = User::findByID($_POST['uid']);
                $result = $user->updateCasteInfo($_POST);
                $msg = (!$result)?'Server busy! Please try after sometime':'Preferred Castes updated successfully';
            }
            $re = ['msg'=>$msg];
            echo json_encode($re);

        }
    }

    /**
     * Admin update education and career
     */
    public function updateEduCareerInfoAction(){

        if(isset($_POST['ecs'])){

            $user = User::findByID($_POST['uid']);
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
     * Admin Update Family details
     */
    public function updateFamilyInfoAction(){

        //echo json_encode($_POST);

        if(isset($_POST['fis'])){

            $user = User::findByID($_POST['uid']);
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
     *  Admin update lifestyle
     */
    public function lifestyleInfoAction(){

        if(isset($_POST['lis'])){

            $user = User::findByID($_POST['uid']);
            $result = $user->updateLifestyleInfo($_POST);

            $msg = (!$result)?'Server busy! Please try after sometime':'Lifestyle Info updated successfully';
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }
    }

    /**
     *  Admin Update likes & interests
     */
    public function likesInfoAction(){

        if(isset($_POST['lik'])){

            if(empty($_POST['myhobbies']) || empty($_POST['myinterests'])){
                $msg = "Select your hobbies and Interests both";
            }else{
                $user = User::findByID($_POST['uid']);
                $result = $user->updateLikesInfo($_POST);
                $msg = (!$result)?'Server busy! Please try after sometime':'Likes & Hobbies updated successfully';
            }

            $re = ['msg'=>$msg];
            echo json_encode($re);
        }
    }

    /**
     * Admin update Astro-details
     */
    public function horoscopeInfoAction(){

        if(isset($_POST['his'])){

            $user = User::findByID($_POST['uid']);
            $result = $user->updateAstroDetails($_POST);

            $msg = (!$result)?'Server busy! Please try after sometime':'Astrological details updated successfully';
            $re = ['msg'=>$msg];
            echo json_encode($re);
        }

    }

}