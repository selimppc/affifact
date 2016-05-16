<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 12/14/15
 * Time: 3:57 PM
 */

namespace App\Helpers;


use App\Filter;
use App\Helpers\BounceMail;
use App\SenderEmail;
use App\User;
use DB;
use Session;
//use App\Helpers\Xmlapi;
use App\Imap;
use App\Smtp;
use Illuminate\Support\Facades\Input;
use Queue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserResetPassword;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_MailTransport;
use Swift_Plugins_DecoratorPlugin;
use Swift_Attachment;
use Swift_RfcComplianceException;
use Swift_Plugins_Loggers_EchoLogger;
use Swift_Plugins_LoggerPlugin;
use Swift_Plugins_ImpersonatePlugin;

class Mailer
{

    /* @
     * @param $host ['string']
     * @param $port ['integer']
     * @param $from_email ['string']
     * @param $from_name ['string']
     * @param $username ['string'] :: sender email => username
     * @param $password ['string'] :: sender email => password
     * @param $to_email ['string']
     * @param $subject ['string']
     * @param $subject ['text']
     * @return bool
     */
    public static function send_mail($host, $port, $from_email, $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to){

        /*print "Host : ".$host."\n";
        print "Port : ".$port."\n";
        print "from email : ".$from_email."\n";
        print "from name : ".$from_name."\n";
        print "username : ".$username."\n";
        print "password : ".$password."\n";
        print "to email : ".$to_email."\n";
        print "subject : ".$subject."\n";
        print "body : ".$body."\n";
        #$file_name;
        print "reply to : ".$reply_to."\n";*/
        #exit;

        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($host, $port, 'ssl')
            ->setUsername($username)
            ->setPassword($password)
        ;
        // Send the email
        $mailer = Swift_Mailer::newInstance($transport);
        // Create the message
        $message = Swift_Message::newInstance(null);
        $message->setTo($to_email);
        #$message->setCc("selimppc@gmail.com");
        $message->setSubject($subject);
        $message->setBody($body);
        $message->setFrom($from_email, $from_name);

        $reply_to_name = 'Real World';
        $reply_to_name_arr = @explode('@', $reply_to);
        $reply_to_name = @$reply_to_name_arr[0];
        $message->setReplyTo($reply_to, $reply_to_name);

        $message->setReadReceiptTo("devdhaka404@gmail.com");

        //Bounce Email
        $message->setReturnPath($reply_to);

        //Attachment
        //TODO:: configure attachment in laravel
        if(count($file_name)>0){
            $size = sizeOf($file_name); //get the count of number of attachments
            for($i=0; $i< $size; $i++){
                $message->attach(Swift_Attachment::fromPath($file_name[$i]));
            }
        }
        /*if(count($file_name)>0) {
            $message->attach(Swift_Attachment::fromPath($file_name));
        }*/

        try {
            // Show failed recipients
            if (!$mailer->send($message, $failures)) {
                return $failures;
            }
            return true;
        }catch(\Exception $ex){
            return $ex->getMessage();
        }

    }

}