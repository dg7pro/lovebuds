<?php


namespace App\Models;


use App\Auth;
use Core\Model;
use PDO;

/**
 * Class Notify
 * @package App\Models
 */
class Notification extends Model
{

    /**
     * @param $userId
     * @return array
     */
    public static function fetchAll($userId): array
    {
        $sql = "SELECT * FROM notifications where receiver=? AND status=? ORDER BY created_at";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId,0]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function markAsRead($id): bool
    {

        $pdo=Model::getDB();
        $sql="UPDATE notifications SET status=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([1,$id]);

    }

    /**
     * @param $receiver
     * @param $message
     * @return bool
     */
    public static function save($receiver, $message): bool
    {

        $user = Auth::getUser();
        $nid = self::notificationId(7);

        $sql = "INSERT INTO notifications (id, sender, receiver, message, pid) 
                VALUES(:id, :sender, :receiver, :message, :pid)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $nid, PDO::PARAM_INT);
        $stmt->bindValue(':sender', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':receiver', $receiver, PDO::PARAM_INT);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':pid', $user->pid, PDO::PARAM_STR);

        return $stmt->execute();

    }

    public static function saveSelf($receiver, $message, $pid, $sender): bool
    {
        $nid = self::notificationId(7);

        $sql = "INSERT INTO notifications (id, sender, receiver, message, pid) 
                VALUES(:id, :sender, :receiver, :message, :pid)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $nid, PDO::PARAM_INT);
        $stmt->bindValue(':sender', $sender, PDO::PARAM_INT);
        $stmt->bindValue(':receiver', $receiver, PDO::PARAM_INT);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':pid', $pid, PDO::PARAM_STR);

        return $stmt->execute();

    }

    /**
     * @param $size
     * @return string
     */
    protected static function notificationId($size): string
    {
        $key = 14;
        $keys = range(0, 9);

        for ($i = 0; $i < $size; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;

    }


}