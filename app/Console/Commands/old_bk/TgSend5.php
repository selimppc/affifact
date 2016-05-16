<?php

namespace App\Console\Commands;

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
use App\Helpers\GmailSendMessage;


class TgSend5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:tgsend5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tmp Garbage Send 5';

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
        DB::beginTransaction();
        try {

            //email queue data
            $tg_tdata = TmpGarbage::orderBy('id', 'ASC')
                ->skip(40)
                ->take(10)
                ->get();

            foreach($tg_tdata as $values){

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


                // fire email
                $start_time = date('Y-m-d H:i:s');

                if($host == "smtp.gmail.com"){
                    // checking valid email
                    $se_email = GmailSendMessage::check_valid_gmail($from_email, $auth_token);
                    if($se_email){
                        if($se_email['status'] == 'valid_existing')
                            $result = GmailSendMessage::sendMessage($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $auth_token, $auth_code, $popped_message_detail_id);
                        else {
                            $result = GmailSendMessage::sendMessage($host, $port, $se_email['email'], $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $se_email['auth_token'], $auth_code, $popped_message_detail_id);
                            /*if($result){
                                $pmd = PoppedMessageDetail::find($values->popped_message_detail_id);
                                $pmd->sender_email = $se_email['email'];
                                $pmd->save();
                            }*/
                        }
                    }else{
                        // This false will send this item to failed mail as no valid sender email
                        $result = false;
                    }

                }else{
                    $result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $popped_message_detail_id);
                }

                $end_time = date('Y-m-d H:i:s');

                if($result){
                    $tmp = TmpGarbage::find($values->id);
                    $tmp->delete();
                    echo "Success ! ";
                }else{

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
                    $mailFailed->subject = $subject;
                    $mailFailed->body = $body;
                    if($file_name)
                        $mailFailed->file_name = implode(":", $file_name);

                    $mailFailed->reply_to = $reply_to;
                    $mailFailed->start_time = $start_time;
                    $mailFailed->end_time = $end_time;
                    $mailFailed->msg = $result;
                    $mailFailed->auth_token = $values->auth_token;
                    $mailFailed->auth_code = $values->auth_code;
                    $mailFailed->save();

                    $tmp = TmpGarbage::find($values->id);
                    $tmp->delete();
                    echo "Failed ! ";
                }
                DB::commit();
            }

        }catch (Exception $ex){
            DB::rollback();
        }

    }
}
