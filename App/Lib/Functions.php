<?php


namespace App\Lib;


class Functions
{

    // TODO Check or delete
    public static function getVariables($tbl){

        $sql="SELECT * FROM $tbl";
        $db=static::getDB();
        $stmt=$db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

}