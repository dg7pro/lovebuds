<?php

namespace App\Models;

use App\Token;
use Core\Model;
use PDO;

class Group extends Model
{

    /**
     * User constant
     */
    const GROUP = true;

    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    /**
     * User constructor.
     * @param array $data
     */
    public function __construct(array $data=[])
    {
        foreach ($data as $key => $value){
            $this->$key=$value;
        }
    }

    public function persist(): bool
    {

        $this->validate();

        if(empty($this->errors)){

            //$g_title = $this->title;
            //$g_description = $this->description;

            $string = preg_replace("/[^\w]+/", "-", $this->title);
            $slug = strtolower($string);

            $sql = 'INSERT INTO groups (slug, title, description) VALUES (:slug, :title, :description)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);


            $result = $stmt->execute();

            if($result){
                $this->id = $db->lastInsertId();
            }

            return $result;

        }

        return false;
    }

    public function validate(){

        // cFor
        if($this->title==''){
            $this->errors[] = 'Title is required';
        }

        // gender
        if($this->description==''){
            $this->errors[] = 'Description is required';
        }


    }

    /**
     * @param $pid
     * @return mixed
     */
    public static function findBySlug($slug){

        $sql = "SELECT * FROM groups WHERE slug=?";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$slug]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function getProfiles($groupId){

        $sql = "SELECT id, pid, email, first_name, group_id from group_user as gu
                    LEFT JOIN users ON users.id=gu.user_id WHERE group_id=?";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$groupId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /*public static function fetchAll(){

        $sql = "SELECT * from groups ORDER BY id";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }*/

    public static function liveSearch($start, $limit){

        $query = "SELECT * FROM groups";

        if($_POST['query'] != ''){
            $query .= '
            WHERE id LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR slug LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            OR title LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            ';
        }

        $query .= ' ORDER BY id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }

    public static function liveSearchCount(){

        $query = "SELECT * FROM groups";

        if($_POST['query'] != ''){
            $query .= '
            WHERE id LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR slug LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            OR title LIKE "%'.str_replace('', '%', $_POST['query']).'%" ';
        }

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();


    }

    public static function insert($arr){

        $slug = $arr['slug'];
        $name = $arr['name'];
        $description = $arr['description'];
        $likes = $arr['likes'];
        $status = $arr['status'];

        $sql = "INSERT INTO groups(slug,title,description,likes,status) VALUES (?,?,?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$slug,$name,$description,$likes,$status]);

    }

    public static function fetch($gid){

        $sql = "SELECT * FROM groups WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$gid]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($arr){

        $slug = $arr['slug'];
        $name = $arr['name'];
        $description = $arr['description'];
        $likes = $arr['likes'];
        $status = $arr['status'];
        $id = $arr['id'];

        $sql = "UPDATE groups SET  slug=?, title=?, description=?, likes=?, status=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$slug,$name,$description,$likes,$status,$id]);

    }




}