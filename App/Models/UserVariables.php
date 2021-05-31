<?php


namespace App\Models;


use Carbon\Carbon;
use Core\Model;
use PDO;

class UserVariables extends Model
{

    public static function fetch($tbl){

        $sql="SELECT * FROM $tbl";
        $db=static::getDB();
        $stmt=$db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public static function getTongues(){
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

    public static function getCountries(){
        $sql = "SELECT * FROM alphabets as a 
        LEFT JOIN countries as c ON c.alphabet_id = a.value WHERE a.active=1 ORDER BY a.value, c.name";

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

    public static function getEducations(){

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

    public static function getOccupations(){
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

    public static function getWts(){
        $wts = array();
        for($i=41;$i<=140;$i++){
            $wts[]=$i;
        }
        return $wts;
    }

    public static function getAgeRows(){
        $age_rows = array();
        for($i=18;$i<=72;$i++){
            $age_rows[]=$i;
        }
        return $age_rows;
    }


    public static function languages(){ return $languages = self::fetch('languages');}
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

    public static  function dates(){
        $date_rows = array();
        for($i=1;$i<=31;$i++){
            $date_rows[]=$i;
        }
        return $date_rows;
    }

    public static  function months(){
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

    public static function years(){
        $years = array();
        $cy=Carbon::now()->year;
        $min = $cy-65;
        $max = $cy-18;
        for ($y=$min;$y<=$max;$y++){
            $years[]=$y;
        }
        return $years;
    }

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

}