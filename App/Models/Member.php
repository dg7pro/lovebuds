<?php

namespace App\Models;

use Core\Model;
use PDO;

class Member extends Model
{
    public static function seedMembersTable(): bool
    {

        $sql = "INSERT INTO members( name, gender, img) 
                VALUES (?,?,?)";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);

        $females = ['Avantika','Aanya','Aditi','Ahana','Amaira','Amrita','Anushka','Bhavna','Bhagyasri','Binita','Chaaya',
            'Chandani','Divya','Damini','Deepa','Dhriti','Ekta','Eshika','Falak','Falguni','Garima','Gayathri','Gautami',
            'Hemal','Hemangini','Hiral','Isha','Ishita','Jhanvi','Jagrati','Jasmit','Kavya','Tanya','Vinny','Khushi',
            'Kajal','Kusum','Lakshmi','Lolita','Lovely','Meera','Megha','Mitali','Nyra','Niharika','Nisha','Nidhi',
            'Ojasvi','Oorvi','Palak','Pallavi','Parul','Pihu','Rachita','Ridhi','Rabhya', 'Saira','Saumya','Suman','Gauri',
            'Shreya','Sneha','Suhana','Tanuja','Tripti','Unnati','Urmi','Vasudha','Vinaya','Yashica','Yashoda','Zara'];

        /*$fImages = ['stree1.jpg','stree2.jpg','stree3.jpg','stree4.jpg','stree5.jpg','stree6.jpg','stree7.jpg',
            'stree8.jpg','stree9.jpg','stree10.jpg'];*/
        $fImages =[];
        for($i=1; $i<=25; $i++){
            $img = 'stree'.$i.'.jpg';
            array_push($fImages,$img);
        }

        foreach($females as $fm) {

            $name = $fm;
            $gender = 2;
            $key = array_rand($fImages);
            $stmt->execute([$name, $gender, $fImages[$key]]);

        }

        $males = ['Aarnav','Aayush','Abhimanyu','Aditya','Akshay','Anirudh','Anmol','Arjun','Aryan','Brijesh','Chaitanya',
            'Charan','Dev','Dhruv','Balveer','Gautam','Girindra','Girish','Girish','Gaurav','Gaurav','Hardik','Harish',
            'Hemang','Ishaan','Indrajit','Jagdish','Jatin','Jai','Kabir','Karan','Krishna','Lakshay','Madhav','Mitesh',
            'Maanav','Naveen','Omkaar','Pranav','Rachit','Raghav','Ranbir','Ranveer','Rishi','Rohan','Ronith','Samarth',
            'Samesh','Sarthak','Shaurya','Siddharth','Tejas','Tanay','Utkarsh','Umang','Veer','Yash','Yuvraj','Rahul',
            'Dhananjay'];

       /* $mImages = ['purush1.jpg','purush2.jpg','purush3.jpg','purush4.jpg','purush5.jpg','purush6.jpg','purush7.jpg',
            'purush8.jpg','purush9.jpg','purush10.jpg'];*/
        $mImages =[];
        for($i=1; $i<=15; $i++){
            $img = 'purush'.$i.'.jpg';
            array_push($mImages,$img);
        }

        foreach($males as $fm) {

            $name = $fm;
            $gender = 1;
            $key = array_rand($mImages);
            $stmt->execute([$name, $gender, $mImages[$key]]);

        }

        return true;
    }

    private static function fetchMembers($gen,$rel,$lan){

        $sql = "SELECT * FROM members WHERE (gender = ? AND religion_id=? AND community_id IN (6,2)) ORDER BY RAND() LIMIT 10";
        //$sql = "SELECT * FROM members WHERE (gender = ? AND religion_id=? AND community_id=?) ORDER BY RAND() LIMIT 10";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$gen,$rel]);
        //$stmt->execute([$gen,$rel,$lan]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLocation($lan): array
    {

        $districts = $this->getDummyDist($lan);
        $i = array_rand($districts);
        $dis[] =  $districts[$i];
        $location=[];
        $location['did']=$dis['did'];
        $location['sahar']=$dis['sahar'];
        $location['rajya']=$dis['rajya'];

        return $location;

    }

    public function getMembers($gen,$rel,$lan): array
    {
        $religion = UserVariables::getReligionName($rel);
        $language = UserVariables::getCommunityName($lan);
        $eoArr = UserVariables::getEduOcc();
        $incArr = $this->getDummyIncome($gen);
        $ageArr = $this->getDummyAge($gen);
        $msArr = $this->getDummyMs();
        $mkArr = $this->getDummyMk();
        $htArr = $this->getDummyHt($gen);
        $districts = $this->getDummyDist($lan);

        $membersArr = static::fetchMembers($gen,$rel,$lan);
        $newArr = [];
        foreach($membersArr as $row){

            // religion
            $row['rel']=$religion;

            // language
            $row['lan']=$language;

            // income
            $i = array_rand($incArr);
            $row['income']=$incArr[$i];
            //$row['income']='Rs. 25-35 lakh';

            // edu
            $row['edu']='B tech';

            // occupation
            $row['occ']='Software Developer';

            // age
            $i = array_rand($ageArr);
            $row['age']=$ageArr[$i];

            // marital status
            $i = array_rand($msArr);
            $row['ms']=$msArr[$i];

            // mangliks
            $i = array_rand($mkArr);
            $row['mk']=$mkArr[$i];

            // height
            $i = array_rand($htArr);
            $row['ht']=$htArr[$i];

            // location
            $i = array_rand($districts);
            $location =  $districts[$i];

            $row['did']=$location['did'];
            $row['sahar']=$location['sahar'];
            $row['rajya']=$location['rajya'];

            // education&Occupation
            $i = array_rand($eoArr);
            $eo =  $eoArr[$i];
            $row['edu']=$eo['edu'];
            $row['occ']=$eo['occ'];

            //$row = array_merge($row,$location);
            array_push($newArr,$row);
        }

        return $newArr;

        //$row['dob']=UserVariables::randomDate(1990 - 01 - 01, 2000 - 12 - 31);
        //array_push($row,$row['dob']);

    }

    private function getDummyIncome($gen): array
    {
        if($gen==2){
            $inc_arr = UserVariables::getIncomes(4);
        }else{
            $inc_arr = UserVariables::getIncomes(7);
        }

        return $inc_arr;
        /*$i = array_rand($ages_arr);
        return $ages_arr[$i];*/
    }

    private function getDummyAge($gen): array
    {
        if($gen==2){
            $ages_arr = [21,22,23,24,25,26,27,28,29,30];
        }else{
            $ages_arr = [24,25,26,27,28,29,30,31,32,33,34];
        }

        return $ages_arr;
        /*$i = array_rand($ages_arr);
        return $ages_arr[$i];*/
    }

    private function getDummyHt($gen): array
    {
        if($gen==2){
            $ht_arr = [5.2,5.3,5.4,5.2,5.3,5.4,5.6,5.3,5.1,5.3];
        }else{
            $ht_arr = [5.7, 5.10, 5.10, 5.11, 5.9, 5.10, 6.0, 5.11, 5.10, 5.8, 5.8, 5.9, 5.10];
        }

        return $ht_arr;
        /*$i = array_rand($ht_arr);
        return $ht_arr[$i];*/
    }

    public function getDummyDist($lan): array
    {
        $states = UserVariables::getStates($lan);
        $districtsArr = [];
        foreach($states as $state){
            $districts = District::fetchNames($state);
            $districtsArr=array_merge($districtsArr,$districts);
        }
        return $districtsArr;
    }

    public function getDummyMs(): array
    {

        $maritalStatus = [1=>"Never Married",2=>"Awaiting Divorce", 3=>"Divorced",4=>"Widowed",5=>"Annulled"];
        //$maritalStatus = UserVariables::getMaritalStatus();
        $ms_arr=[];

        $keys = [1,1,3,1,1,1,1,1,1,1,2,1,1];
        foreach($keys as $k){
            array_push($ms_arr,$maritalStatus[$k]);
        }
        //return $maritalStatus;
        return $ms_arr;

    }

    public function getDummyMk(): array
    {

        $mangliks = [1=>"Manglik",2=>"Non Manglik", 3=>"Angshik Manglik"];
        $mk_arr=[];

        $keys = [2,2,3,3,3,2,2,2,1,1,2,1,2,2,3];
        foreach($keys as $k){
            array_push($mk_arr,$mangliks[$k]);
        }
        return $mk_arr;

    }

    public function getDummyEo(): array
    {
        $result = UserVariables::getEduOcc();

        $mk_arr=[];

        $keys = [2,2,3,3,3,2,2,2,1,1,2,1,2,2,3];
        foreach($keys as $k){
            array_push($mk_arr,$result[$k]);
        }
        return $mk_arr;

    }

}