<?php


namespace App\Models;


use Carbon\Carbon;
use Core\Model;
use PDO;

/**
 * Class UserVariables
 * @package App\Models
 */
class UserVariables extends Model
{

    /**
     * @param $tbl
     * @return array
     */
    public static function fetch($tbl): array
    {

        $sql="SELECT * FROM $tbl";
        $db=static::getDB();
        $stmt=$db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /**
     * @param $rid
     * @return array
     */
    public static function getCastesInOrder($rel): array
    {
        if($rel==1){

            return self::getHinduCastes();

        }else{
            return self::getCastes($rel);
        }

    }

    /**
     * @param $rid
     * @return array
     */
    public static function getCastes($rid): array
    {
        $sql="SELECT * FROM castes WHERE religion_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public static function getTongues(): array
    {
        $sql = "SELECT * FROM directions as d 
        LEFT JOIN tongues as t ON t.direction_id = d.value";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $directions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tongues=array();
        $tongueKey=array();
        $newKey=0;
        foreach($directions as $k=>$v){
            if(!in_array($v['direction_id'],$tongueKey)){
                $newKey++;
                $tongues[$newKey]['value']=$v['value'];
                $tongues[$newKey]['direction']=$v['text'];
            }
            if($v['name']!=null){
                $tongues[$newKey]['lang'][$k]["id"] = $v["id"];
                $tongues[$newKey]['lang'][$k]["name"] = $v["name"];
            }
            $tongueKey[]  = $v['value'];
        }
        return $tongues;
    }

    /**
     * @return array
     */
    public static function getCountries(): array
    {
        $sql = "SELECT * FROM alphabets as a 
        LEFT JOIN countries as c ON c.alphabet_id = a.value WHERE c.name!='' ORDER BY a.value, c.name";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $alphabets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countries=array();
        $countryKey=array();
        $newKey=0;
        foreach($alphabets as $k=>$v){
            if(!in_array($v['alphabet_id'],$countryKey)){
                $newKey++;
                $countries[$newKey]['value']=$v['value'];
                $countries[$newKey]['alpha']=$v['text'];
            }
            if($v['name']!=null){
                $countries[$newKey]['coni'][$k]["id"] = $v["id"];
                $countries[$newKey]['coni'][$k]["name"] = $v["name"];
            }
            $countryKey[]  = $v['value'];
        }
        return $countries;
    }

    /**
     * @return array
     */
    public static function getHinduCastes(): array
    {
        $sql = "SELECT 
            a.value as aid,
            a.text as ast,
            c.value as cid,
            c.text as cst
       
            FROM alphabets as a 
            LEFT JOIN castes as c ON c.alphabet_id = a.value WHERE c.religion_id=1 ORDER BY a.value, c.value";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $alphabets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $castes=array();
        $casteKey=array();
        $newKey=0;
        foreach($alphabets as $k=>$v){
            if(!in_array($v['aid'],$casteKey)){
                $newKey++;
                $castes[$newKey]['aid']=$v['aid'];
                $castes[$newKey]['ast']=$v['ast'];
            }
            if($v['cst']!=null){
                $castes[$newKey]['cas'][$k]["cid"] = $v["cid"];
                $castes[$newKey]['cas'][$k]["cst"] = $v["cst"];
            }
            $casteKey[]  = $v['aid'];
        }
        return $castes;
    }


    /**
     * @return array
     */
    public static function getEducations(): array
    {

        $sql = "SELECT s.id as val,
                    s.name as text,
                    e.stream_id,
                    e.name,
                    e.id                    
             FROM streams as s 
        LEFT JOIN educations as e ON e.stream_id = s.id";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $streams = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $educations=array();
        $educationKey=array();
        $newKey=0;
        foreach($streams as $k=>$v){
            if(!in_array($v['stream_id'],$educationKey)){
                $newKey++;
                $educations[$newKey]['value']=$v['val'];
                $educations[$newKey]['stream']=$v['text'];
            }
            if($v['name']!=null){
                $educations[$newKey]['edu'][$k]["id"] = $v["id"];
                $educations[$newKey]['edu'][$k]["name"] = $v["name"];
            }
            $educationKey[]  = $v['val'];
        }
        return $educations;
    }

    /**
     * @return array
     */
    public static function getOccupations(): array
    {
        $sql = "SELECT c.id as val,
        c.name as cat,
        o.category_id,
        o.name,
        o.id
        FROM categories as c
        LEFT JOIN occupations as o ON o.category_id = c.id";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $occupations=array();
        $occupationKey=array();
        $newKey=0;
        foreach($categories as $k=>$v){
            if(!in_array($v['category_id'],$occupationKey)){
                $newKey++;
                $occupations[$newKey]['value']=$v['val'];
                $occupations[$newKey]['category']=$v['cat'];
            }
            if($v['name']!=null){
                $occupations[$newKey]['occ'][$k]["id"] = $v["id"];
                $occupations[$newKey]['occ'][$k]["name"] = $v["name"];
            }
            $occupationKey[]  = $v['val'];
        }
        return $occupations;
    }

    /**
     * @return array
     */
    public static function getWts(): array
    {
        $wts = array();
        for($i=41;$i<=140;$i++){
            $wts[]=$i;
        }
        return $wts;
    }

    /**
     * @return array
     */
    public static function getAgeRows(): array
    {
        $age_rows = array();
        for($i=18;$i<=72;$i++){
            $age_rows[]=$i;
        }
        return $age_rows;
    }


    public static function  languages(){ return $languages = self::fetch('languages');}
    public static function  religions(){ return $religions = self::fetch('religions');}
    public static function  maritals(){ return $maritals = self::fetch('maritals');}
    public static function  heights(){ return $heights = self::fetch('heights');}
    public static function  mangliks(){ return $mangliks = self::fetch('mangliks');}
    public static function  diets(){ return $diets = self::fetch('diets');}
    public static function  smokes(){ return $smokes = self::fetch('smokes');}
    public static function  drinks(){ return $drinks = self::fetch('drinks');}
    public static function  challenges(){ return $challenges = self::fetch('challenged');}
    public static function  districts(){ return $districts = self::fetch('districts');}
    public static function  degrees(){ return $degrees = self::fetch('degrees');}
    public static function  universities(){ return $universities = self::fetch('universities');}
    public static function  communities(){ return $communities = self::fetch('communities');}
    public static function  castes(){ return $castes = self::fetch('castes');}
    public static function  incomes(){ return $castes = self::fetch('incomes');}
    public static function  states(){ return $states = self::fetch('states');}

    public static function  educations(){ return $educations = self::fetch('educations');}
    public static function  occupations(){ return $occupations = self::fetch('occupations');}


    /**
     * @return array
     */
    public static  function dates(): array
    {
        $date_rows = array();
        for($i=1;$i<=31;$i++){
            $date_rows[]=$i;
        }
        return $date_rows;
    }

    /**
     * @return array[]
     */
    public static  function months(): array
    {
        return array(
            ['value'=>1,'text'=>'January'],
            ['value'=>2,'text'=>'February'],
            ['value'=>3,'text'=>'March'],
            ['value'=>4,'text'=>'April'],
            ['value'=>5,'text'=>'May'],
            ['value'=>6,'text'=>'June'],
            ['value'=>7,'text'=>'July'],
            ['value'=>8,'text'=>'August'],
            ['value'=>9,'text'=>'September'],
            ['value'=>10,'text'=>'October'],
            ['value'=>11,'text'=>'November'],
            ['value'=>12,'text'=>'December']
        );
    }

    /**
     * @return array
     */
    public static function years(): array
    {
        $years = array();
        $cy=Carbon::now()->year;
        $min = $cy-65;
        $max = $cy-18;
        for ($y=$min;$y<=$max;$y++){
            $years[]=$y;
        }
        return $years;
    }

    /**
     * @param $sStartDate
     * @param $sEndDate
     * @param string $sFormat
     * @return false|string
     */
    public static function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d')
    {
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }

    public static function getStates($lan){

        $sql="SELECT state_id FROM community_state WHERE community_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$lan]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);

    }

    public static function getEduOcc(){

        $sql="SELECT eo.education_id, eo.occupation_id, e.name as edu, o.name as occ FROM edu_occ AS eo
                LEFT JOIN educations AS e ON e.id = eo.education_id
                LEFT JOIN occupations AS o ON o.id = eo.occupation_id";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getReligionName($rel){

        $sql="SELECT name FROM religions WHERE id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rel]);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public static function getCommunityName($rel){

        $sql="SELECT name FROM communities WHERE id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rel]);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public static function getMaritalStatus(){

        $sql="SELECT status FROM maritals";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getIncomes($id){

        $sql="SELECT level FROM incomes WHERE id <=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


}