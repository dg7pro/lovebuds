<?php

namespace App\Models;

use App\Auth;
use Core\Model;
use Exception;
use PDO;

class Contact extends Model
{
    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    public function save(User $user, $contacts){

        $new_contacts =[];
        $flag = false;

        foreach($contacts as $c){

            $c['user_id']=$user->id;
            if($c['name']!=''){
                $err = $this->validateContact($c['sno'], $c['name'], $c['mobile']);

                if(empty($err)){

                    array_push($new_contacts,$c);

                }else{
                    foreach($err as $er){
                        array_push($this->errors,$er);
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
            $stmt = $pdo->prepare("INSERT INTO contacts (sno, name, mobile, user_id) VALUES (?,?,?,?)");
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

        if($flag){
            $add_credits = 5*$noe;
            $incFlag = $user->incrementCredits($add_credits);
        }

        /*if(!empty($this->errors)){
            echo "<br><br>";
            var_dump($this->errors);
        }*/

        return $incFlag;



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

    public function numbersGivenByUser(User $user): int
    {

        $sql = "SELECT * FROM contacts WHERE user_id=:uid";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':uid',$user->id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

}