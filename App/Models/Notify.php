<?php


namespace App\Models;


use Core\Model;
use PDO;

class Notify extends Model
{

    /**
     * @param $userId
     * @return array
     */
    public static function fetchAll($userId): array
    {
        $sql = "SELECT * FROM notify where receiver=? AND status=? ORDER BY created_at";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId,0]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function markAsRead($id): bool
    {

        $pdo=Model::getDB();
        $sql="UPDATE notify SET status=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([1,$id]);

    }

}