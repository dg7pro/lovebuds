<?php

namespace App;

use App\Config;
use Mailgun\Mailgun;
use PHPMailer;

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
     * @return mixed
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    public static function send($to, $subject, $text, $html)
    {
        $mg = new Mailgun($_ENV['MAILGUN_API_KEY']);
        //$domain = 'sandbox68ab10c762b14b2fa70a0e4637ef0822.mailgun.org';
        $domain = $_ENV['MAILGUN_DOMAIN'];


        $mg->sendMessage($domain, ['from'    => 'JustUnite <admin@jumatrimony.com>',
                                   'to'      => $to,
                                   'subject' => $subject,
                                   'text'    => $text,
                                   'html'    => $html]);
    }

    public static function sendEmailThroughPHPMailer(){

        /**
         * Create a new email
         */
        $mail = new PHPMailer();

        $mail->SMTPDebug = 3;                               // Enable verbose debug output


        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'postmaster@mg.jumatrimony.com';                 // SMTP username
        $mail->Password = 'a6f03ef7f94ec639b8c26c92b690f475-1b6eb03d-b128f218';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;

        $mail->setFrom('dgkashi@gmail.com');
        $mail->addAddress('justuniteindia@gmail.com');

        $mail->Subject = 'An email sent from PHP';
        $mail->Body = 'This is a test message';

        if(!$mail->send()) {
            //echo 'Message could not be sent.';
            return 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return 'Message has been sent';
        }

    }
}
