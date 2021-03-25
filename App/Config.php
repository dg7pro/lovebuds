<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'matrimony';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;


    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'j3p4C1MleqZq8jOLqlIpFqmm4QKevgI8';

    /**
     * Mailgun API key
     *
     * @var string
     */
    const MAILGUN_API_KEY = '320da4d5d9ab0f112db56731a3dfa2a3-9525e19d-c000846e';

    /**
     * Mailgun domain
     *
     * @var string
     */
    const MAILGUN_DOMAIN = 'mg.jumatrimony.com';

    const PAYTM_MERCHANT_KEY = '3s&bKIISCD8L%!zE';
    const PAYTM_TXN_URL= 'https://securegw-stage.paytm.in/theia/processTransaction';
}
