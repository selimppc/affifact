<?php

namespace App\Console\Commands;

#use app\Helpers\MailQueueJobs;
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
use App\Helpers\MailQueueJobs;


class SendEmailQueueToJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:sendemailqueuetojobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email Data into JOBS';

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
        /* bulk_mail_queue_reply  from EmailQueueController  */

        $timezone  = +6; //(GMT +6:00)
        $current_time = gmdate("Y-m-d H:i:s", time() + 3600*($timezone+date("I")));
        $date = date("Y-m-d H:i:s");


        //email queue data
        $email_queue_data = EmailQueue::whereNotNull('sub_message_id')
            ->where('send_time', '<=', $date)->get();

        $follow_up_msg = DB::table('email_queue')->whereNotNull('followup_sub_message_id')
            ->where('send_time', '<=', $date)->get();

        //TODO: sub message sending ...
        if(count($email_queue_data)>0)
        {
            foreach($email_queue_data as $mail_data)
            {
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
                    $user_name = PoppedMessageHeader::where('id', $mail_data->popped_message_header_id)->first();
                    if (strpos($sub_message_body,'{name}') !== false)
                    {
                        $new_body = str_replace("{name}", $user_name->user_name, $sub_message_body);
                    }
                    elseif(strpos($sub_message_body,'{fname}') !== false)
                    {
                        $arr = explode(' ',trim($user_name->user_name));
                        $fname = $arr[0];
                        $new_body = str_replace("{fname}", $fname, $sub_message_body);
                    }
                    elseif(strpos($sub_message_body,'{lname}') !== false)
                    {
                        $pieces = explode(' ', $user_name->user_name);
                        $lname = array_pop($pieces);
                        $new_body = str_replace("{lname}", $lname?$lname:'', $sub_message_body);
                    }
                    elseif(strpos($sub_message_body,'{email}') !== false)
                    {
                        $new_body = str_replace("{email}", $user_name->user_email, $sub_message_body);
                    }
                    else
                    {
                        $new_body = $sub_message_body;
                    }

                    // Check valid or invalid email
                    $check_email_valid_invalid = SenderEmailCheck::sender_email_checking($mail_data->sender_email_id);
                    if($check_email_valid_invalid){ // if valid
                        $domain_se_id = $mail_data->sender_email_id;
                    }else{
                        $se_email_address= SenderEmail::findOrNew($mail_data->sender_email_id);
                        $camp_id = PoppedMessageHeader::findOrNew($mail_data->popped_message_header_id)->campaign_id;

                        if($se_email_address->status=='public' || $se_email_address->status=='invalid'){
                            $domain_se = DB::table('sender_email')
                                ->where('campaign_id', $camp_id)
                                ->where('status', 'public')
                                ->orderBy('count', 'asc')
                                ->first();
                        }elseif($se_email_address->status=='domain'){
                            $domain_se = DB::table('sender_email')
                                ->where('campaign_id', $camp_id)
                                ->where('status', 'domain')
                                ->orderBy('count', 'asc')
                                ->first();
                        }
                        $domain_se_id = $domain_se->id;
                        // Update the sender email status
                        DB::table('popped_message_header')->where('id', $mail_data->popped_message_header_id)->update(['sender_email_id' => $domain_se_id]);
                        DB::table('email_queue')->where('id', $mail_data->id)->update(['sender_email_id' => $domain_se_id]);
                    }

                    //sender email data
                    $sender_email_data = SenderEmail::with('relSmtp')->where('id', '=', $domain_se_id)->first();

                    if(count($sender_email_data)>0){
                        // TODO::  Start Email sending process
                        $host=$sender_email_data->relSmtp->smtp;
                        $port=$sender_email_data->relSmtp->port;
                        $from_email=$sender_email_data->email;
                        $from_name=$sender_email_data->name;
                        $username=$sender_email_data->email;
                        $password=$sender_email_data->password;

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
                        $reply_to=$mail_data->reply_to;

                        // fire email
                        $result = MailQueueJobs::mail_jobs($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to);

                        // TODO:  End Email sending process
                        if($result){
                            // Store into Detail table
                            $model = new PoppedMessageDetail();
                            $model->popped_message_header_id = $mail_data->popped_message_header_id;
                            $model->sub_message_id = $mail_data->sub_message_id;
                            $model->followup_sub_message_id = $mail_data->followup_sub_message_id;
                            $model->sender_email = $sender_email_data->email;
                            $model->sent_time = date('Y-m-d H:i:s');
                            $model->d_status = 'mail-sent';
                            $model->save() ;

                            //update sender email count
                            $sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                            $sender_email_update_data['count'] = $sender_email_data->count +1;
                            $sender_email_update->fill($sender_email_update_data)->save();

                            // Delete from Email Queue
                            $model_lt = EmailQueue::find($mail_data->id);
                            $model_lt->delete();
                        }
                    }

                    DB::commit();
                    echo "Sent Successfully ! ";
                }catch (Exception $ex){
                    DB::rollback();
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
                        $subject_of_foll_msg = mb_substr($followup_sub_message->description, 0, 100);

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
                        $user_name = PoppedMessageHeader::where('id', $mail_data->popped_message_header_id)->first();
                        if (strpos($followup_sub_message_body,'{name}') !== false)
                        {
                            $new_body = str_replace("{name}", $user_name->user_name, $followup_sub_message_body);
                        }
                        elseif(strpos($followup_sub_message_body,'{fname}') !== false)
                        {
                            $arr = explode(' ',trim($user_name->user_name));
                            $fname = $arr[0];
                            $new_body = str_replace("{fname}", $fname, $followup_sub_message_body);

                        }
                        elseif(strpos($followup_sub_message_body,'{lname}') !== false)
                        {
                            $pieces = explode(' ', $user_name->user_name);
                            $lname = array_pop($pieces);
                            $new_body = str_replace("{lname}", $lname?$lname:'', $followup_sub_message_body);
                        }
                        elseif(strpos($followup_sub_message_body,'{email}') !== false)
                        {
                            $new_body = str_replace("{email}", $user_name->user_email, $followup_sub_message_body);
                        }
                        else
                        {
                            $new_body = $followup_sub_message_body;
                        }

                        $foll_sub_att_id = FollowupSubMessageAttachment::where('followup_sub_message_id', '=', $followup_sub_message->id)->first();

                        // Check Valid or invalid Email
                        $check_email_valid_invalid = SenderEmailCheck::sender_email_checking($mail_data->sender_email_id);
                        if($check_email_valid_invalid){ //if Valid
                            $domain_se_id = $mail_data->sender_email_id;
                        }else{
                            $se_email_address= SenderEmail::findOrNew($mail_data->sender_email_id);
                            $camp_id = PoppedMessageHeader::findOrNew($mail_data->popped_message_header_id)->campaign_id;
                            if($se_email_address->status=='public' || $se_email_address->status=='invalid'){
                                $domain_se = DB::table('sender_email')
                                    ->where('campaign_id', $camp_id)
                                    ->where('status', 'public')
                                    ->orderBy('count', 'asc')
                                    ->first();

                            }elseif($se_email_address->status=='domain'){
                                $domain_se = DB::table('sender_email')
                                    ->where('campaign_id', $camp_id)
                                    ->where('status', 'domain')
                                    ->orderBy('count', 'asc')
                                    ->first();

                            }
                            $domain_se_id = $domain_se->id;
                            // Update the sender email status
                            DB::table('popped_message_header')->where('id', $mail_data->popped_message_header_id)->update(['sender_email_id' => $domain_se_id]);
                            DB::table('email_queue')->where('id', $mail_data->id)->update(['sender_email_id' => $domain_se_id]);
                        }

                        //sender email data
                        $sender_email_data = SenderEmail::with('relSmtp')->where('id', '=', $domain_se_id)->first();

                        if(count($sender_email_data)> 0){
                            // Start Email sending process
                            $host=$sender_email_data->relSmtp->smtp;
                            $port=$sender_email_data->relSmtp->port;
                            $from_email=$sender_email_data->email;
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
                            $result = MailQueueJobs::mail_jobs($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to);
                            // End Email sending process
                            if($result){
                                // Store into Detail table
                                $model = new PoppedMessageDetail();
                                $model->popped_message_header_id = $mail_data->popped_message_header_id;
                                $model->sub_message_id = $mail_data->sub_message_id;
                                $model->followup_sub_message_id = $mail_data->followup_sub_message_id;
                                $model->sender_email = $sender_email_data->email;
                                $model->sent_time = date('Y-m-d H:i:s');
                                $model->d_status = 'mail-sent';
                                $model->save();
                                //update sender email count
                                $sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                                $sender_email_update_data['count'] = $sender_email_data->count +1;
                                $sender_email_update->fill($sender_email_update_data)->save();

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

        echo "Sent Successfully ! ";
        // TODO:: return
        return true;

    }
}
