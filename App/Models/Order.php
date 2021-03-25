<?php


namespace App\Models;


use App\Auth;
use Core\Model;
use PDO;

class Order extends Model
{


    public static function save($orderId,$userId,$amount){

        $sql = "INSERT INTO orders (order_id,user_id,amount) values(?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$orderId,$userId,$amount]);


    }

    public static function updateOrderStatus($data){

        $oid = $data['ORDERID'];
        $tid = $data['TXNID'];
        $sus = $data['STATUS'];
        $rco = $data['RESPCODE'];
        $rms = $data['RESPMSG'];

        //Process your transaction here as success transaction.
        $sql="UPDATE orders SET txn_id=?, status=?, resp_code=?, resp_msg=? WHERE order_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$tid,$sus,$rco,$rms,$oid]);

    }

}