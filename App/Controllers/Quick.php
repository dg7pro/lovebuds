<?php


namespace App\Controllers;


use App\Models\User;
use Core\Controller;
use Core\View;

class Quick extends Controller
{

    /**
     *  Show result of quick search
     */
    public function searchAction(){

        View::renderBlade('quick.new2');

    }

    /**
     * Create display profile card
     * @param $profiles
     * @param $pid
     * @return string
     */
    public static function createDisplayCard2($profiles,$pid): string
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

            $output .= '<p class="profile-bio"><a class="profile-name" href="/profile/'.$profile['pid'].'" target="_blank" style="text-decoration: none"><b>'.$profile['pid'].'</b></a><br>'.$profile['town'].'</p>';
            $output .= '</div>';

            $output .= '<div class="profile-main">
                                <a class="profile-name" href="/profile/'.$profile['pid'].'" target="_blank" style="text-decoration: none"><h2>'.$profile['first_name'].'</h2></a>
                                <p class="profile-position">Age: '.\Carbon\Carbon::parse($profile['dob'])->age.'yrs, Ht: '.$profile['ht'].', '.$profile['manglik'].'</p>
                                <p class="profile-body">'.$profile['caste'].', '.$profile['lang'].', '.$profile['mstatus'].',<em> '.$profile['edu'].', '.$profile['occ'].', Income: '.$profile['income'].'</em>
                                , Location: '.$profile['district'].', '.$profile['state'].', '.$profile['country'].'
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
                            <span><i class="fab fa-whatsapp"></i> '.$profile['mobile'].'</span>
                            <span class="mr-1"><i class="fas fa-phone-alt"></i>  '.$profile['mobile'].'</span>
                            <span class="ml-3"><i class="far fa-envelope"></i> '.$profile['email'].'</span>

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

            $output .= '<p class="profile-bio">'.\Carbon\Carbon::parse($profile['dob'])->age.' yrs, '.$profile['ht'].'<br>'.$profile['district'].'</p>';
            $output .= '</div>';

            $output .= '<div class="profile-main">
                                <h2 class="profile-name">'.$profile['first_name'].'</h2>
                                <p class="profile-position">'.$profile['edu'].', '.$profile['occ'].'</p>
                                 <p class="profile-body">'.$profile['religion'].', '.$profile['lang'].', '.$profile['mstatus'].', '.$profile['manglik'].', Income: '.$profile['income'].'/annum,
                                  Location: '.$profile['district'].', '.$profile['state'].', '.$profile['country'].'
                                  
                                </p>
                                <div>
                                    <button class="btn btn-pink" data-toggle="modal" data-target="#exampleModal">Full Profile</button>';

            $output .= '<button type="button" class="btn btn-orange contact" id="contact-btn-'.$profile['id'].'" data-id="'.$profile['id'].'" onclick="showCon('.$profile['id'].')">Contact</button>';


            $output .= '</div></div>';

            $output .= '<div class="profile-handler">                              
                                <a title="Share on whatsapp" class="share" target="_blank" href="https://wa.me/?text=This profile seems to be the perfect match - http://www.jumatrimony.com/profile/'.$profile['pid'].'"><i class="fas fa-share san"></i></a>
                                <a title="Shortlist and Like" data-id="'.$profile['id'].'" class="shortlist" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-heart san"></i></a>
                                <a title="Downlist and Hide" data-id="'.$profile['id'].'" class="downlist" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-arrow-circle-down san"></i></a>
                            </div>';
            $output .= '</div>';

            $output .= '<div class="ups-ab">
                            <span>Contact Address visible to only registered users</span>

                            <div id="ups-ab-overlay-'.$profile['id'].'" class="ups-ab-overlay">
                                <!--user profiles address bar-->
                                <div class="text"></div>
                            </div>
                        </div>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     *  Search Handler function
     */
    public function ajaxSearchProfiles(){

        $data = array();
        $data['rel']=array();
        $data['lan']=array();

        $sex = $_POST['sex']!=''?$_POST['sex']:2;
        $data['gender']=$_POST['gender']!=''?$_POST['gender']:$sex;
        $data['minAge']=$_POST['minAge'];
        $data['maxAge']=$_POST['maxAge'];
        array_push($data['rel'],$_POST['rel']);
        array_push($data['lan'],$_POST['lan']);

        $queries = self::buildQuery($data);

        //var_dump($queries);

        $profiles = User::getQuickSearchResults($queries);

        $newProfilesInfo = self::getAssociativeArrayResult($profiles);

        $num = count($newProfilesInfo);
        $output = '';

        if ($num > 0) {
            $output = self::createDisplayCard($newProfilesInfo);
        }
        echo $output;

        //echo json_encode($queries);
    }


    /**
     * Query builder
     * @param $data
     * @return array
     */
    public static function buildQuery($data): array
    {

        // Only fields which are array
        $fields = ['rel','lan'];
        foreach($fields as $field){
            ${$field} = array();            // Result in $rel[] or $lan[]
            ${$field.'_query'} = array();   // Result in $rel_query or $lan_query
        }

        $queries=array();                   // $queries common array

        foreach($data as $key =>$value){

            if(!empty($value) ) {

                if(is_array($value)){

                    /*
                     * Processing ${$key}
                     * */
                    foreach ($data[$key] as $ke => $val) {
                        array_push(${$key}, $val); // Pushing into array eg. $rel array for religion
                    }
                    ${$key} = array_filter(${$key}); // Removing null values from array

                    ${$key.'_query'} = implode(",", ${$key});

                    if(!empty(${$key.'_query'})){

                        switch ($key){
                            case 'rel':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.religion_id IN ($query)");
                                break;

                            case 'lan':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.community_id IN ($query)");
                                break;
                        }

                    }

                }

                else{
                    $v=${$key} = trim($value);

                    if(!empty($v)){
                        switch ($key){
                            case 'gender':
                                array_push($queries,"users.gender=$v");
                                break;

                            case 'minAge':
                                $maxDate = \Carbon\Carbon::today()->subYears($v)->endOfDay()->toDateString();
                                array_push($queries, "users.dob <= CAST('$maxDate' AS DATE)");
                                break;

                            case 'maxAge':
                                $minDate = \Carbon\Carbon::today()->subYears($v)->toDateString();
                                array_push($queries, "users.dob >= CAST('$minDate' AS DATE)");
                                break;
                        }
                    }
                }
            }
        }
        return $queries;
    }

    /**
     * Array builder function
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
                $newProfilesInfo[$newKey]["town"] = $profileValue["district"];
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
            if($profileValue['filename']!=null && $profileValue['approved']==1 && $profileValue['linked']!=0){
                $newProfilesInfo[$newKey]['pics'][$profileKey]["fn"] = $profileValue["filename"];
                $newProfilesInfo[$newKey]['pics'][$profileKey]["pp"] = $profileValue["pp"];
            }
            $newProfileKey[]  = $profileValue["id"];
        }

        return $newProfilesInfo;

    }


}