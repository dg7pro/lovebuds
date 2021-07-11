<?php


namespace App;


/**
 * Class Flash
 * @package App
 */
class Flash
{
    /**
     * Type success
     */
    const SUCCESS = 'success';

    /**
     * Type info
     */
    const INFO = 'info';

    /**
     * Type warning
     */
    const WARNING = 'warning';

    /**
     * Type danger
     */
    const DANGER = 'danger';

    /**
     * Add flash messages to session
     * @param $message
     * @param string $type
     */
    public static function addMessage($message, $type='info'){

        if(!isset($_SESSION['flash_notifications'])){
            $_SESSION['flash_notifications']=[];
        }

        $_SESSION['flash_notifications'][]=['body'=>$message,'type'=>$type];

    }

    /**
     * Return messages and unset sessions
     * @return mixed
     */
    public static function getMessage(){

        if(isset($_SESSION['flash_notifications'])){
            $message =  $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);
            return $message;
            //return $_SESSION['flash_notifications'];
        }
    }

}