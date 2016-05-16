<?php
/**
 * Created by PhpStorm.
 * User: selimets
 * Date: 11/5/15
 * Time: 10:25 AM
 */

namespace App\Helpers;

use App\SenderEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Helpers\GmailSendMessage;

#use Illuminate\Support\Facades\Queue;
#use Illuminate\Foundation\Console\QueuedJob;
#use GuzzleHttp;
#use GuzzleHttp\Promise\TaskQueue;
#use Illuminate\Support\Facades\Mail;
#use Illuminate\Queue\Queue;
#use Illuminate\Contracts\Mail\MailQueue;
use App\PoppedMessageDetail;

class EmailSend{

    /**
     * @param $host
     * @param $port
     * @param $from_email
     * @param $from_name
     * @param $username
     * @param $password
     * @param $to_email
     * @param $subject
     * @param $body
     * @param $file_name
     * @param $reply_to
     * @param null $reply_to_name
     * @param null $camp_id
     * @param null $popped_message_detail_id
     * @return bool|string
     */
    public static function reply_email($host, $port, $from_email, $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to, $reply_to_name = null, $camp_id = null, $popped_message_detail_id= null){

        print "Host : ".$host."\n";
        print "Port : ".$port."\n";
        print "from email : ".$from_email."\n";
        print "from name : ".$from_name."\n";
        print "username : ".$username."\n";
        print "password : ".$password."\n";
        print "to email : ".$to_email."\n";
        print "subject : ".$subject."\n";
        print "body : ".$body."\n";
        #$file_name;
        print "reply to : ".$reply_to."\n";
        #exit;

        /*
         * Configure Mail.php // @Overriding  TODO:: not done yet .. configure them all
         */
        Config::set('mail.driver', 'smtp');
        Config::set('mail.host', $host);
        Config::set('mail.port', $port);
        Config::set('mail.from', ['address' => $from_email, 'name' => $from_name]);
        Config::set('mail.encryption', 'ssl');
        Config::set('mail.username', $username);
        Config::set('mail.password', $password);
        Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', false);

        if(!$reply_to_name){
            $reply_to_name = 'Real World';
            $reply_to_name_arr = @explode('@', $reply_to);
            $reply_to_name = @$reply_to_name_arr[0];
        }

        // before firing email check the limit of sending for sender email
        $se_limit_check = GmailSendMessage::limit_check_for_sender_email($from_email, $camp_id);
        if($se_limit_check != null) {
            $from_email = $se_limit_check;

            // Send email
            try {
                Mail::send('email_template.common', array('body' => $body), function ($message) use ($from_email, $from_name, $to_email, $subject, $file_name, $reply_to, $reply_to_name, $body) {
                    $message->from($from_email, $from_name);
                    $message->to($to_email);
                    $message->subject($subject);
                    $message->replyTo($reply_to, $name = $reply_to_name);
                    $message->setBody($body, 'text/html');

                    //TODO:: configure attachment in laravel
                    if (count($file_name) > 0) {
                        $size = sizeOf($file_name); //get the count of number of attachments
                        for ($i = 0; $i < $size; $i++) {
                            $message->attach($file_name[$i]);
                        }
                    }

                });

                //update sender email count
                if ($camp_id)
                    $model = SenderEmail::where('email', $from_email)->where('campaign_id', $camp_id)->first();
                else
                    $model = SenderEmail::where('email', $from_email)->first();

                $model->count = $model->count + 1;
                $model->save();


                print "\n Detail ID ". $popped_message_detail_id . "\n";

                if($popped_message_detail_id){
                    try{
                        //Pooped Message Detail UPDATE
                        $pmd = PoppedMessageDetail::findOrFail($popped_message_detail_id);
                        $pmd->sender_email = $from_email;
                        $pmd->d_status = 'mail-sent';
                        $pmd->save();
                    }catch(Exception $e){
                        echo "\n : Error :";
                        print_r($e->getMessage());
                        echo "\n : Error :";
                    }
                }

                return true;
            } catch (\Exception $e) {
                #return $e->getMessage();
                echo "\n : Error :";
                print_r($e->getMessage());
                echo "\n : Error :";
                return false;
            }

        }else{
            return false;
        }


    }

    /**
     * @param $host
     * @param $port
     * @param $from_email
     * @param $from_name
     * @param $username
     * @param $password
     * @param $to_email
     * @param $subject
     * @param $body
     * @param $file_name
     * @param $reply_to
     * @param null $reply_to_name
     * @param null $camp_id
     * @param null $popped_message_detail_id
     * @return bool
     */
    public static function custom_reply_email($host, $port, $from_email, $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to, $reply_to_name = null, $camp_id = null, $popped_message_detail_id=null){



        /*
         * Configure Mail.php // @Overriding  TODO:: not done yet .. configure them all
         */
        Config::set('mail.driver', 'smtp');
        Config::set('mail.host', $host);
        Config::set('mail.port', $port);
        Config::set('mail.from', ['address' => $from_email, 'name' => $from_name]);
        Config::set('mail.encryption', 'ssl');
        Config::set('mail.username', $username);
        Config::set('mail.password', $password);
        Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', false);

        if(!$reply_to_name){
            $reply_to_name = 'Real World';
            $reply_to_name_arr = @explode('@', $reply_to);
            $reply_to_name = @$reply_to_name_arr[0];
        }

        // before firing email check the limit of sending for sender email
        $se_limit_check = GmailSendMessage::limit_check_for_sender_email($from_email, $camp_id);
        if($se_limit_check != null){
            $from_email = $se_limit_check;

            // Send email
            try {
                Mail::send('email_template.common', array('body' => $body), function ($message) use ($from_email, $from_name, $to_email, $subject, $file_name, $reply_to, $reply_to_name, $body) {
                    $message->from($from_email, $from_name);
                    $message->to($to_email);
                    $message->subject($subject);
                    $message->replyTo($reply_to, $name = $reply_to_name);
                    $message->setBody($body, 'text/html');

                    //TODO:: configure attachment in laravel
                    if (count($file_name) > 0) {
                        $size = sizeOf($file_name); //get the count of number of attachments
                        for ($i = 0; $i < $size; $i++) {
                            $message->attach($file_name[$i]);
                        }
                    }

                });

                //update sender email count
                if ($camp_id)
                    $model = SenderEmail::where('email', $from_email)->where('campaign_id', $camp_id)->first();
                else
                    $model = SenderEmail::where('email', $from_email)->first();

                $model->count = $model->count + 1;
                $model->save();

                //Pooped Message Detail UPDATE
                $pmd = PoppedMessageDetail::findOrFail($popped_message_detail_id);
                $pmd->sender_email = $from_email;
                $pmd->d_status = 'mail-sent';
                $pmd->save();

                return true;
            } catch (\Exception $e) {
                return $e->getMessage();
                #return false;
            }

        }else{
            return false;
        }

    }

}