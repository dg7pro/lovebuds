<?php


namespace App\Controllers;


use App\Lib\Helpers;
use App\Models\User;
use Core\Controller;
use Core\View;

class Search extends Controller
{

    /**
     * Index page
     * works on ajax
     */
    public function indexAction()
    {
        $this->requireLogin();
        $s_num = User::countShortlisted($_SESSION['user_id']);
        $r_num = User::countRecentVisitor($_SESSION['user_id']);
        View::renderBlade('search.profiles2',['s_num' => $s_num,'r_num'=>$r_num]);

    }

    /**
     * Show shortlisted profiles
     * with pagination
     */
    public function shortlistedAction(){

        $this->requireLogin();

        View::renderBlade('search.shortlisted');
    }

    /**
     * Show recent visitor profiles
     * with pagination
     */
    public function recentVisitorsAction(){

        $this->requireLogin();

        View::renderBlade('search.visitors');
    }

    /**
     * Kept for future reference
     * Custom search
     */
    public function testAction(){

        $profiles = User::customSearchResults();

        $newProfiles = [];
        $shortlistedProfiles = [];

        foreach ($profiles as $pro){

            if($pro['mov']==''){
                array_push($newProfiles,$pro);
            }

            if($pro['mov']==1){
                array_push($shortlistedProfiles,$pro);
            }
        }

        Helpers::dnd($newProfiles);
    }

    /**
     * Kept for future reference
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
            }
            if($profileValue['filename']!=null){
                $newProfilesInfo[$newKey]['pics'][$profileKey]["fn"] = $profileValue["filename"];
                $newProfilesInfo[$newKey]['pics'][$profileKey]["pp"] = $profileValue["pp"];
            }
            $newProfileKey[]  = $profileValue["id"];
        }

        return $newProfilesInfo;

    }


    /**
     * Kept for future reference
     * @param $data
     * @return array
     */
    public static function buildQuery($data): array
    {

        // Only fields which are array
        $fields = ['rel','lan','con','mar','edu','ocu','die','smo','dri','man','cha'];
        foreach($fields as $field){
            ${$field} = array();
            ${$field.'_query'} = array();
        }

        $queries=array();

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
                                array_push($queries,"users.language_id IN ($query)");
                                break;

                            case 'con':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.country_id IN ($query)");
                                break;

                            case 'mar':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.marital_id IN ($query)");
                                break;

                            case 'edu':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.education_id IN ($query)");
                                break;

                            case 'ocu':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.occupation_id IN ($query)");
                                break;

                            case 'die':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.diet_id IN ($query)");
                                break;

                            case 'smo':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.smoke_id IN ($query)");
                                break;

                            case 'dri':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.drink_id IN ($query)");
                                break;

                            case 'man':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.manglik_id IN ($query)");
                                break;

                            case 'cha':
                                $query = ${$key.'_query'};
                                array_push($queries,"users.challenged_id IN ($query)");
                                break;
                        }

                    }

                }

                else{
                    $v=${$key} = trim($value);

                    if(!empty($v)){
                        switch ($key){
                            case 'gen':
                                array_push($queries,"users.gender=$v");
                                break;

                            case 'pho':
                                array_push($queries,"users.photo=$v");
                                break;

                            case 'hor':
                                array_push($queries,"users.horoscope=$v");
                                break;

                            case 'hiv':
                                if($v==2){
                                    array_push($queries,"users.hiv<>1");
                                }else{
                                    array_push($queries,"users.hiv=$v");
                                }
                                break;

                            case 'rsa':
                                if($v==1){
                                    // Yes option will show all rows with 0 & 1
                                    array_push($queries,"users.rsa<>2");     // Yes 0,1
                                }else{
                                    array_push($queries,"users.rsa=$v");     // Does not matter 0,1,2  ------   Don't array push
                                }
                                break;

                            case 'minHt':
                                array_push($queries, "users.height_id >=$v");
                                break;

                            case 'maxHt':
                                array_push($queries, "users.height_id <=$v");
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


}