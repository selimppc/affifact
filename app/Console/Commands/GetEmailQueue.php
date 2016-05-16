<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\PoppedMessageHeader;
use App\SenderEmail;
use App\PoppingEmail;
use App\Campaign;
use Illuminate\Support\Facades\DB;
use App\EmailQueue;

use App\CentralSettings;
use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use App\Message;
use App\PoppedMessageDetail;
use App\Smtp;
use App\SubMessage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendReminderEmail;
use Illuminate\Bus\Queueable;

use App\Helpers\Xmlapi;
use App\FollowupMessage;

class GetEmailQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:emailqueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Queue for Popped and Queue.';

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

        $start_time = date('Y-m-d H:i:s');

        /*  email_queue_process   from EmailQueueController */
        $pause_system = CentralSettings::where('title','=', 'is-paused')->first();
        $popped_message_header = DB::table('popped_message_header as pmh')
            ->join('campaign as camp', function ($join) {
                $join->on('pmh.campaign_id', '=', 'camp.id');
                    #->where('campaign.status', '=', 'active');
            })
            ->where('pmh.status', '=', 'not-queued')
            ->where('camp.status', '=', 'active')
            ->select('pmh.*')
            ->get();


        if(count($popped_message_header)>0){

            foreach ($popped_message_header as $pmhd) {

                if($pmhd->message_order == 1 && $pmhd->status =="not-queued"){

                    $sender_email_domain = null;
                    $first_msg_no = CentralSettings::where('title','=', 'how-many-msg-for-new-email')->first();

                    $msg_data = (object) DB::table('message as msg')
                        ->join('sub_message as sub_msg', function ($join) {
                            $join->on('sub_msg.message_id', '=', 'msg.id');
                        })
                        ->where('sub_msg.start_time', '<', date('Y-m-d H:i:s'))
                        ->where('sub_msg.end_time', '>', date('Y-m-d H:i:s'))
                        ->where('msg.campaign_id', $pmhd->campaign_id)
                        ->orderBy('msg.order', 'asc')
                        ->take($first_msg_no? $first_msg_no->status: 1)
                        ->select(DB::raw('msg.delay as message_delay, sub_msg.id as sub_message_id'))
                        ->get();

                    $first_email_sent_by_public_or_domain = CentralSettings::where('title','=', 'first-mail-send-by-public-or-domain')->first();

                    if($first_email_sent_by_public_or_domain->status == 'public'){
                        $sender_email_public = $this->get_sender_email_public($pmhd->campaign_id);
                    }else{
                        $sender_email_public = null;
                    }
                    $sender_email_domain = $this->get_sender_email_domain($pmhd->campaign_id);


                    if($sender_email_domain !=null){

                        // Message Data
                        if(count($msg_data) > 0){
                            $count_multiple_message_for_new_email = 0;
                            $count = 0;

                            foreach($msg_data as $val){
                                DB::beginTransaction();
                                try {
                                    $model = new EmailQueue();
                                    $model->popped_message_header_id = $pmhd->id;
                                    $model->sub_message_id = $val->sub_message_id;
                                    $model->send_time = date("Y-m-d H:i:s", time() + ($val->message_delay * 60 + $count));

                                    // Assgin sender_email_id by domain email and later check if $count_multiple_message_for_new_email = 0 and
                                    // $first_email_sent_by_public_or_domain is public then change to public
                                    $model->sender_email_id = @$sender_email_domain->id;
                                    if($count_multiple_message_for_new_email == 0){
                                        if(strtolower($first_email_sent_by_public_or_domain->status) == 'public'){
                                            $model->sender_email_id = @$sender_email_public->id;
                                        }
                                    }
                                    $model->reply_to = @$sender_email_domain->email;
                                    $model->to_email = @$pmhd->user_email;
                                    //save
                                    if ($model->save()) {
                                        // update status as queued after queue process
                                        DB::table('popped_message_header')->where('id', $pmhd->id)->update(['status' => 'queued', 'sender_email_id' => @$sender_email_domain->id]);

                                        // Set popping status true for domain email
                                        DB::table('sender_email')->where('id', @$sender_email_domain->id)->update(['popping_status' => 'true']);
                                        //Commit
                                        DB::commit();
                                    }
                                    $count = $count + $val->message_delay;

                                    //Is set to 0 because the client wants to send first number of emails from same public email
                                    //$count_multiple_message_for_new_email++;
                                    $count_multiple_message_for_new_email = 0;

                                    print "Queued Successfully !\n";



                                }catch (Exception $ex){
                                    DB::rollback();
                                }
                            }

                            // Line no 157
                            // update message order(how-many-msg-for-new-email) into popped message header  according to $first_msg_no = message_order
                            // update column message_order = $first_msg_no
                            DB::table('popped_message_header')->where('id', $pmhd->id)->update(['message_order' => $first_msg_no->status]);


                        }

                        $foll_data = FollowupMessage::with(['relFollowupSubMessage' => function($query){
                            $query->where('start_time', '<', date('Y-m-d H:i:s'))
                                ->where('end_time', '>', date('Y-m-d H:i:s'));
                        }])
                            ->where('campaign_id', @$pmhd->campaign_id)
                            ->orderBy('order', 'asc')
                            ->get();

                        if(count($foll_data) > 0){
                            // Make delay to first message only
                            $counter = 300;
                            foreach($foll_data as $val){
                                DB::beginTransaction();
                                try {
                                    $model = new EmailQueue();
                                    $model->popped_message_header_id = @$pmhd->id;
                                    if(count(@$val->relFollowupSubMessage)){
                                        $model->followup_sub_message_id = @$val->relFollowupSubMessage[0]->id;
                                    }

                                    $model->send_time = date("Y-m-d H:i:s", time() + ($val->delay * 60 + $counter));
                                    $model->sender_email_id = @$sender_email_domain->id;
                                    $model->reply_to = @$sender_email_domain->email;
                                    $model->to_email = @$pmhd->user_email;


                                    if($model->save()){

                                        // update status as queued after queue process
                                        DB::table('popped_message_header')->where('id', $pmhd->id)->update(['status' => 'queued']);
                                    }
                                    $counter = $counter + $val->delay;

                                    //Commit
                                    DB::commit();
                                    print "Queued Successfully !\n";
                                }catch (Exception $ex){
                                    DB::rollback();
                                }
                            }
                        }
                        print "Success\n";
                    }else{
                        print "No Sender Email found in this campaign. \n";
                    }


                }elseif($pmhd->message_order != 0){
                    // message order 2 and pause = yes then second email will fire automatically
                    // changes :: message_order > 1 :: fire email if replied with,  after the number of messages
                    // ref:: $first_msg_no = CentralSettings::where('title','=', 'how-many-msg-for-new-email')->first();
                    if( ($pause_system->status != 'yes') || ($pmhd->message_order > 1 && $pmhd->status =="not-queued" && $pause_system->status == 'yes')){

                        // Count Message order if exists or not
                        $message_order_count = Message::where('campaign_id', $pmhd->campaign_id)->orderBy('order', 'desc')->first();
                        $msg_order_count = $message_order_count->order;

                        // set message order
                        if($msg_order_count >= $pmhd->message_order){
                            $message_order = $pmhd->message_order;

                            // Get message and sub message data
                            $msg_data = (object) DB::table('message as msg')
                                ->join('sub_message as sub_msg', function ($join) {
                                    $join->on('sub_msg.message_id', '=', 'msg.id');
                                })
                                ->where('sub_msg.start_time', '<', date('Y-m-d H:i:s'))
                                ->where('sub_msg.end_time', '>', date('Y-m-d H:i:s'))
                                ->where('msg.campaign_id', $pmhd->campaign_id)
                                ->where('msg.order', $message_order)
                                ->select(DB::raw('msg.delay as message_delay, sub_msg.id as sub_message_id'))
                                ->get();


                            if(count($msg_data)> 0){
                                foreach($msg_data as $val){
                                    if($pmhd->sender_email_id){
                                        $se = SenderEmail::findOrNew($pmhd->sender_email_id);
                                    }else{
                                        $se = $this->get_sender_email_domain($pmhd->campaign_id);
                                    }

                                    DB::beginTransaction();
                                    try {
                                        //Model Instance
                                        $model = new EmailQueue();
                                        $model->popped_message_header_id = $pmhd->id;
                                        $model->sub_message_id = $val->sub_message_id ;
                                        $model->send_time = date("Y-m-d H:i:s", time() + ($val->message_delay * 60));
                                        $model->sender_email_id = $se->id;
                                        $model->reply_to = $se->email;
                                        $model->to_email = $pmhd->user_email;

                                        if($model->save()){
                                            // update status as queued after queue process
                                            DB::table('popped_message_header')->where('id', $pmhd->id)->update(['status' => 'queued', 'sender_email_id'=>$se->id ]);
                                        }

                                        //Commit
                                        DB::commit();
                                        print "Queued Successfully !\n";
                                    }catch (Exception $ex){
                                        DB::rollback();
                                    }
                                }
                            }
                            print "Success\n";
                        }
                    }
                }
            }
        }else{
            print "No data\n";
        }

        $end_time = date('Y-m-d H:i:s');
        print "Start time: ". $start_time." End time : ".$end_time."\n";
        return true;
    }

    // Get Sender email according to count < mails_per_day_per_email
    protected function get_sender_email_public($camp_id){

        $se_email = SenderEmail::where('campaign_id', $camp_id)
            // ->where('status', 'domain')
            ->havingRaw('count < max_email_send')
            ->where('status', 'public')
            ->orderBy('count', 'asc')
            ->orderByRaw("RAND()")
            ->first();
        return $se_email;
    }

    // Get Sender email according to count < mails_per_day_per_email
    protected function get_sender_email_domain($camp_id){

        $se_email = SenderEmail::where('campaign_id', $camp_id)
            // ->where('status', 'domain')
            ->havingRaw('count < max_email_send')
            ->where('status', 'domain')
            ->orderByRaw(DB::raw("FIELD(popping_status, false, true)"))
            ->orderBy('count', 'ASC')
            ->orderByRaw("RAND()")
            ->first();
        return $se_email;
    }
}
