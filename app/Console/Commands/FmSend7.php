<?php

namespace App\Console\Commands;

use App\SendMailFailed;
use App\Smtp;
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

class FmSend7 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fmsend7';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Failed Email Send 7';

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
        $start_time0 = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {

            //email queue data
            $fm_data = SendMailFailed::orderBy('no_of_try', 'ASC')
                ->orderBy('id', 'ASC')
                ->skip(6)
                ->take(1)
                ->get();
            sleep(18);

            print "After Query: ".date('Y-m-d H:i:s')."\n";
            foreach($fm_data as $values){
                print "Enter to loop: ".date('Y-m-d H:i:s')."\n";

                $se = SenderEmail::with('relSmtp')
                    ->where('id', $values->sender_email_id)
                    ->first();

                $tmp = SendMailFailed::find($values->id);
                print "Old SE : ".$values->id."\n";
                print "Header : ".$values->popped_message_header_id."\n";
                print "Detail : ".$values->popped_message_detail_id."\n";

                if($se){
                    $status = $se->status;
                }else{
                    // As Sender email is removed any how
                    $status = SenderEmailCheck::EmailTypeIdentification($values->from_email, 'status');
                    if($status != 'domain')
                        $status = 'public';
                }

                if($status == 'public' && $values->no_of_try >= 2){
                    $cur_se = SenderEmailCheck::get_sender_email_public($values->campaign_id);
                    print "New SE : ".$cur_se->id."\n";
                    $smtp = Smtp::where('id', $cur_se->smtp_id)->first();
                    $host = $smtp->host;
                    $port = $smtp->port;
                    $from_email = $cur_se->email;
                    $from_name = $cur_se->name;
                    $username = $cur_se->email;
                    $password = $cur_se->password;

                    //Update Failed mail table
                    $tmp->host = $smtp->host;
                    $tmp->port = $smtp->port;
                    $tmp->from_email =  $cur_se->email;
                    $tmp->from_name = $cur_se->name;
                    $tmp->username = $cur_se->email;
                    $tmp->password = $cur_se->password;
                    $tmp->no_of_try = 1;

                    // TODO Update message details
                    $detail = PoppedMessageDetail::where('id', $values->popped_message_detail_id)->first();
                    $detail->sender_email = $cur_se->email;
                    $detail->save();

                }elseif($status == 'domain' && $values->no_of_try >= 5){
                    $cur_se = SenderEmailCheck::get_sender_email_domain($values->campaign_id);
                    print "New SE : ".$cur_se->id."\n";
                    $smtp = Smtp::where('id', $cur_se->smtp_id)->first();
                    $host = $smtp->host;
                    $port = $smtp->port;
                    $from_email = $cur_se->email;
                    $from_name = $cur_se->name;
                    $username = $cur_se->email;
                    $password = $cur_se->password;

                    //Update Failed mail table
                    $tmp->host = $smtp->host;
                    $tmp->port = $smtp->port;
                    $tmp->from_email =  $cur_se->email;
                    $tmp->from_name = $cur_se->name;
                    $tmp->username = $cur_se->email;
                    $tmp->password = $cur_se->password;
                    $tmp->no_of_try = 1;

                    // TODO update header
                    $header = PoppedMessageHeader::where('id', $values->popped_message_header_id)->first();
                    $header->sender_email_id = $cur_se->id;
                    $header->save();
                }else{
                    $host = $values->host;
                    $port = $values->port;
                    $from_email = $values->from_email;
                    $from_name = $values->from_name;
                    $username = $values->username;
                    $password = $values->password;
                    $tmp->no_of_try = $tmp->no_of_try + 1;
                }

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
                $auth_token = $values->auth_token ;
                $auth_code = $values->auth_code;
                $popped_message_detail_id = $values->popped_message_detail_id;


                // fire email
                $start_time = date('Y-m-d H:i:s');
                print "Before call of Email function : ".date('Y-m-d H:i:s')."\n";

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

                print "After call of Email function : ".date('Y-m-d H:i:s')."\n";
                $end_time = date('Y-m-d H:i:s');

                if($result){
                    $tmp = SendMailFailed::findOrFail($values->id);
                    $tmp->delete();
                    echo "Success ! ";
                }else{
                    //Update failed message and add a new filed of try
                    #$tmp = SendMailFailed::find($values->id);
                    #$tmp->no_of_try = $tmp->no_of_try + 1;
                    $tmp->msg = $result;
                    $tmp->save();
                    print "Failed ! -> Entry time : ".$start_time0." Start Time: ".$start_time."-> End Time: ".$end_time." Error: ".$result."\n";
                }
                DB::commit();
            }

        }catch (Exception $ex){
            DB::rollback();
        }

    }
}
