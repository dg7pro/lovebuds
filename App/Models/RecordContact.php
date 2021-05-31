<?php


namespace App\Models;


use Core\Model;

/**
 * Class RecordContact
 * @package App\Models
 */
class RecordContact extends Model
{

    /**
     * @param $uid
     * @param $oid
     * @return bool
     */
    public function create($uid, $oid): bool
    {
        if(!$this->checkEarlierRecord($uid,$oid)){
            $sql = "INSERT INTO record_contact(user_id,other_id) VALUES (?,?)";
            $pdo = Model::getDB();
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$uid, $oid]);
        }
        return false;
    }

    /**
     * @param $uid
     * @param $oid
     * @return bool
     */
    public function checkEarlierRecord($uid, $oid): bool
    {

        $sql = "SELECT * FROM record_contact WHERE user_id=? AND other_id=?";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$uid, $oid]);

        return (bool)$stmt->rowCount();
    }
}