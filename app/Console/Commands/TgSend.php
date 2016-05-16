<?php

namespace App\Console\Commands;

use App\Helpers\GmailSendMessage;
use App\SendMailFailed;
use App\TmpGarbage;
use Illuminate\Console\Command;

use App\Helpers\SenderEmailCheck;
use App\CentralSettings;
use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use App\PoppedMessageDetail;
use App\SubMessage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\EmailQueue;
use App\PoppedMessageHeader;
use App\SenderEmail;
use App\Helpers\EmailSend;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\Mailer;


class TgSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tgsend {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tmp Garbage Send';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tg_id = $this->argument('id');

        if(!$tg_id)
            return true;

        #DB::beginTransaction();
        try {
            //email queue data
            $values = TmpGarbage::where('id', $tg_id)
                ->first();

            #foreach($tg_tdata as $values){
            $host = $values->host;
            $port = $values->port;
            $from_email = $values->from_email;
            $from_name = $values->from_name;
            $username = $values->username;
            $password = $values->password;
            $to_email  = $values->to_email;
            $subject = $values->subject;
            $body = $values->body;
            if($values->file_name)
                $file_name = explode(":",$values->file_name);
            else
                $file_name = null;
            $reply_to = $values->reply_to;
            $reply_to_name = $values->reply_to_name;
            $campaign_id = $values->campaign_id;
            $auth_token = $values->auth_token;
            $auth_code = $values->auth_code;
            $popped_message_detail_id = $values->popped_message_detail_id;


            // before firing email check the limit of sending for sender email
            $se_limit_check = GmailSendMessage::limit_check_for_sender_email($from_email, $campaign_id);
            if($se_limit_check != null){
                // fire email
                $start_time = date('Y-m-d H:i:s');
                if($host == "smtp.gmail.com"){

                    // checking valid email
                    $se_email = GmailSendMessage::check_valid_gmail($from_email, $auth_token);

                    if($se_email){

                        if($se_email['status'] == 'valid_existing')
                        {
                            $result = GmailSendMessage::sendMessage($host, $port, $from_email, $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $auth_token, $auth_code, $popped_message_detail_id);
                        }
                        else
                        {
                            $result = GmailSendMessage::sendMessage($host, $port, $se_email['email'], $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $se_email['auth_token'], $auth_code, $popped_message_detail_id);
                        }
                    }else{
                        // This false will send this item to failed mail as no valid sender email
                        $result = false;
                    }

                }else{
                    $result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $popped_message_detail_id);
                }

                $end_time = date('Y-m-d H:i:s');

                print " \n Result :: ". $result . "\n";
                if($result){
                    print " \n IN ";
                    print " \n Delete to Garbage ID :: ". $values->id . "\n";

                    try{
                        $tmp = TmpGarbage::find($values->id);
                        $tmp->delete();
                        echo "Success ! ";
                    }catch(Exception $e){
                        print "\n". $e->getMessage();
                    }

                }else{

                    print "\n Result : false\n";

                    $mailFailed = new SendMailFailed();
                    $mailFailed->host = $host;
                    $mailFailed->port = $port;
                    $mailFailed->sender_email_id = $values->sender_email_id;
                    $mailFailed->campaign_id = $values->campaign_id;
                    $mailFailed->from_email = $from_email;
                    $mailFailed->from_name = $from_name;
                    $mailFailed->username = $username;
                    $mailFailed->password = $password;
                    $mailFailed->to_email = $to_email;

                    $mailFailed->popped_message_header_id = $values->popped_message_header_id;
                    $mailFailed->popped_message_detail_id = $values->popped_message_detail_id;

                    $mailFailed->subject = $subject;
                    $mailFailed->body = $body;
                    if($file_name)
                        $mailFailed->file_name = implode(":", $file_name);

                    $mailFailed->reply_to = $reply_to;
                    $mailFailed->reply_to_name = $reply_to_name;
                    $mailFailed->start_time = $start_time;
                    $mailFailed->end_time = $end_time;
                    $mailFailed->msg = $result;
                    $mailFailed->auth_token = $values->auth_token;
                    $mailFailed->auth_code = $values->auth_code;
                    $mailFailed->save();

                    $tmp = TmpGarbage::find($values->id);
                    $tmp->delete();
                    $end_time = date('Y-m-d H:i:s');
                    print_r($result);
                    print "\n Failed: ".$values->id." Start: ".$start_time." End: ".$end_time."\n";
                }
                #DB::commit();
                print "After Commit\n";
                #}
            }else{
                print "Exceeded Sender Email Limit \n " . $from_name;
            }

        }catch (Exception $ex){
            print "Exception\n";
            #DB::rollback();
        }
    }
}
