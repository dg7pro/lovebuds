<?php


namespace App\Controllers;


use App\Models\Aadhar;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Group as GM;
use App\Models\Person;
use App\Models\Reference;
use App\Models\Setting;
use App\Models\User;
use App\Models\Users;

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
    public function searchClients(){

        $message =
            "Welcome to JuMatrimony – the India’s only free matrimonial portal.
            
Finding suitable match - is problem of every home, so we crafted our match making service in such a way that you get 100% response.
 
Just join today and start searching from among – thousands of beautiful bride and grooms, & also do not forget to forward this message to others who need it, with best wishes.

Team
JuMatrimony.com
Whatsapp: 9335683398";

        $ues = urlencode($message);

        $limit = 10;
        $page = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $results = Person::liveSearch($start,$limit);
        $total_data = Person::liveSearchCount();

        $output = '<label>Total Records - '.$total_data.'</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>name</th>                                    
                    <th>mobile</th>
                    <th>msg1</th>                                                                  
                    <th>msg2</th></tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>
                <td>'.$row->name.'</td>
                <td>'.$row->mobile.'</td>         
                <td><a href="https://wa.me/91'.$row->mobile.'?text='.$ues.'" type="button" class="mb-1 btn btn-sm btn-green">wa1</a></td>
                <td><a href="https://wa.me/91'.$row->mobile.'?text=Searching Jeevansathi, click on to continue: https://www.jumatrimony.com/promo" type="button" class="mb-1 btn btn-sm btn-pink">wa2</a></td>
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
                    <th>edit</th>
                    <th>group</th>                   
                    <th>image</th>   
                    <th>is_b</th>  
                    <th>is_v</th>  
                    <th>is_p</th> 
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
                <td><a href="/admin/edit-user?id='.$row->id.'" type="button" class="mb-1 btn btn-sm btn-green">edit</a></td>
                <td><a href="/admin/add-user-to-group?id='.$row->id.'" type="button" class="mb-1 btn btn-sm btn-green">+</a></td>
                <td><a href="/admin/edit-user-album?id='.$row->id.'" type="button" class="mb-1 btn btn-sm btn-pink">view</a></td>
                <td>'.$row->is_block.'</td>
                <td>'.$row->is_verified.'</td>
                <td>'.$row->is_paid.'</td>                
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

    /**
     * Search user dynamically
     */
    public function whatsappUserAction(){

        $message =
            "Thanks for Registering on JuMatrimony – the India’s only free matrimonial portal which is also safe secure and fastest growing.
        
What next?
1. Upload your photo - as profiles with images get more number of responses
2. Complete your Bio data – add other relevant information to your profile
3. Share your profile easily with others – a link to your profile is given below
            
For any assistance or help please feel free to respond to this message 

Team
JuMatrimony.com
Whatsapp: 9335683398";

        $ues = urlencode($message);

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
                    <th>name</th>                                  
                    <th>mobile</th>
                     <th>mv</th>
                    <th>email</th> 
                    <th>ev</th> 
                    <th>cr</th> 
                    <th>ac</th>
                    <th>is_a</th>  
                    <th>one</th>  
                    <th>two</th>
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
                <td><a href="https://wa.me/91'.$row->mobile.'?text='.$ues.'" type="button" class="mb-1 btn btn-sm btn-green">wa1</a></td>
                <td><a href="https://wa.me/91'.$row->mobile.'?text=Profile and photo of '.$row->first_name.' '.$row->last_name.': https://www.jumatrimony.com/profile/'.$row->pid.'" type="button" class="mb-1 btn btn-sm btn-pink">pnb</a></td>
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

    public function hideUserAction(){

        if(isset($_POST['id'])){

            $result = User::actOfHidingUser($_POST['id']);
            if($result){
                $msg = "User profile is not visible to others";
            }

        }
        $json_data = ['msg'=>$msg];
        echo json_encode($json_data);

    }

    public function visibleUserAction(){

        if(isset($_POST['id'])){

            $result = User::actOfVisibleUser($_POST['id']);
            if($result){
                $msg = "User profile is visible to others";
            }

        }
        $json_data = ['msg'=>$msg];
        echo json_encode($json_data);

    }

    public function makeProMemberAction(){

        if(isset($_POST['id'])){

            $result = User::actOfMakingProUser($_POST['id']);
            if($result){
                $msg = "User profile is visible to others";
            }

        }
        $json_data = ['msg'=>$msg];
        echo json_encode($json_data);

    }

    public function revokeProMemberAction(){

        if(isset($_POST['id'])){

            $result = User::actOfRevokingProUser($_POST['id']);
            if($result){
                $msg = "User profile is not visible to others";
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

    /* ==================================================================
     * Payment Order Section: Ajax 1 Functions Bundle
     * Used in payment_orders view
     * ====================================================================
     * */
    public function searchOrder(){

        $limit = 10;
        $page = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $results = Order::liveSearch($start,$limit);
        $total_data = Order::liveSearchCount();

        $output = '<label>Total Records - '.$total_data.'</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>order no</th>
                    <th>amount</th>                   
                    <th>status</th>
                    <th>message</th>    
                    <th>user</th>                 
                    <th>dated</th>                    
                </tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>
                <td>'.$row->order_id.'</td>
                <td>'.$row->txn_amount.'</td>                
                <td>'.$row->status.'</td>
                <td>'.$row->resp_msg.'</td>
                <td>'.$row->user_id.'</td>
                <td>'.$row->created_at.'</td>
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
    /* *** */

    /* ==================================================================
     * Group Section: Ajax 4 Functions Bundle
     * Used in list_group view
     * ====================================================================
     * */
    /**
     * Search group dynamically
     */
    public function searchGroup(){

        $limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $results = GM::liveSearch($start,$limit);
        $total_data = GM::liveSearchCount();

        $output = '<label>Total Records - '.$total_data.'</label>
            
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>slug</th>
                    <th>title</th>                   
                    <th>desc.</th>                   
                    <th>status</th>                                                   
                    <th>edit</th></tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>                
                <td><a href="/'.$row->slug.'" target="blank">'.$row->slug.'</a></td>
                <td>'.$row->title.'</td>                
                <td>'.$row->description.'</td>
                <td>'.$row->status.'</td>               
                <td><button onclick="getGroupInfo('.$row->id.')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>
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
     * Add new group
     */
    public function insertNewGroupRecord(){

        if(isset($_POST['slug']) && $_POST['slug']!=''){

            $re = GM::insert($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'New Group Created';

        }
    }

    /**
     *  Fetch group
     */
    public function fetchSingleGroupRecord(){

        if(isset($_POST['groupId']) && isset($_POST['groupId'])!=''){

            $group_id = $_POST['groupId'];
            $groupInfo = GM::fetch($group_id);
            $num = count($groupInfo);
            if($num>0){
                $response = $groupInfo;
            }else{
                $response['status']=200;
                $response['message']="No data found!";
            }
            echo json_encode($response);

        }
    }

    /**
     * Update group
     */
    public function updateSingleGroupRecord(){

        if(isset($_POST['id'])){

            $re = GM::update($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Basic Info Updated';

        }
    }

    /* ==================================================================
    * Offers Section: Ajax 4 Functions Bundle
    * Used in list_offer view
    * ====================================================================
    * */
    /**
     * Search offers dynamically
     */
    public function searchOffer(){

        $limit = 10;
        $page = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $results = Offer::liveSearch($start,$limit);
        $total_data = Offer::liveSearchCount();

        $output = '<label>Total Records - '.$total_data.'</label>
            
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>code</th>                   
                    <th>price</th>                   
                    <th>rate</th>                                                   
                    <th>payable</th>
                    <th>image</th>
                    <th>status</th>
                    <th>edit</th></tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>
                <td>'.$row->offer_name.'</td>
                <td>'.$row->offer_code.'</td>                
                <td>'.$row->base_price.'</td>
                <td>'.$row->discount_rate.'</td>
                <td>'.$row->discount_price.'</td>
                <td>'.$row->image.'</td>                
                <td>'.$row->status.'</td>
                <td><button onclick="getOfferInfo('.$row->id.')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>
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
     *  Fetch offer
     */
    public function fetchSingleOfferRecord(){

        if(isset($_POST['offerId']) && isset($_POST['offerId'])!=''){

            $offer_id = $_POST['offerId'];
            $offerInfo = Offer::fetch($offer_id);
            $num = count($offerInfo);
            if($num>0){
                $response = $offerInfo;
            }else{
                $response['status']=200;
                $response['message']="No data found!";
            }
            echo json_encode($response);

        }
    }

    /**
     * Update offer
     */
    public function updateSingleOfferRecord(){

        if(isset($_POST['id'])){

            $re = Offer::update($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Basic Info Updated';

        }
    }

    /**
     * Add new offer
     */
    public function insertNewOfferRecord(){

        if(isset($_POST['name']) && $_POST['name']!=''){

            $re = Offer::insert($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'New Group Created';

        }
    }

    /* ==================================================================
   * Admin Setting Section: Ajax 3 Functions Bundle
   * Used in site_settings view
   * ====================================================================
   * */

    /**
     * Handles Admin Settings
     */
    public function manageAdminSettings(){

        $result = '';
        if(isset($_POST['setId']) && isset($_POST['setVa'])){

            if($_POST['setId']==1){
                $result = $this->togglePartnerPreferenceSearch($_POST['setId'],$_POST['setVa']);
            }
            elseif($_POST['setId']==2){
                $result = $this->toggleOffer($_POST['setId'],$_POST['setVa']);
            }
            elseif($_POST['setId']==3){
                $result = $this->toggleInsta($_POST['setId'],$_POST['setVa']);
            }else{
                $msg = "No function is called";
                $result = json_encode($msg);
            }

        }
        echo $result;

    }

    /**
     * Toggle Partner Preferences
     * @param $setId
     * @param $setVa
     * @return false|string
     */
    function togglePartnerPreferenceSearch($setId, $setVa){

        // when you pass boolean through $_POST it will get converted to string
        if($setVa==='true'){

            Setting::enablePps($setId);
            $msg = "Partner preference search is enabled";
            //$msg = $setVa;

        }else{
            Setting::disablePps($setId);
            $msg= "Partner preference search is disabled";
            //$msg = $setVa;
        }
        return json_encode($msg);

    }

    /**
     * Revoke all ongoing Offers
     * @param $setId
     * @param $setVa
     * @return false|string
     */
    function toggleOffer($setId, $setVa){

        // when you pass boolean through $_POST it will get converted to string
        if($setVa==='true'){

            $msg = "Will not work from here";
            //$msg = $setVa;

        }else{
            Setting::revokeOffer($setId);
            $msg= "Disabled all settings";
            //$msg = $setVa;
        }

        return json_encode($msg);

    }

    function toggleInsta($setId, $setVa){

        // when you pass boolean through $_POST it will get converted to string
        if($setVa==='true'){
            Setting::enactInsta($setId);
            $msg = "Insta offer enabled";
            //$msg = $setVa;

        }else{
            Setting::revokeInsta($setId);
            $msg= "Insta offer disabled";
            //$msg = $setVa;
        }

        return json_encode($msg);

    }



    /* ==================================================================
    * Admin Pro members Section: Ajax 2 Functions Bundle
    * Used in
    * ====================================================================
    * */

    /**
     * Ajax Call
     * Shows all pro users to the admin
     */
    public function proUsersAction(){

        $limit = 10;
        $page = 1;
        $type = $_POST['ut'];

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $_users = new Users();
        $results = $_users->proUsers($start,$limit,$type);
        $total_data = $_users->proUsersCount($type);

        // cv- contacts viewed; ac- address count
        $output = '<label>Total Records - '.$total_data.'</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Id</th>                     
                    <th>Name (ProfileId)</th>
                    <th>Pro Dashboard</th>             
                </tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>
                <td>'.$row->first_name.' <a href="/profile/'.$row->pid.'" target="blank">'.$row->pid.'</a></td>
                <td><a href="/admin/pro-stats?pro_id='.$row->id.'" target="blank">View</a></td>                             
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


    public function proStatsAction(){

        $limit = 10;
        $page = 1;
        $type = $_POST['category'];

        $uid = $_POST['uid'];


        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $ref = new Reference();
        $results = $ref->myFootprints($start,$limit,$type,$uid);
        $total_data = $ref->myFootprintsCount($type,$uid);

        $output = '<label>Total Records - '.$total_data.'</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Code</th>
                    <th>Signup</th>  
                    <th>Name (ProfileId)</th>           
                    <th>Paid</th>
                    <th>Amount</th>
                    <th>Earning</th>                   
                </tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->user_code.'</td>
                <td>'.($row->signup=='yes'?'<i class="fa fa-check-circle text-success" aria-hidden="true"></i>':'<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>').'</td>
                <td>'.$row->fname.' <a href="/profile/'.$row->pid.'" target="blank">'.$row->pid.'</a></td>             
                <td>'.($row->signup=='yes'? ($row->pay?'<i class="fa fa-check-circle text-success" aria-hidden="true"></i>':'<i class="fa fa-minus-circle text-secondary" aria-hidden="true"></i>') :'').'</td>                                
                <td>'.$row->amount_paid.'</td>
                <td>'.$row->earning.'</td>               
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

}