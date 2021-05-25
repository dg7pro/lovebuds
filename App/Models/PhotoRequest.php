<?php


namespace App\Models;


use Core\Model;
use PDO;

class PhotoRequest extends Model
{
    /**
     * @param $sender
     * @param $receiver
     * @return bool
     */
    public static function create($sender, $receiver): bool
    {

        $sql = "INSERT INTO photo_request(sender,receiver) VALUES (?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$sender, $receiver]);

    }

    public function photoRequestSendToIds($id){

        $sql = "SELECT receiver FROM photo_request WHERE sender=?";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }


}