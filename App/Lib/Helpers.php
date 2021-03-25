<?php


namespace App\Lib;


/**
 * Class Helpers - Checked
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

    /**
     * Create array of values
     * @param $arr
     * @return array
     */
    public static function getValueIndexedArray($arr){

        $valueIndexedArray = array();
        $i=1;
        foreach($arr as $k=>$v){
            $valueIndexedArray[$v]=array();
            $valueIndexedArray[$v]['order']=$i;
            $i++;
        }
        return $valueIndexedArray;
    }

    public static function emptyStringIntoArray($arr){

        $_arr = json_decode($arr,true);
        if(is_null($_arr)){
            $_arr= array();
        }
        //return $_arr;
        return array_map('intval',array_reverse($_arr));

    }

}