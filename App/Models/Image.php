<?php


namespace App\Models;


use Core\Model;
use PDO;

class Image extends Model
{
    // TODO: Prpper Checking and Commenting

    public static function fetchProfileImages($userId){

        $sql = "SELECT * FROM images WHERE user_id=? AND linked = 1";
        $pdo=Model::getDB();

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    // Deprecated
    public static function getUserImages($id){

        $imgSql = "SELECT * FROM images WHERE user_id=? AND approved=1 AND pp=1";
        $db = Model::getDB();
        $stmt = $db->prepare($imgSql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);

    }

    public static function getUnApprovedImages(){
        $sql = "SELECT * FROM images WHERE approved=0 AND linked = 1";
        $pdo = Model::getDB();

        $stmt= $pdo->prepare($sql);
        $stmt->execute();
        return $images = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getUserUploadedImages($id){

        $imgSql = "SELECT * FROM images WHERE user_id=? AND linked=1";
        $db = Model::getDB();
        $stmt = $db->prepare($imgSql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(pdo::FETCH_OBJ);

    }


    public static function checkForFirstImage($id){

        $sql = "SELECT * FROM images WHERE user_id=?";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();


    }

    public static function persistUserImage($userId,$fileName){

        //==============================
        // Making first image as avatar
        // Then inserting into database
        //==============================

        $x = self::checkForFirstImage($userId);

        $pdo = Model::getDB();
        $img_id = self::random_token(5);

        if($x<1){

            $sql = "INSERT INTO images (user_id,img_id,pp,filename) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $result=$stmt->execute([$userId,$img_id,1,$fileName]);

            $sqlP = "UPDATE users SET avatar=?,photo=? WHERE id=?";
            $stmt = $pdo->prepare($sqlP);
            $stmt->execute([$fileName,1,$userId]);
            //$_SESSION['pic'] = $nm;
        }else{
            $sql = "INSERT INTO images (user_id,img_id,filename) VALUES (?,?,?)";
            $stmt = $pdo->prepare($sql);
            $result=$stmt->execute([$userId,$img_id,$fileName]);
        }

        return $result;

    }

    public static function fetchUserImagesForDisplay($userId){

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
    protected static function random_token($size){
        $token = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $size; $i++) {
            $token .= $keys[array_rand($keys)];
        }
        return $token;
    }

    public static function approveUserPhoto($userId,$imgId){

        $sql = "UPDATE images SET approved=? WHERE user_id=? AND img_id=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $status =  $stmt->execute([1,$userId,$imgId]);

        if($status){
            Notification::save('photo_approved',$userId);
        }
        return $status;
    }

    public static function rejectUserPhoto($userId,$imgId){

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

    protected static function clearUserAvatar($userId){

        $sql = "UPDATE images SET pp=?, ac=? WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([0,0,$userId]);
    }

    public static function getImageFilename($userId, $imgId){

        $sql = "SELECT filename FROM images WHERE user_id=? AND img_id=?";
        $pdo= Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId,$imgId]);
        $result = $stmt->fetch();
        return $result['filename'];
    }

    public static function changeUserAvatar($userId, $imgId){

        self::clearUserAvatar($userId);

        $sql = "UPDATE images SET pp=? WHERE user_id=? AND img_id=?";
        $pdo=Model::getDB();                                                     // For all the images profile pic pp is set to 0
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

    public static function defaultUserAvatar($userId, $imgId, $gen){

        self::clearUserAvatar($userId);
        $avatar = ($gen==1)?'avatar_groom.jpg':'avatar_bride.jpg';
        return self::updateAvatarField($userId,$avatar);

    }

    protected static function updateAvatarField($userId, $avatar){

        $pdo=Model::getDB();
        $sql="UPDATE users SET avatar=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$avatar,$userId]);

    }


    protected static function setAvatarIndexOnProfilePicRejection($userId,$imgId){


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

    public static function imagesForAvatarUpdate(){

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
     * Used in Ajax Controller
     *
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
     * Used in Ajax Controller
     *
     * @param $userId
     * @param $imgId
     * @return bool
     */
    public static function unlinkImage($userId, $imgId){

        $sql = "UPDATE images SET linked=? WHERE user_id=? AND img_id=?";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([0,$userId,$imgId]);

    }

    public static function changeSelfAvatar($userId,$imgId,$fileName){

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