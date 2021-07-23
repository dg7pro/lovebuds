<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Setting;
use App\Models\User;
use Core\Controller;

/**
 * Class AjaxSearch
 * @package App\Controllers
 */
class AjaxSearch extends Controller
{

    /**
     * @param $profiles
     * @param $pid
     * @return string
     */
    public static function createDisplayCard($profiles, $pid): string
    {
        $output='';
        foreach($profiles as $profile) {
            $output .= '<div class="profiles-card" id="pc-'.$profile['id'].'"><div class="main-card"><div class="profile-sidebar">';
            if(!isset($profile['pics'])){
                $output .= '<img src="'.( $profile['gender']==1?'/img/avatar_groom.jpg':'/img/avatar_bride.jpg' ).'" class="profile-image" width="135px" alt="User Image1" />';
            }
            else{

                $output .= '<div id="gallery'.$profile['id'].'" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">';
                foreach($profile['pics'] as $pic){
                    $output .= '<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">                                                
                                        <a href="/uploaded/pics/'.$pic['fn'].'" data-id="'.$profile['id'].'" class="ju-album2" data-caption="xyz" data-width="600" data-height="800" itemprop="contentUrl">                                                   
                                            <img src="/uploaded/tmb/tn_'.$pic['fn'].'" alt="dfdf" width="135px" class="profile-image"'.($pic['pp']!=1?'hidden':'').'>
                                        </a>
                                    </figure>';
                }
                $output .= '</div>';
            }

            $output .= '<p class="profile-bio">'.\Carbon\Carbon::parse($profile['dob'])->age.' yrs, '.$profile['ht'].'<br>'.$profile['district'].'</p>';


            $output .= '</div>';

            $output .= '<div class="profile-main">
                                <a class="profile-name" href="/profile/'.$profile['pid'].'" target="_blank" style="text-decoration: none"><h2>'.$profile['first_name'].'</h2></a>
                                <p class="profile-position">'.$profile['edu'].', '.$profile['occ'].'</p>
                                 <p class="profile-body">'.$profile['religion'].', '.$profile['lang'].', '.$profile['mstatus'].',<em> '.$profile['caste'].', '.$profile['manglik'].', Income: '.$profile['income'].',</em>
                                 Location: '.$profile['district'].', '.$profile['state'].', '.$profile['country'].'
                                </p>
                                <div>';
            if($_SESSION['user_id']){
                $output .= '<a href="https://wa.me/91'.$profile['mobile'].'?text=Hi I am interested, here is my profile: http://www.jumatrimony.com/profile/'.$pid.'" target="_blank" id="contact-btn-'.$profile['id'].'" class="btn btn-pink" role="button" onclick="sendWhatsappInterest('.$profile['id'].'); return true;">Wa Interest</a>';
            }else{
                $output .= '<button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Wa Interest</button>';
            }
            if($_SESSION['user_id']){
                $output .= '<button id="contact-btn-'.$profile['id'].'" data-id="'.$profile['id'].'" class="btn btn-orange contact" onclick="viewContactAdd('.$profile['id'].')">Contact</button>';
            }else{
                $output .= '<button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Contactc</button>';
            }

            $output .= '</div></div>';

            $output .= '<div class="profile-handler">
                                <a title="Share on whatsapp" class="share" href="https://wa.me/?text=This profile seems to be the perfect match - http://www.jumatrimony.com/profile/'.$profile['pid'].'" target="_blank"><i class="fas fa-share san"></i></a>
                                <a title="Shortlist and Like" data-id="'.$profile['id'].'" class="shortlist" href="javascript:void(0)"><i class="fas fa-heart san"></i></a>
                                <a title="Downlist and Hide" data-id="'.$profile['id'].'" class="downlist" href="javascript:void(0)"><i class="fas fa-arrow-circle-down san"></i></a>
                            </div>';
            $output .= '</div>';

            $output .= '<div class="ups-ab">
                            <div id="addr-'.$profile['id'].'">
                                <!--<span><i class="fab fa-whatsapp"></i> xxxx xxxx xx</span>
                                <span class="mr-1"><i class="fas fa-phone-alt"></i>  xxxx xxxx xx</span>
                                <span class="ml-3"><i class="far fa-envelope"></i> user@jumatrimony.com</span>-->
                                <span><i class="fab fa-whatsapp"></i> '.$profile['mobile'].'</span>
                                <span class="mr-1"><i class="fas fa-phone-alt"></i> '.$profile['mobile'].'</span>
                                <span class="ml-3"><i class="far fa-envelope"></i> '.$profile['email'].'</span>
                            </div>
                            <div id="ups-ab-overlay-'.$profile['id'].'" class="ups-ab-overlay">
                                <!--user profiles address bar-->
                                <div class="text">Contact Address</div>
                            </div>
                        </div>';
            $output .= '</div>';
        }
        return $output;
    }


    /**
     * Fetch and load new profiles
     */
    public function loadNewProfilesAction(){

        $s = new Setting();
        $pps = $s->get_partner_preference_search();

        $pid = Auth::getUser()->pid;
        $newlist = User::newlist($_SESSION['user_id'],$pps);
        $newProfiles = self::getAssociativeArrayResult($newlist);

        $num = count($newProfiles);
        $output = '';

        if ($num > 0) {
            $output = self::createDisplayCard($newProfiles,$pid);
        }
        echo $output;
    }

    /**
     * Fetch and load shortlisted profiles
     */
    public function loadShortlistedProfiles(){

        $pid = Auth::getUser()->pid;
        $shortlist = User::shortlistPagination($_SESSION['user_id']);
        /*var_dump($shortlist);*/
        $shortlistedProfiles = self::getAssociativeArrayResult($shortlist);

        $num = count($shortlistedProfiles);
        $output = '';

        if ($num > 0) {
            $output = self::createDisplayCard($shortlistedProfiles,$pid);

        }
        echo $output;
    }

    /**
     * Fetch and load recent profile visitors
     */
    public function loadRecentVisitors(){

        $userId = $_SESSION['user_id'];

        $pid = Auth::getUser()->pid;
        $visitors = User::recentVisitorPagination($_SESSION['user_id']);
        $recentVisitors = self::getAssociativeArrayResult($visitors);

        $num = count($recentVisitors);
        $output = '';

        if ($num > 0) {
            $output = self::createDisplayCard($recentVisitors, $pid);

        }
        echo $output;
    }

    /**
     * @param $profiles
     * @return array
     */
    public static function getAssociativeArrayResult($profiles): array
    {
        $newProfilesInfo=array();
        $newProfileKey=array();
        $newKey = 0;

        foreach($profiles as $profileKey => $profileValue){

            if(!in_array($profileValue["id"],$newProfileKey)){
                ++$newKey;
                $newProfilesInfo[$newKey]["id"] = $profileValue["id"];
                $newProfilesInfo[$newKey]["pid"] = $profileValue["pid"];
                $newProfilesInfo[$newKey]["email"] = $profileValue["email"];
                $newProfilesInfo[$newKey]["first_name"] = $profileValue["first_name"];
                $newProfilesInfo[$newKey]["last_name"] = $profileValue["last_name"];
                $newProfilesInfo[$newKey]["mobile"] = $profileValue["mobile"];
                $newProfilesInfo[$newKey]["gender"] = $profileValue["gender"];
                $newProfilesInfo[$newKey]["dob"] = $profileValue["dob"];
                $newProfilesInfo[$newKey]["edu"] = $profileValue["edu"];
                $newProfilesInfo[$newKey]["occ"] = $profileValue["occ"];
                $newProfilesInfo[$newKey]["ht"] = $profileValue["ht"];
                $newProfilesInfo[$newKey]["manglik"] = $profileValue["manglik"];
                $newProfilesInfo[$newKey]["religion"] = $profileValue["religion"];
                $newProfilesInfo[$newKey]["caste"] = $profileValue["caste"];
                $newProfilesInfo[$newKey]["lang"] = $profileValue["lang"];
                $newProfilesInfo[$newKey]["mstatus"] = $profileValue["mstatus"];
                $newProfilesInfo[$newKey]["income"] = $profileValue["income"];
                $newProfilesInfo[$newKey]["country"] = $profileValue["country"];
                $newProfilesInfo[$newKey]["state"] = $profileValue["state"];
                $newProfilesInfo[$newKey]["district"] = $profileValue["district"];

            }
            if($profileValue['filename']!=null && $profileValue['approved']!=0 && $profileValue['linked']!=0){
                $newProfilesInfo[$newKey]['pics'][$profileKey]["fn"] = $profileValue["filename"];
                $newProfilesInfo[$newKey]['pics'][$profileKey]["pp"] = $profileValue["pp"];
            }
            $newProfileKey[]  = $profileValue["id"];
        }
        return $newProfilesInfo;

    }


    /**
     * Shortlisted profiles
     * with pagination
     */
    public function shortlistedProfiles(){

        $limit = 10;
        $page = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }
        /*var_dump($start);
        var_dump($page);*/

        $pid = Auth::getUser()->pid;
        $results = User::shortlistPagination($_SESSION['user_id'],$start,$limit);
        /*var_dump($results);
        exit();*/
        $sp = self::getAssociativeArrayResult($results);
        $total_data = User::countShortlisted($_SESSION['user_id']);
        //var_dump($total_data);

        if ($total_data > 0) {
            $output = self::createDisplayCard($sp,$pid);

        }else{
            $output = 'No data found';
        }

        $output .= self::createPaginationBar($total_data,$limit,$page);

        echo $output;
    }


    /**
     * Recent Visitors profiles
     * with pagination
     */
    public function recentVisitors(){

        $limit = 2;
        $page = 1;

        if(isset($_POST['page']) && $_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $pid = Auth::getUser()->pid;
        $results = User::recentVisitorPagination($_SESSION['user_id'],$start,$limit);

        $rv = self::getAssociativeArrayResult($results);
        $total_data = User::countRecentVisitor($_SESSION['user_id']);

        if ($total_data > 0) {
            $output = self::createDisplayCard($rv,$pid);

        }else{
            $output = 'No data found';
        }

        $output .= self::createPaginationBar($total_data,$limit,$page);

        echo $output;

    }

    /**
     * @param $total_data
     * @param $limit
     * @param $page
     * @return string
     */
    public function createPaginationBar($total_data, $limit, $page): string
    {

        $output = '</br>
            <div align="center">
                <ul class="pagination">
        ';

        $total_links = ceil($total_data/$limit);
        //var_dump($total_links);
        $previous_link = '';
        $next_link = '';
        $page_link ='';

        if($total_links > 4){

            if($page<3){
                for($count=1; $count<=3; $count++){

                    $page_array[]=$count;
                }
                $page_array[]='...';
                $page_array[]=$total_links;
            }else{
                $end_limit = $total_links - 4 ;

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

        for($count = 0; $count < count($page_array); $count++)
        {
            if($page == $page_array[$count])
            {
                $page_link .= '<li class="page-item active">
                      <a class="page-link" href="">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
                    </li>
                    ';

                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0)
                {
                    $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'"><i class="fas fa-angle-double-left text-blue"></i></a></li>';
                }
                else
                {
                    $previous_link = '<li class="page-item disabled">
                        <a class="page-link" href=""><i class="fas fa-angle-double-left text-blue"></i></a>
                      </li>
                      ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id > $total_links)
                {
                    $next_link = '<li class="page-item disabled">
                        <a class="page-link" href=""><i class="fas fa-angle-double-right text-blue"></i></a>
                      </li>';
                }
                else
                {
                    $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'"><i class="fas fa-angle-double-right text-blue"></i></a></li>';
                }
            }
            else
            {
                if($page_array[$count] == '...')
                {
                    $page_link .= '
                      <li class="page-item disabled">
                          <a class="page-link" href="">...</a>
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

        return $output;

    }

}