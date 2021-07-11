<?php

namespace App;


use Mailgun\Mailgun;

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

}
