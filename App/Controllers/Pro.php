<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Reference;
use App\Models\Users;
use Core\View;

/**
 * Pro Controller
 */
class Pro extends Marketer
{

    /**
     * Show user pro-dashboard
     * @return void
     */
    public function index(){

        $tap=0;
        $ear=0;
        $auth_id = Auth::id();
        $ref = new Reference();
        $footprint = $ref->getFootprint($auth_id);
        $signup = $ref->getSignup($auth_id);
        $paid_members = $ref->getPaidMembers($auth_id);

        //var_dump($paid_members);

        $paid = count($paid_members);

        foreach($paid_members as $mem){
            $tap+=$mem['amount_paid']; // total amount paid by users
            $ear+=$mem['earning'];  // total earnings or commission of pro member
        }

        View::renderBlade('pro.dashboard',
            ['footprint'=>$footprint,'signup'=>$signup,'paid'=>$paid,'tap'=>$tap,'ear'=>$ear]);
    }

    /**
     * Ajax Call
     * Shows list of users joined through reference to the user pro-member
     */
    public function footprintUsersAction(){

        $limit = 10;
        $page = 1;
        $type = $_POST['category'];

        $uid = Auth::id();
//        $uid = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $ref = new Reference();
        $results = $ref->myFootprints($start,$limit,$type,$uid);
        $total_data = $ref->myFootprintsCount($type,$uid);
        /*$results = User::liveSearchType($start,$limit,$type);
        $total_data = User::liveSearchTypeCount($type);*/


        // cv- contacts viewed; ac- address count
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