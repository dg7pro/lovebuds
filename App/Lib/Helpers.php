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

    /**
     * @param $size
     * @return string
     */
    public static function generateProfileId($size): string
    {

        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }

        $length = $size - 2;

        $key = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $alpha_key . $key;

    }

    /**
     * @param $gender
     * @return string
     */
    public static function getDefaultAvatar($gender): string
    {

        return $gender==1?'avatar_groom.jpg':'avatar_bride.jpg';
    }

}