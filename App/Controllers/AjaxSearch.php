<?php


namespace App\Controllers;


use App\Models\User;
use Core\Controller;

class AjaxSearch extends Controller
{
    /**
     * Create display profile card
     * @param $profiles
     * @return string
     */
    public static function createDisplayCard($profiles): string
    {

        $output='';
        foreach($profiles as $profile) {
            $output .= '<div class="profiles-card"><div class="main-card"><div class="profile-sidebar">';
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

            $output .= '<p class="profile-bio">'.\Carbon\Carbon::parse($profile['dob'])->age.' yrs, '.$profile['ht'].'<br>'.$profile['town'].'</p>';
            $output .= '</div>';

            $output .= '<div class="profile-main">
                                <h2 class="profile-name">'.$profile['first_name'].'</h2>
                                <p class="profile-position">'.$profile['edu'].', '.$profile['occ'].'</p>
                                <p class="profile-body">'.$profile['manglik'].' Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis inventore eos ipsam debitis.
                                </p>
                                <div>
                                    <button class="btn btn-pink">Profile</button>';
            if($_SESSION['user_id']){
                $output .= '<button id="contact-btn-'.$profile['id'].'" data-id="'.$profile['id'].'" class="btn btn-orange contact" onclick="fucked('.$profile['id'].')">Contact</button>';
            }else{
                $output .= '<button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Contactc</button>';
            }

            $output .= '</div></div>';

            $output .= '<div class="profile-handler">
                                <a title="Share on whatsapp" class="share" href="javascript:void(0)"><i class="fas fa-share san"></i></a>
                                <a title="Shortlist and Like" data-id="'.$profile['id'].'" class="shortlist" href="javascript:void(0)"><i class="fas fa-heart san"></i></a>
                                <a title="Downlist and Hide" data-id="'.$profile['id'].'" class="downlist" href="javascript:void(0)"><i class="fas fa-arrow-circle-down san"></i></a>
                            </div>';
            $output .= '</div>';

            $output .= '<div class="ups-ab">
                            <span><i class="fab fa-whatsapp"></i>  7565097233</span>
                            <span><i class="fas fa-phone-alt"></i>  7565097233</span>
                            <span><i class="far fa-envelope"></i> dg7proj@gmail.com</span>

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
    public function loadNewProfiles(){

        $newlist = User::newlist($_SESSION['user_id']);
        $newProfiles = self::getAssociativeArrayResult($newlist);

        $num = count($newProfiles);
        $output = '';

        if ($num > 0) {
            $output = self::createDisplayCard($newProfiles);
        }
        echo $output;
    }

    /**
     * Fetch and load shortlisted profiles
     */
    public function loadShortlistedProfiles(){

        $shortlist = User::shortlist($_SESSION['user_id']);
        $shortlistedProfiles = self::getAssociativeArrayResult($shortlist);

        $num = count($shortlistedProfiles);
        $output = '';

        if ($num > 0) {
            $output = self::createDisplayCard($shortlistedProfiles);

        }
        echo $output;
    }

    /**
     * Fetch and load recent profile visitors
     */
    public function loadRecentVisitors(){

        $userId = $_SESSION['user_id'];

        $visitors = User::recentVisitor($_SESSION['user_id']);
        $recentVisitors = self::getAssociativeArrayResult($visitors);

        $num = count($recentVisitors);
        $output = '';

        if ($num > 0) {
            $output = self::createDisplayCard($recentVisitors);

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
                $newProfilesInfo[$newKey]["first_name"] = $profileValue["first_name"];
                $newProfilesInfo[$newKey]["last_name"] = $profileValue["last_name"];
                $newProfilesInfo[$newKey]["gender"] = $profileValue["gender"];
                $newProfilesInfo[$newKey]["dob"] = $profileValue["dob"];
                $newProfilesInfo[$newKey]["edu"] = $profileValue["edu"];
                $newProfilesInfo[$newKey]["occ"] = $profileValue["occ"];
                $newProfilesInfo[$newKey]["ht"] = $profileValue["ht"];
                $newProfilesInfo[$newKey]["town"] = $profileValue["town"];
                $newProfilesInfo[$newKey]["mov"] = $profileValue["mov"];
                $newProfilesInfo[$newKey]["manglik"] = $profileValue["manglik"];
            }
            if($profileValue['filename']!=null){
                $newProfilesInfo[$newKey]['pics'][$profileKey]["fn"] = $profileValue["filename"];
                $newProfilesInfo[$newKey]['pics'][$profileKey]["pp"] = $profileValue["pp"];
            }
            $newProfileKey[]  = $profileValue["id"];
        }
        return $newProfilesInfo;

    }

}