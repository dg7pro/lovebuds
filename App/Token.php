<?php


namespace App;

use App\Config;

class Token
{

    protected $token;

    public function __construct($token_value = null)
    {
        if ($token_value) {

            $this->token = $token_value;

        } else {

            $this->token = bin2hex(random_bytes(16));  // 16 bytes = 128 bits = 32 hex characters
        }
    }

    public function getValue(){
        return $this->token;
    }

    public function getHash(){

        return hash_hmac('sha256',$this->token,$_ENV['SECRET_KEY']);  // Earlier Config::SECRET_KEY
    }




}