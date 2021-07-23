<?php


namespace App\Models;


use Core\Model;
use PDO;

/**
 * Class Image
 * @package App\Models
 */
class Image extends Model
{

    /**
     * @param $userId
     * @return array
     */
    public static function fetchProfileImages($userId): array
    {

        $sql = "SELECT * FROM images WHERE user_id=? AND linked = 1 AND approved = 1";
        $pdo=Model::getDB();

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * @param $id
     * @return mixed
     */
    public static function getUserImages($id){

        $imgSql = "SELECT * FROM images WHERE user_id=? AND approved=1 AND pp=1";
        $db = Model::getDB();
        $stmt = $db->prepare($imgSql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);

    }


    /**
     * Fetch unapproved images
     * @return array
     */
    public static function getUnApprovedImages(): array
    {
        $sql = "SELECT * FROM images WHERE approved=0 AND linked = 1";
        $pdo = Model::getDB();

        $stmt= $pdo->prepare($sql);
        $stmt->execute();
        return $images = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Fetch user images
     * @param $id
     * @return array
     */
    public static function getUserUploadedImages($id): array
    {
        $imgSql = "SELECT * FROM images WHERE user_id=? AND linked=1";
        $db = Model::getDB();
        $stmt = $db->prepare($imgSql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(pdo::FETCH_OBJ);

    }

    /**
     * @param $id
     * @return int
     */
    public static function checkForFirstImage($id): int
    {
        $sql = "SELECT * FROM images WHERE user_id=?";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    /**
     * @param $userId
     * @param $fileName
     * @return bool
     */
    public static function persistUserImage($userId, $fileName): bool
    {

        // check if this is first image
        $x = self::checkForFirstImage($userId);

        $pdo = Model::getDB();
        $img_id = self::random_token(5);

        if($x<1){

            $sql = "INSERT INTO images (user_id,img_id,pp,filename) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $result=$stmt->execute([$userId,$img_id,1,$fileName]);

            // if first image make it avatar
            $sqlP = "UPDATE users SET avatar=?,photo=? WHERE id=?";
            $stmt = $pdo->prepare($sqlP);
            $stmt->execute([$fileName,1,$userId]);

        }else{
            $sql = "INSERT INTO images (user_id,img_id,filename) VALUES (?,?,?)";
            $stmt = $pdo->prepare($sql);
            $result=$stmt->execute([$userId,$img_id,$fileName]);
        }

        return $result;

    }

    /**
     * @param $userId
     * @return array
     */
    public static function fetchUserImagesForDisplay($userId): array
    {

        $sql = "SELECT * FROM images WHERE user_id=? AND linked = 1";
        $pdo=Model::getDB();

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        //$num = $stmt->rowCount();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Generate token for Verification Purpose
     * @param $size
     * @return string
     */
    protected static function random_token($size): string
    {
        $token = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $size; $i++) {
            $token .= $keys[array_rand($keys)];
        }
        return $token;
    }

    /**
     * @param $userId
     * @param $imgId
     * @return bool
     */
    public static function approveUserPhoto($userId, $imgId): bool
    {

        $sql = "UPDATE images SET approved=? WHERE user_id=? AND img_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $status =  $stmt->execute([1,$userId,$imgId]);

        if($status){
            $message = 'Photo approved by moderator <a href="/account/manage-photo"><strong> View </strong></a>';
            Notification::save($userId,$message,$_SESSION['user_id']);
        }
        return $status;
    }

    /**
     * @param $userId
     * @param $imgId
     * @return bool
     */
    public static function rejectUserPhoto($userId, $imgId): bool
    {

        $sql = "UPDATE images SET approved=? WHERE user_id=? AND img_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute([2,$userId,$imgId]);

        if($status){
            //Notification::save('photo_rejected',$userId);
            self::setAvatarIndexOnProfilePicRejection($userId,$imgId);
        }

        return $status;

    }

    /**
     * @param $userId
     * @return bool
     */
    protected static function clearUserAvatar($userId): bool
    {

        $sql = "UPDATE images SET pp=?, ac=? WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([0,0,$userId]);

    }

    /**
     * @param $userId
     * @param $imgId
     * @return mixed
     */
    public static function getImageFilename($userId, $imgId){

        $sql = "SELECT filename FROM images WHERE user_id=? AND img_id=?";
        $pdo= Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId,$imgId]);
        $result = $stmt->fetch();
        return $result['filename'];
    }

    /**
     * @param $userId
     * @param $imgId
     * @return bool
     */
    public static function changeUserAvatar($userId, $imgId): bool
    {

        // For all the images profile pic pp is set to 0
        self::clearUserAvatar($userId);

        $sql = "UPDATE images SET pp=? WHERE user_id=? AND img_id=?";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        $statusX =  $stmt->execute([1,$userId,$imgId]);

        if($statusX){

            $avatar = self::getImageFilename($userId,$imgId);
            if($avatar){
                return self::updateAvatarField($userId,$avatar);
            }

        }
        return false;
    }

    /**
     * @param $userId
     * @param $avatar
     * @return bool
     */
    protected static function updateAvatarField($userId, $avatar): bool
    {

        $pdo=Model::getDB();
        $sql="UPDATE users SET avatar=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$avatar,$userId]);

    }


    /**
     * @param $userId
     * @param $imgId
     */
    protected static function setAvatarIndexOnProfilePicRejection($userId, $imgId){

        $sql = "SELECT i.pp, u.gender FROM images as i
                LEFT JOIN users as u ON u.id = i.user_id
                WHERE i.user_id=? AND i.img_id=?";
        $pdo= Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$userId,$imgId]);
        $img = $stmt->fetch(PDO::FETCH_OBJ);

        if($img->pp==1){
            $sql2="UPDATE images SET ac=? WHERE user_id=?";
            $stmt=$pdo->prepare($sql2);
            $stmt->execute([1,$userId]);
        }
    }

    /**
     * @return array
     */
    public static function imagesForAvatarUpdate(): array
    {

        $sql="SELECT i.*,u.gender FROM images as i
        LEFT JOIN users as u ON u.id=i.user_id
        WHERE i.ac=1 AND i.approved!=0";
        $pdo = Model::getDB();
        $stmt= $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * Fetch image by image id
     * @param $userId
     * @param $imgId
     * @return mixed
     */
    public static function getImageFromImageId($userId, $imgId){

        $sql = "SELECT * FROM images WHERE user_id=? AND img_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $imgId]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    /**
     * Soft delete image
     * @param $userId
     * @param $imgId
     * @return bool
     */
    public static function unlinkImage($userId, $imgId): bool
    {

        $sql = "UPDATE images SET linked=? WHERE user_id=? AND img_id=?";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([0,$userId,$imgId]);

    }

    /**
     * @param $userId
     * @param $imgId
     * @param $fileName
     * @return bool
     */
    public static function changeSelfAvatar($userId, $imgId, $fileName): bool
    {

        $pdo=Model::getDB();

        $sql = "UPDATE images SET pp=? WHERE user_id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([0,$userId]);

        $sql = "UPDATE images SET pp=? WHERE user_id=? AND img_id=?";
        $stmt = $pdo->prepare($sql);
        $statusX =  $stmt->execute([1,$userId,$imgId]);

        if($statusX){
            return self::updateAvatarField($userId,$fileName);
        }
        return false;

    }

}