<?php

namespace App\Models;

use Core\Model;
use Exception;
use PDO;

class Person extends Model
{
    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    /**
     * @throws Exception
     */
    public function save(User $user, $contacts): bool
    {

        $new_contacts =[];
        $flag = false;

        foreach($contacts as $c){

            $c['user_id']=$user->id;
            if($c['name']!='' && $c['mobile']!=''){
                $err = $this->validateContact($c['sno'], $c['name'], $c['mobile']);

                if(empty($err)){

                    unset($c['sno']);
                    $new_contacts[] = $c;

                }else{
                    foreach($err as $er){
                        $this->errors[] = $er;
                    }

                }
            }
        }

        $noe = ''; // no. of elements
        if(!empty($new_contacts)){

            //var_dump($new_contacts);
            $data = [];
            foreach($new_contacts as $c){

                $data[]=array_values($c);
            }

            $noe = count($data);
            $pdo = static::getDB();
            $stmt = $pdo->prepare("INSERT INTO persons (name, mobile, user_id) VALUES (?,?,?)");
            try {
                $pdo->beginTransaction();
                foreach ($data as $row)
                {
                    $stmt->execute($row);
                }
                $flag = $pdo->commit();
            }catch (Exception $e){
                $pdo->rollback();
                throw $e;
            }
        }

        return $flag;

    }


    public function validateContact($sno, $name,$mobile): array
    {

        $err = [];

        if(!preg_match("/^([a-zA-Z' ]+)$/",$name)){
            $err[] = 'Invalid name '.$sno;
            //$this->errors = 'Invalid name serial no '.$sno;
        }

        // mobile address
        if (!preg_match("/^[6-9]\d{9}$/",$mobile)) {
            $err[] = 'Invalid mobile number '.$sno;
            //$this->errors = 'Invalid mobile number serial no '.$sno;
        }

        return $err;

    }

    /**
     * @param $start
     * @param $limit
     * @return array
     */
    public static function liveSearch($start, $limit): array
    {

        $query = "SELECT * FROM persons";

        if($_POST['query'] != ''){
            $query .= '
            WHERE first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%"            
            ';
        }

        $query .= ' ORDER BY id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }

    /**
     * @return int
     */
    public static function liveSearchCount(): int
    {

        $query = "SELECT * FROM persons";

        if($_POST['query'] != ''){
            $query .= '
            WHERE first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%"            
            ';
        }


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();

    }

}