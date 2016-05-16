<?php

namespace App\Console\Commands;

use App\Helpers\SenderEmailCheck;
use Illuminate\Console\Command;
use App\CentralSettings;
use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use App\PoppedMessageDetail;
use App\SubMessage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Socialite;

use App\EmailQueue;
use App\PoppedMessageHeader;
use App\SenderEmail;
use App\Helpers\EmailSend;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\TmpGarbage;

class SendEmailQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:emailsend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
     * @return mixed
     */
    public function handle(){
        #$timezone  = +6; //(GMT +6:00)
        #$current_time = gmdate("Y-m-d H:i:s", time() + 3600*($timezone+date("I")));
        $date = date("Y-m-d H:i:s");

        print "Server Time: ".$date."\n";
        //email queue data
        $email_queue_data = EmailQueue::whereNotNull('sub_message_id')
                            ->where('send_time', '<=', $date)
                            ->get();

        $follow_up_msg = DB::table('email_queue')->whereNotNull('followup_sub_message_id')
                        ->where('send_time', '<=', $date)
                        ->get();


        //TODO: sub message sending ...
        if(count($email_queue_data)>0){
            foreach($email_queue_data as $mail_data){

                if($mail_data['reply_to'] != null){
                    DB::beginTransaction();
                    try {
                        // Get Subject
                        $popped_msg_hd = PoppedMessageHeader::where('id', $mail_data->popped_message_header_id)->first();
                        $subject = $popped_msg_hd->subject;
                        $sub_message = SubMessage::with('relSubMessageAttachment')->where('id',$mail_data->sub_message_id)->first();
                        $sub_message_body = $sub_message->description;

                        $file_name = null;
                        if(count($sub_message->relSubMessageAttachment)>0){
                            foreach($sub_message->relSubMessageAttachment as $val)
                            {
                                $file_name []= public_path()."/".$val->file_name;
                            }
                        }else{
                            $file_name = null;
                        }

                        // check string is available or not and set body message
                        $msg_hd_user_name = $popped_msg_hd->user_name;
                        $msg_hd_user_email = $popped_msg_hd->user_email;
                        $new_body = $sub_message_body;

                        if (strpos($sub_message_body,'{name}') !== false)
                        {
                            $new_body = str_replace("{name}", $msg_hd_user_name, $new_body);

                        }

                        if(strpos($sub_message_body,'{fname}') !== false)
                        {
                            $arr = explode(' ',trim($msg_hd_user_name));
                            $fname = $arr[0];
                            $new_body = str_replace("{fname}", $fname, $new_body);
                        }


                        if(strpos($sub_message_body,'{lname}') !== false)
                        {
                            $pieces = explode(' ', $msg_hd_user_name);
                            $lname = array_pop($pieces);
                            $new_body = str_replace("{lname}", $lname ? $lname:'', $new_body);
                        }
                        if(strpos($sub_message_body,'{email}') !== false)
                        {
                            $new_body = str_replace("{email}", $msg_hd_user_email, $new_body);
                        }


                        // Check valid or invalid email
                        if($mail_data->sender_email_id == null){
                            $domain_se_id = $this->alternate_sender_email($mail_data->id, $mail_data->popped_message_header_id, null);
                        }else{
                            $sender_email_checking_setting = CentralSettings::where('title', 'sender-email-checking')->first();

                            if($sender_email_checking_setting->status == 'yes'){
                                $check_email_valid_invalid = SenderEmailCheck::sender_email_checking($mail_data->sender_email_id);

                                if($check_email_valid_invalid){ // if valid
                                    $domain_se_id = $mail_data->sender_email_id;
                                }else{
                                    $domain_se_id = $this->alternate_sender_email($mail_data->id, $mail_data->popped_message_header_id, $mail_data->sender_email_id);
                                }

                            }else{
                                $domain_se_id = $mail_data->sender_email_id;
                            }
                        }

                        //sender email data
                        $sender_email_data = SenderEmail::with('relSmtp')->where('id', '=', $domain_se_id)->first();

                        if(count($sender_email_data)>0){
                            // TODO::  Start Email sending process
                            $host = $sender_email_data->relSmtp->smtp;
                            $port = $sender_email_data->relSmtp->port;
                            $from_email = $sender_email_data->email;
                            $sender_email_id = $sender_email_data->id;
                            $campaign_id = $sender_email_data->campaign_id;
                            $from_name = $sender_email_data->name;
                            $username = $sender_email_data->email;
                            $password = $sender_email_data->password;

                            if (strpos($mail_data->to_email, ' <') !== false) {
                                $split = explode(' <', $mail_data->to_email );
                                $name = $split[0];
                                $email = rtrim($split[1], '>');
                                $to_email = preg_replace('/<>*?/', '', $email); // final email
                            } else {
                                $to_email = $mail_data->to_email;
                            }
                            $subject = "RE: ".$subject;
                            $body = $new_body;
                            $reply_to = $mail_data->reply_to;

                            $reply_to_email_data = SenderEmail::where('email', '=', $reply_to)->first();


                            $reply_to_name = $reply_to_email_data->name;
                            $token = $sender_email_data->auth_token;
                            $code = $sender_email_data->auth_code;


                            // fire email
                            #$result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to);

                            $tmp_gbg_model = new TmpGarbage();
                            $tmp_gbg_model->host = $host;
                            $tmp_gbg_model->port = $port;
                            $tmp_gbg_model->sender_email_id = $sender_email_id;

                            // add newly submessage and followup id for union among email_queue and tmp_grabage table
                            $tmp_gbg_model->sub_message_id = isset($mail_data->sub_message_id) ? $mail_data->sub_message_id : null ;
                            $tmp_gbg_model->followup_sub_message_id = isset($mail_data->followup_sub_message_id)?$mail_data->followup_sub_message_id: null;

                            $tmp_gbg_model->popped_message_header_id = $mail_data->popped_message_header_id;
                            $tmp_gbg_model->campaign_id = $campaign_id;
                            $tmp_gbg_model->from_email = $from_email;
                            $tmp_gbg_model->from_name = $from_name;
                            $tmp_gbg_model->username = $username;
                            $tmp_gbg_model->password = $password;
                            $tmp_gbg_model->to_email = $to_email;
                            $tmp_gbg_model->subject = $subject;
                            $tmp_gbg_model->body = $body;
                            if($file_name)
                                $tmp_gbg_model->file_name = implode(":", $file_name);
                            $tmp_gbg_model->reply_to = $reply_to;
                            $tmp_gbg_model->reply_to_name = $reply_to_name;
                            $tmp_gbg_model->auth_token = $token;
                            $tmp_gbg_model->auth_code = $code;



                            // TODO:  End Email sending process
                            if($tmp_gbg_model->save()){
                                // Store into Detail table
                                $model = new PoppedMessageDetail();
                                $model->popped_message_header_id = $mail_data->popped_message_header_id;

                                $model->sub_message_id = isset($mail_data->sub_message_id) ? $mail_data->sub_message_id : null ;
                                $model->followup_sub_message_id = isset($mail_data->followup_sub_message_id)?$mail_data->followup_sub_message_id: null;

                                $model->sender_email = $sender_email_data->email;
                                $model->sent_time = date('Y-m-d H:i:s');
                                $model->d_status = null; //'mail-sent';
                                $model->save() ;
                                $tmg_gbg_update = TmpGarbage::findOrFail($tmp_gbg_model->id);
                                $tmg_gbg_update->popped_message_detail_id = $model->id;
                                $tmg_gbg_update->save();

                                // Update count to sender_email
                                /*$sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                                $sender_email_update_data['count'] = $sender_email_data->count + 1;
                                $sender_email_update->fill($sender_email_update_data)->save();*/
                                #DB::table('sender_email')->where('id','=', $sender_email_data->id)->increment('count', 1);

                                // Delete from Email Queue
                                $model_lt = EmailQueue::find($mail_data->id);
                                $model_lt->delete();
                            }
                        }

                        DB::commit();
                        print "Sent Successfully !\n";


                    }catch (Exception $ex){
                        DB::rollback();
                    }
                }else{
                    print "Reply_To Email is not found. Means there is no domain sender email in the sender_email table in this campaign. !\n";
                }

            }
        }


        //TODO: Folow up Messages sending ... ... ...
        if(count($follow_up_msg)>0)
        {

            foreach($follow_up_msg as $mail_data){
                DB::beginTransaction();
                try {
                    // get followup sub message
                    $followup_sub_message = FollowupSubMessage::with('relFollowupSubMessageAttachment')
                        ->where('id',$mail_data->followup_sub_message_id)->first();
                    // Get Subject
                    $popped_msg_hd = PoppedMessageHeader::where('id', $mail_data->popped_message_header_id)->first();
                    $subject = $popped_msg_hd->subject;

                    if($followup_sub_message){
                        $followup_sub_message_body = $followup_sub_message->description;
                        #$subject_of_foll_msg = mb_substr($followup_sub_message->description, 0, 100);

                        $file_name = null;
                        if(count($followup_sub_message->relFollowupSubMessageAttachment)>0){
                            foreach($followup_sub_message->relFollowupSubMessageAttachment as $val)
                            {
                                $file_name []= public_path()."/".$val->file_name;
                            }
                        }else{
                            $file_name = null;
                        }
                        // check string is available or not and set body message
                        $msg_hd_user_name = $popped_msg_hd->user_name;
                        $new_body = $followup_sub_message_body;
                        if (strpos($followup_sub_message_body,'{name}') !== false)
                        {
                            $new_body = str_replace("{name}", $msg_hd_user_name, $new_body);
                        }
                        if(strpos($followup_sub_message_body,'{fname}') !== false)
                        {
                            $arr = explode(' ',trim($msg_hd_user_name));
                            $fname = $arr[0];
                            $new_body = str_replace("{fname}", $fname, $new_body);

                        }
                        if(strpos($followup_sub_message_body,'{lname}') !== false)
                        {
                            $pieces = explode(' ', $msg_hd_user_name);
                            $lname = array_pop($pieces);
                            $new_body = str_replace("{lname}", $lname?$lname:'', $new_body);
                        }
                        if(strpos($followup_sub_message_body,'{email}') !== false)
                        {
                            $new_body = str_replace("{email}", $msg_hd_user_name, $new_body);
                        }



                        // Check valid or invalid email
                        if($mail_data->sender_email_id){
                            $sender_email_checking_setting = CentralSettings::where('title', 'sender-email-checking')->first();
                            if($sender_email_checking_setting->status == 'yes'){

                                $check_email_valid_invalid = SenderEmailCheck::sender_email_checking($mail_data->sender_email_id);

                                if($check_email_valid_invalid){ // if valid
                                    $domain_se_id = $mail_data->sender_email_id;
                                }else{
                                    $domain_se_id = $this->alternate_sender_email($mail_data->id, $mail_data->popped_message_header_id, $mail_data->sender_email_id);
                                }
                            }else{
                                $domain_se_id = $mail_data->sender_email_id;
                            }
                        }else{
                            $domain_se_id = $this->alternate_sender_email($mail_data->id, $mail_data->popped_message_header_id, null);
                        }


                        //sender email data
                        $sender_email_data = SenderEmail::with('relSmtp')->where('id', '=', $domain_se_id)->first();

                        if(count($sender_email_data)> 0){
                            // Start Email sending process
                            $host=$sender_email_data->relSmtp->smtp;
                            $port=$sender_email_data->relSmtp->port;
                            $from_email=$sender_email_data->email;
                            $sender_email_id=$sender_email_data->id;
                            $campaign_id=$sender_email_data->campaign_id;
                            $from_name=$sender_email_data->name;
                            $username=$sender_email_data->email;
                            $password= $sender_email_data->password;
                            if (strpos($mail_data->to_email, ' <') !== false) {
                                $split = explode(' <', $mail_data->to_email );
                                $name = $split[0];
                                $email = rtrim($split[1], '>');
                                $to_email = preg_replace('/<>*?/', '', $email); // final email
                            } else {
                                $to_email = $mail_data->to_email;
                            }
                            $subject="RE: ".$subject;
                            $body=$new_body;
                            $reply_to= $mail_data->reply_to;

                            // fire email
                            #$result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to);

                            $tmp_gbg_model = new TmpGarbage();
                            $tmp_gbg_model->host = $host;
                            $tmp_gbg_model->port = $port;
                            $tmp_gbg_model->sender_email_id = $sender_email_id;

                            // add newly submessage and followup id for union among email_queue and tmp_grabage table
                            $tmp_gbg_model->sub_message_id = isset($mail_data->sub_message_id) ? $mail_data->sub_message_id : null ;
                            $tmp_gbg_model->followup_sub_message_id = isset($mail_data->followup_sub_message_id)?$mail_data->followup_sub_message_id: null;

                            $tmp_gbg_model->popped_message_header_id = $mail_data->popped_message_header_id;
                            $tmp_gbg_model->campaign_id = $campaign_id;
                            $tmp_gbg_model->from_email = $from_email;
                            $tmp_gbg_model->from_name = $from_name;
                            $tmp_gbg_model->username = $username;
                            $tmp_gbg_model->password = $password;
                            $tmp_gbg_model->to_email = $to_email;
                            $tmp_gbg_model->subject = $subject;
                            $tmp_gbg_model->body = $body;
                            if($file_name)
                                $tmp_gbg_model->file_name = implode(":", $file_name);
                            $tmp_gbg_model->reply_to = $reply_to;

                            // End Email sending process
                            if($tmp_gbg_model->save()){
                                // Store into Detail table
                                $model = new PoppedMessageDetail();
                                $model->popped_message_header_id = $mail_data->popped_message_header_id;
                                $model->sub_message_id = isset($mail_data->sub_message_id) ? $mail_data->sub_message_id : null ;
                                $model->followup_sub_message_id = isset($mail_data->followup_sub_message_id)?$mail_data->followup_sub_message_id: null;
                                $model->sender_email = $sender_email_data->email;
                                $model->sent_time = date('Y-m-d H:i:s');
                                $model->d_status = null; //'mail-sent';
                                $model->save();
                                $tmg_gbg_update = TmpGarbage::findOrFail($tmp_gbg_model->id);
                                $tmg_gbg_update->popped_message_detail_id = $model->id;
                                $tmg_gbg_update->save();
                                //update sender email count
                                /*$sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                                $sender_email_update_data['count'] = $sender_email_data->count +1;
                                $sender_email_update->fill($sender_email_update_data)->save();*/

                                // Delete from Email Queue
                                $model_lt = EmailQueue::find($mail_data->id);
                                $model_lt->delete();
                            }
                        }
                    }
                DB::commit();
                #echo "Sent Successfully ! ";
                }catch (Exception $ex){
                    DB::rollback();
                }
            }
        }

        echo "-- end of this method ! -- ";
        // TODO:: return
        return true;
    }

    /**
     * @param $email_queue_id
     * @param $sender_email_id
     * @param $popped_message_header_id
     * @return mixed
     */
    private function alternate_sender_email($email_queue_id, $popped_message_header_id, $sender_email_id = null){
        $hd = PoppedMessageHeader::findOrNew($popped_message_header_id);

        if($sender_email_id){
            $se_email_address= SenderEmail::findOrNew($sender_email_id);
            if($se_email_address->status=='public' || $se_email_address->status=='invalid'){
                $domain_se = DB::table('sender_email')
                    ->where('campaign_id', $hd->campaign_id)
                    ->where('status', 'public')
                    ->orderBy('count', 'asc')
                    ->orderByRaw("RAND()")
                    ->first();
            }elseif($se_email_address->status=='domain'){
                $domain_se = DB::table('sender_email')
                    ->where('campaign_id', $hd->campaign_id)
                    ->where('status', 'domain')
                    ->orderBy('count', 'asc')
                    ->orderByRaw(DB::raw("FIELD(popping_status, false, true)"))
                    ->first();
            }
        }else{
            if($hd->message_order == 1){
                $domain_se = DB::table('sender_email')
                    ->where('campaign_id', $hd->campaign_id)
                    ->where('status', 'public')
                    ->orderBy('count', 'asc')
                    ->orderByRaw("RAND()")
                    ->first();
            }else{
                $domain_se = DB::table('sender_email')
                    ->where('campaign_id', $hd->campaign_id)
                    ->where('status', 'domain')
                    ->orderBy('count', 'asc')
                    ->orderByRaw(DB::raw("FIELD(popping_status, false, true)"))
                    ->first();
            }

        }

        $domain_se_id = $domain_se->id;

        DB::beginTransaction();
        try{
            // Update the sender email status
            if($domain_se->status == 'domain') {
                DB::table('popped_message_header')->where('id', $popped_message_header_id)->update(['sender_email_id' => $domain_se_id]);
                DB::table('sender_email')->where('id', $domain_se->id)->update(['popping_status' => 'true']);
            }

            DB::table('email_queue')->where('id', $email_queue_id)->update(['sender_email_id' => $domain_se_id]);
            DB::commit();

        }catch (Exception $ex){
            DB::rollback();
        }

        //return
        return $domain_se_id;
    }
}
