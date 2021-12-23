<?php

namespace App\Models;

use Core\Model;
use Exception;
use PDO;

class GroupUser extends Model
{

    public static function getCurrent($user_id){

        $sql = "SELECT group_id from group_user WHERE user_id=?";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function deleteCurrent($user_id): bool
    {

        $sql = "DELETE FROM group_user WHERE user_id=?";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$user_id]);

    }

    public function save($arr): bool
    {
        $user_id = $arr['user_id'];

        //$current_group_association = $this->getCurrent($user_id);

        $this->deleteCurrent($user_id);



        $pair = [];
        $new_list = [];

        foreach($arr['group_list'] as $gle){
            $pair['group_id']=$gle;
            $pair['user_id'] = $user_id;
            $new_list[]=$pair;
        }

        //var_dump($new_list);

        if(!empty($new_list)){

            //var_dump($new_list);
            $data = [];
            foreach($new_list as $c){

                $data[]=array_values($c);
            }

            //$noe = count($data);
            $pdo = static::getDB();
            $stmt = $pdo->prepare("INSERT INTO group_user (group_id, user_id) VALUES (?,?)");
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



}