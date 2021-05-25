<?php


namespace App\Models;


use Core\Model;
use PDO;

class AddressRequest extends Model
{
    /**
     * @param $sender
     * @param $receiver
     * @return bool
     */
    public static function create($sender, $receiver): bool
    {

        $sql = "INSERT INTO address_request(sender,receiver) VALUES (?,?)";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$sender, $receiver]);

    }

    public function addressRequestSendToIds($id){

        $sql = "SELECT receiver FROM address_request WHERE sender=?";
        $pdo = Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

    }


}