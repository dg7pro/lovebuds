<?php


namespace App;


use Exception;

/**
 * Class Csrf
 * @package App
 */
class Csrf
{
    /**
     * @var mixed|string
     */
    protected $token;

    /**
     * Csrf constructor.
     * @param null $csrf_token
     * @throws Exception
     */
    public function __construct($csrf_token = null)
    {
        if ($csrf_token) {

            $this->token = $csrf_token;

        } else {

            $this->token = bin2hex(random_bytes(32));  // 16 bytes = 128 bits = 32 hex characters
        }
    }

    /**
     * Returns the value of token
     * @return mixed|string
     */
    public function getValue(){

        return $this->token;

    }

    /**
     * Validate token value with its hash
     * @return bool
     */
    public function validate(): bool
    {
        if (hash_equals($_SESSION['csrf_token'], $this->token)) {
            // Proceed to process the form data
            return true;
        } else {
            // Log this as a warning and keep an eye on these attempts
            return false;
        }
    }

}