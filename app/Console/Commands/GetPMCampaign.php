<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;

use App\PoppedMessageHeader;
use App\PoppingEmail;
use App\Campaign;
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
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendReminderEmail;
use Illuminate\Bus\Queueable;

use App\EmailQueue;
use App\SenderEmail;
use Illuminate\Support\Facades\DB;
use App\Helpers\Xmlapi;
use App\FollowupMessage;


use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use Google_Service_Books;
use Google_Auth_AssertionCredentials;
use Google_Service_Datastore;
use Google_Service_Urlshortener;
use Google_Service_Urlshortener_Url;

class GetPMCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pmcampaign {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popped Message Retrieve / Fetch from Popping email.';

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
        $campaign_id = $this->argument('id');
        if(!$campaign_id)
            return true;

        /*imap_email    from EmailQueueController */
        $camp = Campaign::with('relPoppingEmail.relImap')
            ->where('id', $campaign_id)
            ->where('status', 'active')
            ->first();

        if(isset($camp)){
            $pop_email = $camp->relPoppingEmail;
            $imap = $pop_email->relImap;

            #for($i=0; $i < count($camp); $i++){
            if($imap->host =='imap.gmail.com'){
                $start_time = date("Y-m-d H:i:s");
                /*session_start();
                define('SCOPES', implode(' ', array(
                                Google_Service_Gmail::MAIL_GOOGLE_COM,
                                Google_Service_Gmail::GMAIL_COMPOSE,
                                Google_Service_Gmail::GMAIL_READONLY,
                                Google_Service_Gmail::GMAIL_MODIFY,
                                "https://www.googleapis.com/auth/urlshortener"
                        )
                ));*/
                $scopes = implode(' ', array(
                        Google_Service_Gmail::MAIL_GOOGLE_COM,
                        Google_Service_Gmail::GMAIL_COMPOSE,
                        Google_Service_Gmail::GMAIL_READONLY,
                        Google_Service_Gmail::GMAIL_MODIFY,
                        "https://www.googleapis.com/auth/urlshortener"
                    )
                );
                //client
                $client = new Google_Client();
                $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
                $client->addScope($scopes);
                $client->setLoginHint($pop_email->email);
                $client->setAccessType('offline');
                $client->setApprovalPrompt("force");

                $json_token = $pop_email->token;
                if ($json_token) {
                    $client->setAccessToken($json_token);
                    // If access token is not valid use refresh token
                    if ($client->isAccessTokenExpired()) {
                        $refresh_token = $client->getRefreshToken();
                        $client->refreshToken($refresh_token);
                        // TODO :: we got refresh token : we need to save to db for life time
                    }

                    // Gmail Service
                    $gmail_service = new \Google_Service_Gmail($client);
                    // Get List of messages
                    $message_data = $this->listMessages($gmail_service, $pop_email->email);
                    $end_time1 = date("Y-m-d H:i:s");
                    if ($message_data) {
                        foreach ($message_data as $msg) {

                            // sender email
                            if (strpos($msg['messageSender'], '<') !== false) {
                                $split = explode('<', $msg['messageSender']);
                                $from_email_name = $split[0];
                                $email = rtrim($split[1], '>');
                                $user_email = preg_replace('/<>*?/', '', $email); // final email
                            } else {
                                $user_email = $msg['messageSender'];
                                $from_email_name = $msg['messageSender'];
                            }

                            // to email   :: $to_email=> user send email here
                            if (strpos($msg['messageTo'], '<') !== false) {
                                $split = explode('<', $msg['messageTo']);
                                $name = $split[0];
                                $email = rtrim($split[1], '>');
                                $to_email = preg_replace('/<>*?/', '', $email); // final email
                            } else {
                                $to_email = $msg['messageTo'];
                            }

                            $email_filter = $this->check_keyword_exists_in_email_subject($user_email);
                            $subject_filter = $this->check_keyword_exists_in_email_subject($msg['messageSubject']);

                            if($email_filter == 0 && $subject_filter == 0){
                                //Check campaign and user_email exists or not
                                $exists_email = PoppedMessageHeader::where('campaign_id', $camp->id)
                                    ->where('user_email', $user_email)
                                    ->whereIn('status', ['not-queued', 'queued'])
                                    ->exists();
                                if ($exists_email){
                                    print "Exists GMAIL\n";
                                    // Store all Emails into database
                                    $popped_msg_hd = PoppedMessageHeader::where('campaign_id', $camp->id)->where('user_email', $user_email)->first();

                                    $popped_msg_hd_msg_order = $popped_msg_hd->message_order;
                                    // Message Order
                                    $msg_order = Message::where('campaign_id', $camp->id)->max('order');
                                    //->orderBy('order', 'desc')->first();
                                    $msg_order_no =$msg_order;// $msg_order->order;

                                    if ($popped_msg_hd_msg_order > $msg_order_no) {
                                        $msg_hd_status = 'msg-ord-exceeded';
                                    }else{
                                        $msg_hd_status = 'not-queued';
                                    }

                                    $model = PoppedMessageHeader::findOrNew($popped_msg_hd->id);
                                    $model->message_order = $popped_msg_hd->message_order + 1;
                                    $model->status = $msg_hd_status;

                                    //save model
                                    if ($model->save()) {
                                        $model_dt = new PoppedMessageDetail();
                                        $model_dt->popped_message_header_id = $model->id;
                                        $model_dt->sender_email = $to_email;
                                        $model_dt->d_status = 'mail-read';
                                        $model_dt->user_message_body = $msg['messageSnippet'];
                                        if ($model_dt->save()) {
                                            try{
                                                $modify_message = $this->modifyMessages($gmail_service, $msg['messageId']);
                                            }catch (\Exception $e){
                                                echo 'Can not modify Unread Emails!';
                                            }
                                        }
                                    }
                                } else {
                                    print "New email\n";
                                    /* Store all Emails into database */
                                    $model = new PoppedMessageHeader();
                                    $model->campaign_id = $camp->id;
                                    $model->user_email = $user_email; //$msg['messageSender'];
                                    $model->user_name = $from_email_name; //$msg['messageSender'];
                                    $model->subject = $msg['messageSubject'];
                                    $model->status = 'not-queued';
                                    $model->message_order = 1;
                                    $model->followup_message_order = 1;

                                    if ($model->save()) {
                                        $model_dt = new PoppedMessageDetail();
                                        $model_dt->popped_message_header_id = $model->id;
                                        $model_dt->sender_email = $to_email;
                                        $model_dt->d_status = 'mail-read';
                                        $model_dt->user_message_body = $msg['messageSnippet'];
                                        if ($model_dt->save()) {
                                            try{
                                                $modify_message = $this->modifyMessages($gmail_service, $msg['messageId']);
                                            }catch (\Exception $e){
                                                print 'Can not modify Unread Emails!\n';
                                            }
                                        }
                                    }
                                }
                            }else{
                                $this->modifyMessages($gmail_service, $msg['messageId']);
                            }
                        }
                    }
                    print "Successfully Added from google email.\n";
                }
            }else{
                $hostname = '{'.$imap->host.':993/imap/ssl/novalidate-cert}INBOX';
                $username = $pop_email->email;
                $password = $pop_email->password;

                // imap open
                $inbox = @imap_open($hostname,$username,$password);
                if(imap_errors()){
                    print_r(imap_errors());
                    return true;
                }
                /* grab emails */
                $emails = imap_search($inbox,'UNSEEN');
                /* if email_template are returned, cycle through each... */
                if($emails) {

                    /* begin output var */
                    $output = '';
                    /* put the newest email_template on top */
                    rsort($emails);
                    /* for every email... */
                    foreach($emails as $email_number) {

                        /* get information specific to this email */
                        $overview = imap_fetch_overview($inbox,$email_number,0);

                        //get message body //1.1 ignore encrypted message
                        $message = imap_fetchbody($inbox,$email_number,1.1);
                        if($message == '')
                        {
                            $message = imap_fetchbody($inbox,$email_number,1.2);

                        }
                        if($message == ''){
                            $message = imap_base64(imap_fetchbody($inbox,$email_number,2));
                        }
                        if($message == ''){
                            $message = imap_body($inbox,$email_number);
                        }

                        //remove header information from message body
                        if (strpos($message, 'quoted-printable') !== false) {
                            $split = explode('quoted-printable', $message);
                            $message = rtrim($split[1]);
                        }
                        // In case missed the header information then
                        if (strpos($message, 'charset=UTF-8') !== false) {
                            $split = explode('charset=UTF-8', $message);
                            $message = rtrim($split[1]);
                        }

                        $from_email = $overview[0]->from;
                        $to_in_email = $overview[0]->to;

                        // make from email in better shape
                        if(strpos($from_email, '<') !== false) {
                            $split = explode('<', $overview[0]->from);
                            $from_email_name = $split[0];
                            $email = rtrim($split[1], '>');
                            $user_email = preg_replace('/<>*?/', '', $email); // final email
                        } else {
                            $user_email = $from_email;
                            $from_email_name = $from_email;
                        }

                        // make to email in better shape
                        if(strpos($to_in_email, '<') !== false) {
                            $split = explode('<', $to_in_email);
                            $to_email_name = $split[0];
                            $email = rtrim($split[1], '>');
                            $to_email = preg_replace('/<>*?/', '', $email); // final email
                        } else {
                            $to_email = $to_in_email;
                            $to_email_name = $to_in_email;
                        }

                        $subject = isset($overview[0]->subject)?($overview[0]->subject):''; // user subject
                        /** Filter Email and Subject :: eg-> ignore if no-reply **/
                        $email_filter = $this->check_keyword_exists_in_email_subject($user_email);
                        $subject_filter = $this->check_keyword_exists_in_email_subject($subject);

                        // if not exists in filter then continue
                        if($email_filter==0 && $subject_filter==0){
                            // Check campaign and user_email exists or not
                            $exists_email = PoppedMessageHeader::where('campaign_id', $camp->id)
                                ->where('user_email', $user_email)
                                ->whereIn('status', ['not-queued', 'queued'])
                                ->exists();
                            if($exists_email){
                                // Store all Emails into database
                                $popped_msg_hd = PoppedMessageHeader::where('campaign_id', $camp->id)->where('user_email', $user_email)->first();
                                $popped_msg_hd_msg_order = $popped_msg_hd->message_order;
                                // Message Order
                                $msg_order = Message::where('campaign_id', $camp->id)->max('order');
                                $msg_order_no = $msg_order;

                                // Central Settings :: resume or stop
                                if($popped_msg_hd_msg_order > $msg_order_no )
                                {
                                    $msg_hd_status = 'msg-ord-exceeded';
                                }else{
                                    $msg_hd_status = 'not-queued';
                                }

                                $model = PoppedMessageHeader::findOrNew($popped_msg_hd->id);
                                $model->message_order = $popped_msg_hd->message_order + 1;
                                $model->status = $msg_hd_status;

                                //save model
                                if($model->save())
                                {
                                    $model_dt = new PoppedMessageDetail();
                                    $model_dt->popped_message_header_id = $model->id;
                                    $model_dt->sender_email = $to_email;
                                    $model_dt->d_status = 'mail-read';
                                    $model_dt->user_message_body = $message;
                                    $model_dt->save();
                                }
                            }else {
                                /* Store all Emails into database */
                                $model = new PoppedMessageHeader();
                                $model->campaign_id = $camp->id;
                                $model->user_email = $user_email;
                                //$model->user_name = $pop_email->name;
                                $model->user_name = $from_email_name;
                                $model->subject = isset($overview[0]->subject) ? ($overview[0]->subject) : '';
                                $model->status = 'not-queued';
                                $model->message_order = 1;
                                $model->followup_message_order = 1;
                                //save
                                if ($model->save()) {
                                    $model_dt = new PoppedMessageDetail();
                                    $model_dt->popped_message_header_id = $model->id;
                                    $model_dt->sender_email = $to_email;
                                    $model_dt->d_status = 'mail-read';
                                    $model_dt->user_message_body = $message;
                                    $model_dt->save();
                                }
                            }
                        }
                    }
                    // for every email...
                    foreach($emails as $email_number){
                        // TESTING BOTH METHODS
                        imap_delete($inbox,$email_number);
                    }

                    /*delete all messages you marked for removal*/
                    imap_expunge($inbox);
                    /* close the connection */
                    imap_close($inbox);
                    print "Fetched Successfully from no google email. \n";
                }
            }
        }
        $end_time2 = date("Y-m-d H:i:s");
        #print "Start time: ".$start_time." End Time1 : ".$end_time1." End time 2".$end_time2."\n";

        return true;
    }


    protected function check_keyword_exists_in_email_subject($email){
        $filter_list= DB::table('filter')->select('name')->get();

        foreach($filter_list as $filter){
            $list[] = ['name' => $filter->name,];
        }

        $match = 0;
        if(isset($list)) {
            foreach ($list as $word) {
                // This pattern takes care of word boundaries, and is case insensitive

                $name = $word['name'];

                $pattern = "/\b$name\b/i";
                $match += preg_match($pattern, $email);
            }
        }

        return $match;
    }

    /* Get Sender email according to count < mails_per_day_per_email  */
    protected function get_sender_email_public($camp_id){

            $se_email = SenderEmail::with(['relSmtp'=> function($query){
                $query->where('smtp.count', '<', 'smtp.mails_per_day_per_email');
            }])
                ->where('campaign_id', $camp_id)
                // ->where('status', 'domain')
                //Only gmail sender emails -----------------
                ->where('status', 'public')
                ->orderBy('count', 'asc')
                ->orderByRaw("RAND()")
                ->first();

        return $se_email;
    }

    /* Get Sender email according to count < mails_per_day_per_email  */
    protected function get_sender_email_domain($camp_id){

        $se_email = SenderEmail::with(['relSmtp'=> function($query){
            $query->where('smtp.count', '<', 'smtp.mails_per_day_per_email');
        }])
            ->where('campaign_id', $camp_id)
            // ->where('status', 'domain')
            //Only gmail sender emails -----------------
            ->where('status', 'domain')
            ->orderByRaw(DB::raw("FIELD(popping_status, false, true)"))
            ->orderBy('count', 'ASC')
            ->orderByRaw("RAND()")
            ->first();
        return $se_email;
    }

    public function listMessages($service, $userId) {
        $pageToken = NULL;
        $messages = array();
        $opt_param = array();
        do {
            try {
                if ($pageToken) {
                    $opt_param['pageToken'] = $pageToken;
                    #$opt_param['maxResults'] = 100;
                }
                #$opt_param['labelIds'] = 'INBOX';
                #$opt_param['q'] = 'before:'.(string)$before_date.' after:'.(string)$after_date.' subject:"Instant Book Reservation Confirmed"  subject:"Reservation Confirmed" ';
                #$opt_param = array['labelIds'] = 'Label_143';
                #$opt_param['startHistoryId'] = $historyID;
                #$opt_param['labelId'] = $labelID;
                #$opt_param['fields'] = 'nextPageToken,historyId,history/messagesAdded';
                #$opt_param['q'] = 'in:inbox is:unread -category:(promotions OR social)';
                $opt_param['q'] = 'in:inbox is:unread';

                $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
                $messageList = $messagesResponse->getMessages();
                $inboxMessage = [];

                foreach($messageList as $mlist){
                    $optParamsGet2['format'] = 'full';
                    $single_message = $service->users_messages->get('me',$mlist->id, $optParamsGet2);

                    $message_id = $mlist->id;
                    $headers = $single_message->getPayload()->getHeaders();
                    $snippet = $single_message->getSnippet();

                    foreach($headers as $single) {

                        if ($single->getName() == 'Subject') {
                            $message_subject = $single->getValue();
                        }
                        else if ($single->getName() == 'Date') {
                            $message_date = $single->getValue();
                            $message_date = date('M jS Y h:i A', strtotime($message_date));
                        }
                        else if ($single->getName() == 'From') {
                            $message_sender = $single->getValue();
                            $message_sender = str_replace('"', '', $message_sender);
                        }
                        else if ($single->getName() == 'To') {
                            $message_to = $single->getValue();
                            $message_to = str_replace('"', '', $message_to);
                        }
                    }
                    $inboxMessage[] = [
                        'messageId' => @$message_id,
                        'messageSnippet' => @$snippet,
                        'messageSubject' => @$message_subject,
                        'messageDate' => @$message_date,
                        'messageSender' => @$message_sender,
                        'messageTo' => @$message_to,
                    ];
                }
            } catch (Exception $e) {
                print 'An error occurred: ' . $e->getMessage();
            }
        } while ($pageToken);
        return $inboxMessage;
    }



    /* @
     * @param $gmail_service :: gmail Service
     * @param $message_data_obj :: message data object
     */
    public function modifyMessages($gmail_service, $message_id){
        $labelsToAdd =  ["UNREAD"];
        $labelsToRemove = ["INBOX"];
        $mods = new \Google_Service_Gmail_ModifyMessageRequest();
        $mods->setAddLabelIds($labelsToAdd);
        $mods->setRemoveLabelIds($labelsToRemove);
        try {
            $message = $gmail_service->users_messages->modify("me", $message_id, $mods);
            return $message;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


}
