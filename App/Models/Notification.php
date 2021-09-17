<?php


namespace App\Models;


use App\Auth;
use Carbon\Carbon;
use Core\Model;
use PDO;

/**
 * Class Notify
 * @package App\Models
 */
class Notification extends Model
{

    /**
     * @param $id
     * @return mixed
     */
    public static function findByID($id){

        $sql = "SELECT * FROM notifications WHERE id= :id";

        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * @param $size
     * @return string
     */
    protected static function notificationId($size): string
    {
        $key = time();
        $keys = range(0, 9);

        for ($i = 0; $i < $size; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }

    /**
     * @param User $user
     * @return array
     */
    public function fetchAll(User $user): array
    {
        $sql = "SELECT * FROM notifications where receiver=? AND status=? ORDER BY id DESC LIMIT 10";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user->id,0]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param $id
     * @return bool
     */
    public function markAsRead($id): bool
    {

        $pdo=Model::getDB();
        $sql="UPDATE notifications SET status=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([1,$id]);

    }

    /**
     * @return int
     */
    public function unlinkedNoticesCount(): int
    {

        $sql = "SELECT * FROM notifications where status=1";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();

    }

    /**
     * @return bool
     */
    public function delUselessNotices(): bool
    {

        $sql = "DELETE FROM `notifications` WHERE status=1 LIMIT 1";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute();

    }

    /**
     * @param $sender
     * @param $receiver
     * @param int $type
     * @return int
     */
    public function countDuplicateEntry($sender, $receiver, int $type=0): int
    {

        $sql = "SELECT * FROM notifications where sender=? AND receiver=? AND type=?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sender,$receiver,$type]);
        return $stmt->rowCount();

    }

    /**
     * Send by self when user register/create account
     * @param $userId
     */
    public function informAboutAccountCreation($userId){

        $dt = Carbon::now();
        $dtt = $dt->toFormattedDateString();
        $message = 'Congrats! Account successfully created on '.$dtt;
        $this->saveSelf($userId,$message);
    }

    /**
     * Send by self when user creates his/her profile
     * @param User $user
     */
    public function informAboutSuccessfulProfileCreation(User $user){

        $message = 'Your profile created & ready to use <a href="/profile/'.$user->pid.'" ><strong> View Profile </strong></a>';
        $this->save($user->id, $message);
    }

    /**
     * Send by Admin on photo approval
     * @param $userId
     */
    public function informAboutPhotoApproval($userId){

        $message = 'Photo approved by moderator <a href="/account/manage-photo"><strong> View </strong></a>';
        $this->save($userId,$message);
    }

    /**
     * Send by Admin on photo rejection
     * @param $userId
     */
    public function informAboutPhotoRejection($userId){

        $message = 'Some of your Photos <a href="/account/manage-photo"><strong> rejected </strong></a> by moderator';
        $this->save($userId, $message);
    }

    /**
     * Send when someone visit your profile
     * @param $otherId
     */
    public function informAboutProfileVisitor($otherId){
        $user = Auth::getUser();
        if(!$this->countDuplicateEntry($user->id,$otherId,1)) {
            $message = '<a href="/profile/'.$user->pid.'" ><strong> '.$user->first_name.' </strong></a> visited your profile';
            $this->save($otherId, $message, 1);
        }

    }

    /**
     * Send when someone views contact details of
     * any member
     * @param $otherId
     */
    public function informAboutContactViewed($otherId){

        $user = Auth::getUser();
        if(!$this->countDuplicateEntry($user->id,$otherId,2)) {
            $message = '<a href="/profile/' . $user->pid . '" ><strong> ' . $user->first_name . ' </strong></a> has viewed your contact details';
            $this->save($otherId, $message, 2);
        }
    }

    /**
     * Send when someone is interested to see address of
     * one-way communication protected member
     * @param $otherId
     */
    public function informAboutInterestedMember($otherId){

        $user = Auth::getUser();

        if(!$this->countDuplicateEntry($user->id,$otherId,3)){
            $message = '<a href="/profile/'.$user->pid.'" ><strong> '.$user->first_name.' </strong></a> is interested and wants to see your contact';
            $this->save($otherId,$message,3);
        }

    }

    /**
     * @param $noticeId
     * @return bool
     */
    public function informAboutAcceptInterest($noticeId): bool
    {

        $notice = static::findById($noticeId);
        $user = Auth::getUser();
        if($notice->response!=1 && $notice->receiver==$user->id)  {
            $message = '<a href="/profile/'.$user->pid.'" ><strong> '.$user->first_name.' </strong></a> accepted your interest. 
                            You can contact on mobile: <strong> '.$user->mobile.' </strong> whatsapp: <strong> '.$user->whatsapp.' </strong> or Email:
                            <strong> '.$user->email.' </strong>';
            $persist = $this->save($notice->sender, $message, 1);

            if($persist){
                $this->updateResponse($notice->id);

            }
            return $persist;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    protected function updateResponse($id): bool
    {
        $pdo=Model::getDB();
        $sql="UPDATE notifications SET response=? WHERE id=?";
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([1,$id]);
    }

    /**
     * Used for events involving 2 users or notifications from Admin
     * @param $receiver
     * @param $message
     * @param int $type
     * @return bool
     */
    protected function save($receiver, $message, int $type=0): bool
    {

        $user = Auth::getUser();

        $sql = "INSERT INTO notifications (sender, receiver, message, pid, type) 
                VALUES(:sender, :receiver, :message, :pid, :type)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        //$stmt->bindValue(':id', $nid, PDO::PARAM_INT);
        $stmt->bindValue(':sender', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':receiver', $receiver, PDO::PARAM_INT);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':pid', $user->pid, PDO::PARAM_STR);
        $stmt->bindValue(':type', $type, PDO::PARAM_INT);

        return $stmt->execute();

    }

    /**
     * Can be used for guest users or for self notification
     * @param $receiver
     * @param $message
     * @param int $type
     * @return bool
     */
    protected function saveSelf($receiver, $message, int $type=0): bool
    {
        $user = User::findByID($receiver);

        $sql = "INSERT INTO notifications (sender, receiver, message, pid, type) 
                VALUES(:sender, :receiver, :message, :pid, :type)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':sender', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':receiver', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':pid', $user->pid, PDO::PARAM_STR);
        $stmt->bindValue(':type', $type, PDO::PARAM_INT);

        return $stmt->execute();

    }


    /*
     *
     * Types of Notification
     * 1. Simple -- default or type 0
     * 2. Profile viewed -- type 1
     * 3. Address viewed -- type 2
     * 4. Address request -- type 3
     * 5. Permission request -- type 4
     *
     * While request needs the permission of the user.
     * User can grant or deny permission
     *
     * */


}