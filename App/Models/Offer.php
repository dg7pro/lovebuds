<?php

namespace App\Models;

use Core\Model;
use PDO;

class Offer extends Model
{
    /**
     * fetch Insta/first offer for the new user
     * @return mixed
     */
    public static function getFirst(){

        $sql="SELECT * FROM offers WHERE id=1 AND status=1";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * fetch current ongoing offer if available
     * @return mixed
     */
    public static function getCurrent(){

        $sql="SELECT * FROM offers WHERE id>1 AND status=1";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * No use kept for reference
     * fetch current ongoing offer if available
     * @return mixed
     */
    public static function isGoingOn(){

        $sql="SELECT * FROM offers WHERE id>1 AND status=1";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();

    }

}