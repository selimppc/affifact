<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 12/17/15
 * Time: 11:56 AM
 */

namespace App\Helpers;

use App\Filter;
use App\SenderEmail;
use DB;
use Illuminate\Support\Facades\Config;
use Session;
use Queue;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use Illuminate\Contracts\Mail\MailQueue;
use DateTime;


class MailQueueJobs
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

    public static function mail_jobs($host, $port, $from_email, $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to){

        /*echo "Host : ".$host."<br>";
        echo "Port : ".$port."<br>";
        echo "from email : ".$from_email."<br>";
        echo "from name : ".$from_name."<br>";
        echo "username : ".$username."<br>";
        echo "password : ".$password."<br>";
        echo "to email : ".$to_email."<br>";
        echo "subject : ".$subject."<br>";
        echo "body : ".$body."<br>";
        #$file_name;
        echo "reply to : ".$reply_to."<br>";
        exit;*/

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

        $reply_to_name = 'Real World';
        $reply_to_name_arr = @explode('@', $reply_to);
        $reply_to_name = @$reply_to_name_arr[0];

        // Send email
        try{
            Mail::queue('email_template.common', array('body'=>$body), function ($message) use($from_email, $from_name, $to_email, $subject,$file_name,$reply_to, $reply_to_name) {
                $message->from($from_email, $from_name);
                $message->to($to_email);
                $message->subject($subject);
                $message->replyTo($reply_to, $name = $reply_to_name);

                //TODO:: configure attachment in laravel
                if(count($file_name)>0){
                    $size = sizeOf($file_name); //get the count of number of attachments
                    for($i=0; $i< $size; $i++){
                        $message->attach($file_name[$i]);
                    }
                }

            });


            //update sender email count
            $model = SenderEmail::where('email', $from_email)->first();
            $model->count = $model->count +1;
            $model->save();

            return true;

        }catch (\Exception $e){
            #return $e->getMessage();
            return false;
        }
    }

}