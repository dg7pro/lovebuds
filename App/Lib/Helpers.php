<?php


namespace App\Lib;


/**
 * Class Helpers
 * @package App\Lib
 */
class Helpers
{
    /**
     * Nice Display for development
     * @param $data
     */
    public static function dnd($data){
        echo '<pre>';
        var_dump($data);
        echo '<pre>';
        die();
    }

}