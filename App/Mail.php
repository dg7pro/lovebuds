<?php

namespace App;


use Mailgun\Mailgun;
use Mailgun\Model\Message\SendResponse;

/**
 * Mail
 *
 * PHP version 7.0
 */
class Mail
{

    /**
     * Send a message
     *
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     *
     */
    public static function send($to, $subject, $text, $html)
    {
        $mg = Mailgun::create($_ENV['MAILGUN_API_KEY'], 'https://api.mailgun.net/v3/mg.mailgun.org');
        $domain = $_ENV['MAILGUN_DOMAIN'];

        $mg->messages()->send($domain,['from'    => 'JuMatrimony <admin@jumatrimony.com>',
            'to'      => $to,
            'subject' => $subject,
            'text'    => $text,
            'html'    => $html]);
    }

    public static function sendBulk($recipientL,$recipientV){

        # Instantiate the client.
        $mgClient = Mailgun::create($_ENV['MAILGUN_API_KEY'], 'https://api.mailgun.net/v3/mg.mailgun.org');
        $domain = $_ENV['MAILGUN_DOMAIN'];

        $params =  array(
            'from'    => 'JuMatrimony <admin@jumatrimony.com>',
            'to'      => $recipientL,
            'subject' => 'Hey %recipient.first_name%',
            'text'    => 'If you wish to unsubscribe, please visit JuMatrimony.com This is just a test',
            'recipient-variables' => $recipientV
        );

        return $mgClient->messages()->send($domain, $params);
        //return $result;
    }


    /**
     * @param $recipientL
     * @param $recipientV
     * @param $subject
     * @param $text
     * @param $html
     * @return SendResponse
     */
    public static function sendBulkEmail($recipientL, $recipientV, $text, $html): SendResponse
    {

        # Instantiate the client.
        $mgClient = Mailgun::create($_ENV['MAILGUN_API_KEY'], 'https://api.mailgun.net/v3/mg.mailgun.org');
        $domain = $_ENV['MAILGUN_DOMAIN'];

        $params =  array(
            'from'    => 'JuMatrimony <admin@jumatrimony.com>',
            'to'      => $recipientL,
            'subject' => 'Hey %recipient.first_name%',
            'text'  => $text,
            'html' => $html,
            'recipient-variables' => $recipientV
        );

        return $mgClient->messages()->send($domain, $params);

    }

}
