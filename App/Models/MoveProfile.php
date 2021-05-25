<?php


namespace App\Models;


use Core\Model;
use PDO;

class MoveProfile extends Model
{
    /**
     * @param $sender
     * @param $receiver
     * @return bool
     */
    public static function create($sender, $receiver, $num): bool
    {

        $sql = "INSERT INTO move_profile(sender,receiver,num) VALUES (?,?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$sender, $receiver, $num]);

    }

    public function getDownlist($id){

        $sql = "SELECT receiver FROM move_profile WHERE sender=? AND num=?";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id,1]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }

    public function getShortlist($id){

        $sql = "SELECT receiver FROM move_profile WHERE sender=? AND num=?";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id,2]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }



}