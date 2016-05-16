<?php

namespace App\Http\Controllers;

use App\CentralSettings;
use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use App\Helpers\SenderEmailCheck;
use App\Message;
use App\PoppedMessageDetail;
use App\Smtp;
use App\SubMessage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendReminderEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Input;

use App\EmailQueue;
use App\PoppedMessageHeader;
use App\SenderEmail;
use App\PoppingEmail;
use App\Campaign;
use Illuminate\Support\Facades\DB;
use App\Helpers\Xmlapi;
use App\FollowupMessage;
use App\Helpers\EmailSend;

use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use Google_Service_Books;
use Google_Auth_AssertionCredentials;
use Google_Service_Datastore;
use Google_Service_Urlshortener;
use Google_Service_Urlshortener_Url;
use Illuminate\Pagination\Paginator;


class EmailQueueController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        $scopes = [
            'https://www.googleapis.com/auth/plus.profile.email_template.read',
            'https://mail.google.com/',
            'https://www.googleapis.com/auth/gmail.modify',
            'https://www.googleapis.com/auth/gmail.readonly',
            'https://www.googleapis.com/auth/gmail.labels',
        ];
        return Socialite::driver('google')->scopes($scopes)->redirect();

        #return Socialite::driver('google')->redirect();

    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();


        /*
         *  Imap
         *
         */
        /*$username = $user->getEmail(); // urlencode('my-gmail-account');
        $password = 'sreza@2015';

        $imap = imap_open('{imap.gmail.com:993/imap/ssl}UNREAD', $username, $password);
        $email_template = imap_search($imap, 'ALL');*/

        $username = $user->getEmail(); // urlencode('my-gmail-account');
        $password = 'sreza@2015';
        #$password = 'tanin1990';
        $tag = '';

        $output = file_get_contents('https://'.$username.':'.$password.'@mail.google.com/mail/feed/atom/'.$tag);
        $xml = simplexml_load_string($output, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $result = (object) json_decode($json,TRUE);
        $messages = $result->entry;

        $popping_email = PoppingEmail::where('email', $username)->first();
        if($popping_email != null){
            $campaign = Campaign::where('popping_email_id', $popping_email->id)->first();
            if($campaign != null){
                //Campaign ID according to popping email
                $campaign_id = $campaign->id;

                for($i =0 ; $i < count($messages); $i++){
                    $model = new PoppedMessageHeader();
                    $model->campaign_id = $campaign_id;
                    $model->user_email = $user->getEmail();
                    $model->user_name = $user->getName();
                    $model->subject = $messages[$i]['title'];

                    $model->save();

                    /*echo "title : ". $messages[$i]['title']."<br>";
                    echo "summary : ". $messages[$i]['summary']."<br>";
                    echo "modified : ". $messages[$i]['modified']."<br>";
                    echo "issued : ". $messages[$i]['issued']."<br>";
                    echo "id : ". $messages[$i]['id']."<br><br>";*/
                }


            }else{
                Session::flash('flash_message_error', 'There is no campaign by this popping email!');
                return redirect('campaign/index');
            }
        }else{
            Session::flash('flash_message_error', 'Popping Email is not found!');
            return redirect('popping-email/index');
        }
        Session::flash('flash_message', 'Successfully added!');
        return redirect('popped-message');
        exit;


        for($i =0 ; $i < count($messages); $i++){
            echo "title : ". $messages[$i]['title']."<br>";
            echo "summary : ". $messages[$i]['summary']."<br>";
            echo "modified : ". $messages[$i]['modified']."<br>";
            echo "issued : ". $messages[$i]['issued']."<br>";
            echo "id : ". $messages[$i]['id']."<br><br>";
        }

        exit;


        $data = array();
        $data['entries'] = array();
        $data['title'] = $result->title;
        print_r($data['title']);exit;
        $data['fullcount'] = $result->fullcount;
        $data['tagline'] = $result->tagline;
        $data['modified'] = $result->modified;
        foreach ($result->entry as $entry){
            $current_entry = array();
            $current_entry['author'] = array();
            $current_entry['contributor'] = array();
            $current_entry['title'] = (string)$entry->title;
            $current_entry['summary'] = (string)$entry->summary;
            $current_entry['link'] = (string)$entry->link['href'];
            $current_entry['modified'] = (string)$entry->modified;
            $current_entry['issued'] = (string)$entry->issued;
            $current_entry['id'] = (string)$entry->id;
            $current_entry['author']['name'] = (string)$entry->author->name;
            $current_entry['author']['email'] = (string)$entry->author->email;
            $current_entry['contributor']['name'] = (string)$entry->contributor->name;
            $current_entry['contributor']['email'] = (string)$entry->contributor->email;
            $data['entries'][0] = $current_entry;
        }
        var_dump($data);

        exit;

        $username = $user->getEmail(); // urlencode('my-gmail-account');
        $password = 'sreza@2015';
        $tag = '';

        $userDetails = file_get_contents('https://'.$username.':'.$password.'@mail.google.com/mail/feed/atom/'.$tag);
        dd($userDetails);
        exit;

        $userData = json_decode($userDetails);



        /*// OAuth Two Providers
        $token = $user->token;

        // All Providers
        $user_id = $user->getId();
        $user_nickname = $user->getNickname();
        $user_name = $user->getName();
        $user_email = $user->getEmail();
        $user_avatar = $user->getAvatar();

        // save to popping email from google auth
        $model = new PoppingEmail();

        $model->name = $user_name;
        $model->email = $user_email;
        $model->password = '';
        #$model->smtp_id = 10;
        #$model->imap_id = 10;
        $model->token = $token;
        $model->auth_id = $user_id;
        $model->auth_email = $user_email;
        $model->auth_avatar = $user_avatar;
        $model->auth_type = 'google';

        try{
            $model->save();
            return redirect('popping-email/index')->with('flash_message', "Successfully Popped Google Email ! ");
        }catch (\Exception $e){
            return redirect('popping-email/index')->with('flash_message_error', $e->getMessage());
        }*/

        $accessToken = $user->token;
        #$userDetails = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo.email?access_token=' . $accessToken);
        #$userDetails = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken);
        $userDetails = file_get_contents('https://www.googleapis.com/oauth2/v1/users/'.$user->getEmail()
            .'/messages/1');
        $userData = json_decode($userDetails);

        #$msg = Socialite::driver('google')->message();

        print_r($userData);
        echo "OK";
        exit;



    }


    /**
     * Modify the Labels a Message is associated with.
     *
     * @param  Google_Service_Gmail $service Authorized Gmail API instance.
     * @param  string $userId User's email address. The special value 'me'
     * can be used to indicate the authenticated user.
     * @param  string $messageId ID of Message to modify.
     * @param  array $labelsToAdd Array of Labels to add.
     * @param  array $labelsToRemove Array of Labels to remove.
     * @return Google_Service_Gmail_Message Modified Message.
     */
    function modifyMessage($service, $userId, $messageId, $labelsToAdd, $labelsToRemove) {
        $mods = new Google_Service_Gmail_ModifyMessageRequest();
        $mods->setAddLabelIds($labelsToAdd);
        $mods->setRemoveLabelIds($labelsToRemove);
        try {
            $message = $service->users_messages->modify($userId, $messageId, $mods);
            print 'Message with ID: ' . $messageId . ' successfully modified.';
            return $message;
        } catch (Exception $e) {
            print 'An error occurred: ' . $e->getMessage();
        }
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
                #$opt_param['q'] = 'before:'.(string)$before_date.' after:'.(string)$after_date.' subject:"Instant Book Reservation Confirmed" OR subject:"今すぐ予約" OR subject:"Reservation Confirmed" OR subject:"予約が確定しました"';
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
                        'messageId' => $message_id,
                        'messageSnippet' => $snippet,
                        'messageSubject' => $message_subject,
                        'messageDate' => $message_date,
                        'messageSender' => $message_sender,
                        'messageTo' => $message_to,
                    ];
                }
            } catch (Exception $e) {
                print 'An error occurred: ' . $e->getMessage();
            }
        } while ($pageToken);
        return $inboxMessage;
    }






    /*
     *
     * IMap
     *
     */
    public function imap_email()
    {
        $campaign = Campaign::with('relPoppingEmail.relImap')->where('status', 'active')->get() ;
        $sender_email = SenderEmail::with('relImap')->where('popping_status', 'true')
            ->where('status','!=', 'invalid')->get();

        if(isset($campaign)){

            foreach($campaign as $camp){

                $pop_email = $camp->relPoppingEmail;
                $imap = $pop_email->relImap;

                for($i=0; $i < count($camp); $i++){
                    if($imap->host =='imap.gmail.com')
                    {
                        session_start();
                        define('SCOPES', implode(' ', array(
                                Google_Service_Gmail::MAIL_GOOGLE_COM,
                                Google_Service_Gmail::GMAIL_COMPOSE,
                                Google_Service_Gmail::GMAIL_READONLY,
                                Google_Service_Gmail::GMAIL_MODIFY,
                                "https://www.googleapis.com/auth/urlshortener"
                            )
                        ));
                        //client
                        $client = new Google_Client();
                        $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
                        $client->addScope(SCOPES);
                        $client->setLoginHint($pop_email->email);
                        $client->setAccessType('offline');
                        //$client->setApprovalPrompt("force");

                        $json_token = $pop_email->token;
                        #if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
                        if ($json_token) {
                            $client->setAccessToken($json_token);
                            // If access token is not valid use refresh token
                            if ($client->isAccessTokenExpired()) {
                                $refresh_token = $client->getRefreshToken();
                                $client->refreshToken($refresh_token);
                                // TODO :: we got refresh token : we need to save to db for life time
                                #exit($client->getAccessToken());
                            }

                            // Gmail Service
                            $gmail_service = new \Google_Service_Gmail($client);
                            // Get List of messages
                            $message_data = $this->listMessages($gmail_service, $pop_email->email);
                            if ($message_data) {
                                foreach ($message_data as $msg) {
                                    // sender email
                                    if (strpos($msg['messageSender'], ' <') !== false) {
                                        $split = explode(' <', $msg['messageSender']);
                                        $name = $split[0];
                                        $email = rtrim($split[1], '>');
                                        $user_email = preg_replace('/<>*?/', '', $email); // final email
                                    } else {
                                        $user_email = $msg['messageSender'];
                                    }

                                    // to email   :: $to_email=> user send email here
                                    if (strpos($msg['messageTo'], ' <') !== false) {
                                        $split = explode(' <', $msg['messageTo']);
                                        $name = $split[0];
                                        $email = rtrim($split[1], '>');
                                        $to_email = preg_replace('/<>*?/', '', $email); // final email
                                    } else {
                                        $to_email = $msg['messageTo'];
                                    }


                                    /* Check campaign and user_email exists or not */
                                    $exists_email = PoppedMessageHeader::where('campaign_id', $camp->id)->where('user_email', $user_email)->exists();
                                    if ($exists_email) {
                                        /* Store all Emails into database */
                                        $popped_msg_hd = PoppedMessageHeader::where('campaign_id', $camp->id)->where('user_email', $user_email)->first();

                                        $popped_msg_hd_msg_order = $popped_msg_hd->message_order;
                                        // Message Order

                                        $msg_order = Message::where('campaign_id', $camp->id)->orderBy('order', 'desc')->first();
                                        $msg_order_no = $msg_order->order;

                                        // Central Settings :: resume or stop
                                        $resume_stop = CentralSettings::where('title', '=', 'resume-or-stop-if-msg-order-no-exceed')->first();
                                        $resume_stop_status = $resume_stop->status;


                                        $model = PoppedMessageHeader::findOrNew($popped_msg_hd->id);

                                        if ($popped_msg_hd_msg_order > $msg_order_no) {
                                            if ($resume_stop_status == 'resume') {
                                                $model->message_order = 1;
                                            } elseif ($resume_stop_status == 'stop') {
                                                $model->message_order = 0;
                                            }
                                        } else {
                                            $model->message_order = $popped_msg_hd->message_order + 1;
                                        }
                                        $model->status = 'not-queued';

                                        // check to email and set as sender email
                                        $to_email_check = SenderEmail::where('email', $to_email)->exists();
                                        if($to_email_check){
                                            $sender_email_stat = SenderEmail::where('email', $to_email)->first();
                                            if($sender_email_stat->status == "public"){
                                                $sender_email_id = null;
                                            }else{
                                                $sender_email_id = $sender_email_stat->id;
                                            }
                                        }else{
                                            $sender_email_id = null;
                                        }
                                        $model->sender_email_id = $sender_email_id;

                                        //save model
                                        if ($model->save()) {
                                            $model_dt = new PoppedMessageDetail();
                                            $model_dt->popped_message_header_id = $model->id;
                                            $model_dt->d_status = 'mail-read';
                                            $model_dt->user_message_body = $msg['messageSnippet'];
                                            $model_dt->sender_email = SenderEmail::findOrNew($popped_msg_hd->sender_email_id)->email;
                                            if ($model_dt->save()) {
                                                try{
                                                    $modify_message = $this->modifyMessages($gmail_service, $msg['messageId']);
                                                }catch (\Exception $e){
                                                    echo 'Can not modify Unread Emails!';
                                                }
                                            }
                                        }
                                    } else {
                                        /* Set sender email :: $host =$imap->host  , $camp_id= $camp->id */
                                        $se = $this->get_sender_email($imap->host, $camp->id);
                                        if(count($se)>0){
                                            /* Store all Emails into database */
                                            $model = new PoppedMessageHeader();
                                            $model->campaign_id = $camp->id;
                                            $model->user_email = $user_email; //$msg['messageSender'];
                                            //$model->user_name = $pop_email->name;
                                            $model->user_name = $user_email; //$msg['messageSender'];
                                            $model->subject = $msg['messageSubject'];
                                            $model->status = 'not-queued';
                                            $model->message_order = 1;
                                            $model->followup_message_order = 1;
                                            $model->sender_email_id =$se->id;

                                            if ($model->save()) {
                                                $model_dt = new PoppedMessageDetail();
                                                $model_dt->popped_message_header_id = $model->id;
                                                $model_dt->d_status = 'mail-read';
                                                $model_dt->user_message_body = $msg['messageSnippet'];
                                                $model_dt->sender_email = $se->email;
                                                if ($model_dt->save()) {
                                                    try{
                                                        $modify_message = $this->modifyMessages($gmail_service, $msg['messageId']);
                                                    }catch (\Exception $e){
                                                        echo 'Can not modify Unread Emails!';
                                                    }
                                                }
                                            }
                                        }else{
                                            Session::flash('flash_message_error', 'No Gmail Sender Email found in this campaign ! ');
                                        }


                                    }
                                }

                            }
                            Session::flash('flash_message', 'Successfully Added !');

                        }else{
                            Session::flash('flash_message_error', 'No Data ! ');
                        }
                    }else{
                        $hostname = '{'.$imap->host.':993/imap/ssl/novalidate-cert}INBOX';
                        $username = $pop_email->email;
                        $password = $pop_email->password;

                        try{
                            $inbox = imap_open($hostname,$username,$password);
                        }
                        catch(\Exception $e)
                        {
                            echo 'Enable IMAP from Gmail Settings and Enable Less Secure by this https://www.google.com/settings/security/lesssecureapps ';
                            return true;
                        }
                        /* grab email_template */
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
                                $message =imap_fetchbody($inbox,$email_number,"2");//fetch body message
                                $from_email = $overview[0]->from;
                                $to_in_email = $overview[0]->to;

                                // make from email in better shape
                                if(strpos($from_email, ' <') !== false) {
                                    $split = explode(' <', $overview[0]->from);
                                    $name = $split[0];
                                    $email = rtrim($split[1], '>');
                                    $user_email = preg_replace('/<>*?/', '', $email); // final email
                                } else {
                                    $user_email = $from_email;
                                }

                                // make to email in better shape
                                if(strpos($to_in_email, ' <') !== false) {
                                    $split = explode(' <', $to_in_email);
                                    $name = $split[0];
                                    $email = rtrim($split[1], '>');
                                    $to_email = preg_replace('/<>*?/', '', $email); // final email
                                } else {
                                    $to_email = $to_in_email;
                                }

                                $subject = isset($overview[0]->subject)?($overview[0]->subject):''; // user subject
                                /** Filter Email and Subject :: eg-> ignore if no-reply **/
                                $email_filter = $this->check_keyword_exists_in_email_subject($user_email);
                                $subject_filter = $this->check_keyword_exists_in_email_subject($subject);

                                // if not exists in filter then continue
                                if($email_filter==0 && $subject_filter==0)
                                {
                                    /* Check campaign and user_email exists or not */
                                    $exists_email = PoppedMessageHeader::where('campaign_id', $camp->id)->where('user_email', $user_email)->exists();
                                    if($exists_email)
                                    {
                                        /* Store all Emails into database */
                                        $popped_msg_hd = PoppedMessageHeader::where('campaign_id', $camp->id)->where('user_email', $user_email)->first();

                                        $popped_msg_hd_msg_order = $popped_msg_hd->message_order;

                                        // Message Order
                                        $msg_order = Message::where('campaign_id', $camp->id)->orderBy('order', 'desc')->first();
                                        $msg_order_no =$msg_order->order;

                                        // Central Settings :: resume or stop
                                        $resume_stop = CentralSettings::where('title','=', 'resume-or-stop-if-msg-order-no-exceed')->first();
                                        $resume_stop_status = $resume_stop->status;

                                        $model = PoppedMessageHeader::findOrNew($popped_msg_hd->id);

                                        if($popped_msg_hd_msg_order > $msg_order_no )
                                        {
                                            if($resume_stop_status=='resume'){
                                                $model->message_order = 1;
                                            }elseif($resume_stop_status=='stop'){
                                                $model->message_order = 0;
                                            }
                                        }
                                        else
                                        {
                                            $model->message_order = $popped_msg_hd->message_order + 1;
                                        }
                                        $model->status = 'not-queued';

                                        // check to email and set as sender email
                                        $to_email_check = SenderEmail::where('email', $to_email)->exists();
                                        if($to_email_check){
                                            $sender_email_stat = SenderEmail::where('email', $to_email)->first();
                                            if($sender_email_stat->status == "public"){
                                                $sender_email_id = null;
                                            }else{
                                                $sender_email_id = $sender_email_stat->id;
                                            }
                                        }else{
                                            $sender_email_id = null;
                                        }
                                        $model->sender_email_id = $sender_email_id;


                                        //save model
                                        if($model->save())
                                        {
                                            $model_dt = new PoppedMessageDetail();
                                            $model_dt->popped_message_header_id = $model->id;
                                            $model_dt->d_status = 'mail-read';
                                            $model_dt->user_message_body = $message;
                                            $model_dt->sender_email = SenderEmail::findOrNew($sender_email_id) ? SenderEmail::findOrNew($sender_email_id)->email : null;
                                            $model_dt->save();
                                        }
                                    }
                                    else
                                    {
                                        /* Set sender email :: $host =$imap->host  , $camp_id= $camp->id */
                                        $se = $this->get_sender_email($imap->host, $camp->id);
                                        if($se) {
                                            /* Store all Emails into database */
                                            $model = new PoppedMessageHeader();
                                            $model->campaign_id = $camp->id;
                                            $model->user_email = $user_email;
                                            //$model->user_name = $pop_email->name;
                                            $model->user_name = $user_email;
                                            $model->subject = isset($overview[0]->subject) ? ($overview[0]->subject) : '';
                                            $model->status = 'not-queued';
                                            $model->message_order = 1;
                                            $model->followup_message_order = 1;
                                            $model->sender_email_id = $se->id;

                                            //SenderEmail::where('status', 'public')->orderBy('count', 'asc')->first()->email;//$se->id;

                                            if ($model->save()) {
                                                $model_dt = new PoppedMessageDetail();
                                                $model_dt->popped_message_header_id = $model->id;
                                                $model_dt->d_status = 'mail-read';
                                                $model_dt->user_message_body = $message;
                                                $model_dt->sender_email = $se->email;
                                                $model_dt->save();
                                            }
                                        }
                                        else{
                                            echo "No Sender email in Active Campaign !";
                                        }
                                    }
                                }
                            }
                            /* close the connection */
                            imap_close($inbox);
                            echo 'Fetched Successfully !';
                        }
                    }
                }
            }
        }
        /*Sender Email */
        if((count($sender_email)>0)){
            foreach($sender_email as $values){
                $se = $values;
                $imap = $values->relImap;
                for($i=0; $i < count($values); $i++){
                    if($imap->host =='gmail.com' || $imap->host =='imap.gmail.com'){
                        $hostname = '{imap.googlemail.com:993/imap/ssl/novalidate-cert}INBOX';
                        $username = $values->email;
                        $password = $values->password;
                    }else{
                        $hostname = '{'.$imap->host.':993/imap/ssl/novalidate-cert}INBOX';
                        $username = $values->email;
                        $password = $values->password;
                    }
                    try{
                        $inbox = imap_open($hostname,$username,$password);
                    }
                    catch(\Exception $e)
                    {
                        Session::flash('flash_message_error', 'Enable IMAP from Gmail Settings and Enable Less Secure by this https://www.google.com/settings/security/lesssecureapps ');
                        return redirect('popped-message');
                    }
                    /* grab email_template */
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
                            $message = imap_fetchbody($inbox,$email_number,2);
                            $from_email = $overview[0]->from;
                            $to_in_email = $overview[0]->to;

                            if(strpos($from_email, ' <') !== false) {
                                $split = explode(' <', $overview[0]->from);
                                $name = $split[0];
                                $email = rtrim($split[1], '>');
                                $user_email = preg_replace('/<>*?/', '', $email); // final email
                            } else {
                                $user_email = $from_email;
                            }

                            // make to email in better shape
                            if(strpos($to_in_email, ' <') !== false) {
                                $split = explode(' <', $to_in_email);
                                $name = $split[0];
                                $email = rtrim($split[1], '>');
                                $to_email = preg_replace('/<>*?/', '', $email); // final email
                            } else {
                                $to_email = $to_in_email;
                            }

                            $subject = isset($overview[0]->subject)?($overview[0]->subject):'';// user subject

                            /** Filter Email and Subject :: eg-> ignore if no-reply **/
                            $email_filter = $this->check_keyword_exists_in_email_subject($user_email);
                            $subject_filter = $this->check_keyword_exists_in_email_subject($subject);

                            // if not exists in filter then continue
                            if($email_filter==0 && $subject_filter==0){
                                /* Check campaign and user_email exists or not */
                                $exists_email = PoppedMessageHeader::where('campaign_id', $values->campaign_id)->where('user_email', $user_email)->exists();
                                if($exists_email){
                                    /* Store all Emails into database */
                                    $popped_msg_hd = PoppedMessageHeader::where('campaign_id', $values->campaign_id)->where('user_email', $user_email)->first();
                                    $popped_msg_hd_msg_order = $popped_msg_hd->message_order;

                                    // Message Order
                                    $msg_order = Message::where('campaign_id', $values->campaign_id)->orderBy('order', 'desc')->first();
                                    $msg_order_no =$msg_order->order;

                                    // Central Settings :: resume or stop
                                    $resume_stop = CentralSettings::where('title','=', 'resume-or-stop-if-msg-order-no-exceed')->first();
                                    $resume_stop_status = $resume_stop->status;

                                    $model = PoppedMessageHeader::findOrNew($popped_msg_hd->id);

                                    if($popped_msg_hd_msg_order > $msg_order_no ){
                                        if($resume_stop_status=='resume'){
                                            $model->message_order = 1;
                                        }elseif($resume_stop_status=='stop'){
                                            $model->message_order = 0;
                                        }
                                    }else{
                                        $model->message_order = $popped_msg_hd->message_order + 1;
                                    }
                                    // check to email and set as sender email
                                    $to_email_check = SenderEmail::where('email', $to_email)->exists();
                                    if($to_email_check){
                                        $sender_email_stat = SenderEmail::where('email', $to_email)->first();
                                        if($sender_email_stat->status == "public"){
                                            $sender_email_id = null;
                                        }else{
                                            $sender_email_id = $sender_email_stat->id;
                                        }
                                    }else{
                                        $sender_email_id = null;
                                    }
                                    $model->sender_email_id = $sender_email_id;
                                    $model->status = 'not-queued';

                                    // Save
                                    if($model->save()){
                                        $model_dt = new PoppedMessageDetail();
                                        $model_dt->popped_message_header_id = $model->id;
                                        $model_dt->d_status = 'mail-read';
                                        $model_dt->user_message_body = $message;
                                        $model_dt->sender_email = SenderEmail::findOrNew($sender_email_id)? SenderEmail::findOrNew($sender_email_id)->email : null;
                                        $model_dt->save();
                                    }
                                }else{

                                    /* Set sender email */
                                    $se = $this->get_sender_email($imap->host, $values->campaign_id); // $host =$imap->host  , $camp_id= $camp->id

                                    /* Store all Emails into database */
                                    $model = new PoppedMessageHeader();
                                    $model->campaign_id = $values->campaign_id;
                                    $model->user_email =  $user_email;
                                    $model->user_name = $values->name;
                                    $model->subject = isset($overview[0]->subject)?($overview[0]->subject):'';
                                    $model->status = 'not-queued';
                                    $model->message_order = 1;
                                    $model->sender_email_id = $se->id;

                                    if($model->save()){
                                        $model_dt = new PoppedMessageDetail();
                                        $model_dt->popped_message_header_id = $model->id;
                                        $model_dt->d_status = 'mail-read';
                                        $model_dt->user_message_body = $message;
                                        $model_dt->sender_email = $se->email;
                                        $model_dt->save();
                                    }
                                }
                            }
                        }
                        /* close the connection */
                        imap_close($inbox);
                        echo 'Fetched Successfully !';
                    }
                }
            }
        }/*
        if(count($campaign)<1 ){
            Session::flash('flash_message', 'No Unread Email(s) Found in Popping Email!');
        }
        if(count($sender_email)<1){
            Session::flash('flash_message', 'No Unread Email(s) Found in Sender Emails!');
        }*/
        return redirect('popped-message');
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

    /*
     *
     */

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
    protected function get_sender_email($host, $camp_id){
        $se_email = SenderEmail::with(['relSmtp'=> function($query){
            $query->where('smtp.count', '<', 'smtp.mails_per_day_per_email');
        }])
            ->where('campaign_id', $camp_id)
            // ->where('status', 'domain')
            //Only gmail sender emails -----------------
            ->where('status', 'public')
            ->orderBy('count', 'asc')
            ->first();

        return $se_email;
    }



    /*
     * This would be in Kernel Consol
     *
     */

    public function reply_email($id){

        /*$popped_message_id = $id;
        $popped_message = PoppedMessageHeader::findOrFail($popped_message_id);
        $campaign_id = $popped_message->campaign_id;
        $camp_exists = Campaign::where('id', $campaign_id)->where('status', 'active')->exists();

        if($camp_exists){

            $sender_email = SenderEmail::with('relSmtp')->where('campaign_id', $campaign_id)
                ->where('status','!=', 'invalid')
                ->first();
            #print_r($sender_email);exit;

            $host = $sender_email->relSmtp->host;
            $port = $sender_email->relSmtp->port;
            $from_email = $sender_email->email;
            $from_name =  $sender_email->name;
            $username  =  $sender_email->email;
            $password  =  $sender_email->password;
            $to_email  = $popped_message->user_email;
            $subject  =  $popped_message->subject;
//            $body =      ;

            try{
            // fire email
            $result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body);
                if($result){
                    DB::beginTransaction();

                    //Popping Status in sender_email table
                    $sm_model = SenderEmail::findOrNew($sender_email->id);
                    $sm_model->popping_status = 'true';
                    $sm_model->save();

                    //Commit
                    DB::commit();
                    Session::flash('flash_message', 'Sent First Message to : '.$popped_message->user_email);
                }
            }catch (\Exception $e){
                DB::rollback();
                Session::flash('flash_message_error', $e->getMessage());
            }
        }else{
            Session::flash('flash_message_error', 'Campaign is not Activated yet!');
        }
        return redirect('popped-message');*/
    }

    /*
     *
     * Email Queue Process and store to the table email_queue
     *
     */

    public function mail_queue(){

        $pageTitle = 'Emails are in Queue';
        //sub-message data

        $statement = "
                    SELECT popped_message_header_id, sub_message_id, send_time,
                            (SELECT email from sender_email WHERE id=sender_email_id) AS sender_email_id,
                          to_email
                    FROM email_queue WHERE sub_message_id IS NOT NULL
                      UNION
                    SELECT tmp_garbage.popped_message_header_id, tmp_garbage.sub_message_id,
                            ' processing.. ' AS send_time,
                            tmp_garbage.from_email AS sender_email_id, tmp_garbage.to_email
                    FROM tmp_garbage WHERE sub_message_id IS NOT NULL
                  ";

        $data = DB::Select($statement);

        // Get the current page from the url if it's not set default to 1
        $page = Input::get('page', 1);
        // Number of items per page
        $perPage = 100;
        // Start displaying items from this number;
        $offSet = ($page * $perPage) - $perPage; // Start displaying items from this number
        // Get only the items you need using array_slice (only get 10 items since that's what you need)
        $itemsForCurrentPage = array_slice($data, $offSet, $perPage, true);
        // Return the paginator with only 10 items but with the count of all items and set the it on the correct page
        $data =  new LengthAwarePaginator($itemsForCurrentPage, count($data), $perPage, $page);


        return view('mail_queue.index', [
            'data' => $data, 'pageTitle'=> $pageTitle
        ]);
    }
    public function mail_queue_followup(){

        $pageTitle = 'Emails are in Follow Up Queue';

        $statement = "
                    SELECT popped_message_header_id, followup_sub_message_id, send_time,
                            (SELECT email from sender_email WHERE id=sender_email_id) AS sender_email_id,
                          to_email
                    FROM email_queue WHERE followup_sub_message_id IS NOT NULL
                      UNION
                    SELECT tmp_garbage.popped_message_header_id, tmp_garbage.followup_sub_message_id,
                            ' processing.. ' AS send_time,
                            tmp_garbage.from_email AS sender_email_id, tmp_garbage.to_email
                    FROM tmp_garbage WHERE followup_sub_message_id IS NOT NULL
                  ";

        $data = DB::Select($statement);

        // Get the current page from the url if it's not set default to 1
        $page = Input::get('page', 1);
        // Number of items per page
        $perPage = 100;
        // Start displaying items from this number;
        $offSet = ($page * $perPage) - $perPage; // Start displaying items from this number
        // Get only the items you need using array_slice (only get 10 items since that's what you need)
        $itemsForCurrentPage = array_slice($data, $offSet, $perPage, true);
        // Return the paginator with only 10 items but with the count of all items and set the it on the correct page
        $followup_data =  new LengthAwarePaginator($itemsForCurrentPage, count($data), $perPage, $page);


        return view('mail_queue.followup_queue', [
            'pageTitle'=> $pageTitle,'followup_data' => $followup_data,
        ]);
    }


    public function email_queue_process()
    {
        $pause_system = CentralSettings::where('title','=', 'is-paused')->first();
        $popped_message_header = DB::table('popped_message_header')
            ->join('campaign', function ($join) {
                $join->on('popped_message_header.campaign_id', '=', 'campaign.id')
                    ->where('campaign.status', '=', 'active');
            })
            ->where('popped_message_header.status', '=', 'not-queued')
            ->select('popped_message_header.*')
            ->get();
        // Todo:: check if messages are exists
        if(count($popped_message_header)>0){
            foreach ($popped_message_header as $pmhd) {
                if($pmhd->message_order == 1)
                {
                    $first_msg_no = CentralSettings::where('title','=', 'how-many-msg-for-new-email')->first();

                    $msg_data = (object) DB::table('message')
                        ->join('sub_message', function ($join) {
                            $join->on('sub_message.message_id', '=', 'message.id')
                                ->where('sub_message.start_time', '<', date('Y-m-d H:i:s'))
                                ->where('sub_message.end_time', '>', date('Y-m-d H:i:s'));
                        })
                        ->where('message.campaign_id', $pmhd->campaign_id)
                        ->orderBy('message.order', 'asc')
                        ->take($first_msg_no? $first_msg_no->status: 1)
                        ->select(DB::raw('message.delay as message_delay, sub_message.id as sub_message_id'))
                        ->get();

                    $public_domain_email = CentralSettings::where('title','=', 'first-mail-send-by-public-or-domain')->first();
                    if($public_domain_email->status == 'public'){
                        // get first public email
                        $sender_email = DB::table('sender_email')
                            ->having('sender_email.max_email_send', '>', 'sender_email.count')
                            ->where('campaign_id', $pmhd->campaign_id)
                            ->Where('status','public')
                            ->orderBy('count','asc')
                            ->first();
                    }else{
                        // get first domain email for second queue
                        $sender_email = DB::table('sender_email')
                            #->having('sender_email.max_email_send', '>', 'sender_email.count')
                            ->where('campaign_id', $pmhd->campaign_id)
                            ->Where('status','domain')
                            ->orderBy('count','asc')
                            ->first();
                    }


                    if(count($msg_data) > 0){
                        $count = 0;
                        $reply_to_se =SenderEmail::where('status', 'domain')->orderBy('count', 'asc')->first();
                        foreach($msg_data as $val){
                            $model = new EmailQueue();
                            $model->popped_message_header_id = $pmhd->id;
                            $model->sub_message_id = $val->sub_message_id;
                            $model->send_time = date("Y-m-d H:i:s", time() + ($val->message_delay * 60 + $count));
                            $model->sender_email_id = $sender_email->id;
                            $model->reply_to = $reply_to_se->email;
                            $model->to_email = $pmhd->user_email;
                            //save
                            if ($model->save()) {
                                // update status as queued after queue process
                                DB::table('popped_message_header')->where('id', $pmhd->id)->update(['status' => 'queued']);
                                // increment count
                                #DB::table('sender_email')->increment('count', 1, ['id' => $sender_email->id]);
                            }
                            $count = $count + $val->message_delay;
                        }
                    }

                    // Followup message
                    $foll_data = (object) DB::table('followup_message')
                        ->join('followup_sub_message', function ($join) {
                            $join->on('followup_sub_message.followup_message_id', '=', 'followup_message.id')
                                ->where('followup_sub_message.start_time', '<', date('Y-m-d H:i:s'))
                                ->where('followup_sub_message.end_time', '>', date('Y-m-d H:i:s'));
                        })
                        ->where('followup_message.campaign_id', $pmhd->campaign_id)
                        ->orderBy('followup_message.order', 'asc')
                        ->take($first_msg_no? $first_msg_no->status: 1)
                        ->select(DB::raw('followup_message.delay as followup_message_delay, followup_sub_message.id as followup_sub_message_id'))
                        ->get();

                    if(count($foll_data) > 0){
                        $counter = 0;
                        foreach($foll_data as $val){
                            $model = new EmailQueue();
                            $model->popped_message_header_id = $pmhd->id;
                            $model->followup_sub_message_id = $val->followup_sub_message_id;
                            $model->send_time = date("Y-m-d H:i:s", time() + ($val->followup_message_delay * 60 + $counter));
                            $model->sender_email_id = $reply_to_se->id;
                            $model->reply_to = $reply_to_se->email;
                            $model->to_email = $pmhd->user_email;
                            if($model->save()){
                                // update status as queued after queue process
                                DB::table('popped_message_header')->where('id', $pmhd->id)->update(['status' => 'queued']);
                                #DB::table('sender_email')->increment('count', 1, ['id' => $reply_to_se->id]);
                            }
                            $counter = $counter + $val->followup_message_delay;
                        }
                    }
                    Session::flash('flash_message', "Successfully Queued!");
                }elseif($pmhd->message_order != 0){
                    if($pause_system->status != 'yes'){

                        // Count Message order if exists or not
                        $message_order_count = Message::where('campaign_id', $pmhd->campaign_id)->orderBy('order', 'desc')->first();
                        $msg_order_count = $message_order_count->order;

                        // set message order
                        if($msg_order_count >= $pmhd->message_order)
                        {
                            $message_order = $pmhd->message_order;
                        }
                        else
                        {
                            $message = Message::where('campaign_id', $pmhd->campaign_id)
                                ->orderBy('order', 'asc')->first();
                            $message_order = $message->order;
                        }

                        // Get message and sub message data
                        $msg_data = (object) DB::table('message')
                            ->join('sub_message', function ($join) {
                                $join->on('sub_message.message_id', '=', 'message.id')
                                    ->where('sub_message.start_time', '<', date('Y-m-d H:i:s'))
                                    ->where('sub_message.end_time', '>', date('Y-m-d H:i:s'));
                            })
                            ->where('message.campaign_id', $pmhd->campaign_id)
                            ->where('message.order', $message_order)
                            ->select(DB::raw('message.delay as message_delay, sub_message.id as sub_message_id'))
                            ->get();

                        if(count($msg_data)> 0){
                            $count = 0;
                            foreach($msg_data as $val){
                                $model = new EmailQueue();
                                $model->popped_message_header_id = $pmhd->id;
                                $model->sub_message_id = $val->sub_message_id ;
                                $model->send_time = date("Y-m-d H:i:s", time() + ($val->message_delay * 60 + $count));
                                $model->sender_email_id = $pmhd->sender_email_id;
                                $model->reply_to = SenderEmail::where('status', 'domain')->orderBy('count', 'asc')->first()->email;
                                $model->to_email = $pmhd->user_email;

                                if($model->save()){
                                    // update status as queued after queue process
                                    DB::table('popped_message_header')->where('id', $pmhd->id)->update(['status' => 'queued']);
                                    #DB::table('sender_email')->increment('count', 1, ['id' => $pmhd->sender_email_id]);
                                }
                                $count = $count + $val->message_delay;
                            }
                        }
                        Session::flash('flash_message', "Successfully Queued!");
                    }
                }
            }
        }else{
            Session::flash('flash_message_error', "No Popped Emails!");
        }
        return redirect('mail-queue');
    }


    public function sendReminderEmail()
    {
        $user = 'admin';

        #$job = (new SendReminderEmail($user))->onQueue('emails');
        $job = (new SendReminderEmail($user))->Delay(60);

        $this->dispatch($job);

        Session::flash('flash_message', 'Sent Message Successfully !');
        return redirect('mail-queue');
    }


    /*
     * Reply from Email Queue
     *
     */
    public function mail_queue_reply($id){

        $email_queue_id = $id;
        $email_queue = EmailQueue::findOrFail($email_queue_id);

        /*
             * Configure Mail.php // @Overriding  TODO:: not done yet .. configure them all
             */

        $smtp_id = SenderEmail::where('email', '=', $email_queue->sender_email)->first();
        $smtp_host = Smtp::where('id', '=', $smtp_id->smtp_id)->first();



        Config::set('mail.driver', 'smtp');
        //Config::set('mail.host', 'edutechsolutionsbd.com');
        Config::set('mail.host', $smtp_host->host);
        Config::set('mail.port', 465);
        Config::set('mail.from', ['address' => $email_queue->sender_email, 'name' => "Affi Fact"]);
        Config::set('mail.encryption', 'ssl');
        Config::set('mail.username', $email_queue->sender_email);
        //Config::set('mail.username', 'test@edutechsolutionsbd.com');
        Config::set('mail.password', $smtp_id->password);
        //Config::set('mail.password', 'edutech@123');
        Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', false);
        #Config::set('mail.encryption', $sender_email->relSmtp->secure);


        try{

            Mail::send('pages.test', array(''), function ($message) use($email_queue) {
                $message->from($email_queue->sender_email, 'Affi Fact');
                $message->to($email_queue->to_email);
                $message->subject('RE: Mail Queue Process.');

                # email send $message->attach('../public/Asesorias/a.txt');
            });
            // Delete from Email Queue
            //$model = EmailQueue::find($id);
            //$model->delete();

            Session::flash('flash_message', 'Sent First Message to : '.$email_queue->to_email);
        }catch (\Exception $e){

            //exit("OK4");
            Session::flash('flash_message_error', $e->getMessage());
        }

        return redirect('mail-queue');
    }


    /*
     * Bulk Mail Queue Reply
     *
     *
     */
    public function bulk_mail_queue_reply(){


        #$auto_email_send = CentralSettings::where('title', '=', 'is-paused')->first();
        #if($auto_email_send->status !='yes')
        #{
        //email queue data
        $email_queue_data = EmailQueue::where('send_time', '<=', date('Y-m-d H:i:s'))->get();

        if(count($email_queue_data)>0)
        {
            foreach($email_queue_data as $mail_data)
            {
                // Get Subject
                $popped_msg_hd = PoppedMessageHeader::where('id', $mail_data->popped_message_header_id)->first();
                $subject = $popped_msg_hd->subject;

                try
                {
                    if($mail_data->sub_message_id)
                    {
                        $sub_message = SubMessage::with('relSubMessageAttachment')->where('id',$mail_data->sub_message_id)->first();

                        $sub_message_body = $sub_message->description;
                        //$subject_of_msg = mb_substr($sub_message->description, 0, 100);

                        $file_name = null;
                        if(count($sub_message->relSubMessageAttachment)>0){
                            foreach($sub_message->relSubMessageAttachment as $val){
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
                            $se_email_address= SenderEmail::where($mail_data->sender_email_id)->email;
                            $check_email_public_domain = SenderEmail::EmailTypeIdentification($se_email_address, 'status');
                            $camp_id = PoppedMessageHeader::findOrNew($mail_data->popped_message_header_id)->campaign_id;
                            if($check_email_public_domain=='public'){
                                $domain_se = DB::table('sender_email')
                                    ->where('campaign_id', $camp_id)
                                    ->where('status', 'public')
                                    ->orderBy('count', 'asc')
                                    ->first();
                            }elseif($check_email_public_domain=='domain'){
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

                            /* -----  Start Email sending process  ------ */
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
                            $result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to);

                            /* -----  End Email sending process  ------ */
                            if($result){
                                // Store into Detail table
                                $model = new PoppedMessageDetail();
                                $model->popped_message_header_id = $mail_data->popped_message_header_id;
                                $model->sub_message_id = $mail_data->sub_message_id;
                                $model->followup_sub_message_id = $mail_data->followup_sub_message_id;
                                $model->sender_email = $sender_email_data->email;
                                $model->d_status = 'mail-sent';
                                $model->sent_time = date('Y-m-d H:i:s');
                                $model->save() ;

                                //update sender email count
                                /*$sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                                $sender_email_update->count = $sender_email_update->count +1;
                                $sender_email_update->update();*/
                                $sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                                $sender_email_update->count = $sender_email_update->count +1;
                                $sender_email_update->update();

                                // Delete from Email Queue
                                $model_lt = EmailQueue::find($mail_data->id);
                                $model_lt->delete();
                            }
                        }
                    }
                    if(count($mail_data->followup_sub_message_id)>0){
                        $followup_sub_message = FollowupSubMessage::with('relFollowupSubMessageAttachment')
                            ->where('id',$mail_data->followup_sub_message_id)->first();

                        if($followup_sub_message){
                            $followup_sub_message_body = $followup_sub_message->description;
                            //$subject_of_foll_msg = mb_substr($followup_sub_message->description, 0, 100);

                            $file_name = null;
                            if(count($followup_sub_message->relFollowupSubMessageAttachment)>0){
                                foreach($followup_sub_message->relFollowupSubMessageAttachment as $val){
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
                                $se_email_address= SenderEmail::findOrNew($mail_data->sender_email_id)->email;
                                $check_email_public_domain = SenderEmail::EmailTypeIdentification($se_email_address, 'status');
                                $camp_id = PoppedMessageHeader::findOrNew($mail_data->popped_message_header_id)->campaign_id;
                                if($check_email_public_domain=='public'){
                                    $domain_se = DB::table('sender_email')
                                        ->where('campaign_id', $camp_id)
                                        ->where('status', 'public')
                                        ->orderBy('count', 'asc')
                                        ->first();

                                }elseif($check_email_public_domain=='domain'){
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

                                //Start Email sending process
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
                                $result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to);
                                /* -----  End Email sending process  ------ */
                                if($result){
                                    // Store into Detail table
                                    $model = new PoppedMessageDetail();
                                    $model->popped_message_header_id = $mail_data->popped_message_header_id;
                                    $model->sub_message_id = $mail_data->sub_message_id;
                                    $model->followup_sub_message_id = $mail_data->followup_sub_message_id;
                                    $model->sender_email = $sender_email_data->email;
                                    $model->d_status = 'mail-sent';
                                    $model->sent_time = date('Y-m-d H:i:s');
                                    $model->save();

                                    //update sender email count
                                    /*$sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                                    $sender_email_update_data['count'] = $sender_email_update->count +1;
                                    $sender_email_update->fill($sender_email_update_data)->update();*/
                                    $sender_email_update = SenderEmail::findOrFail($sender_email_data->id);
                                    $sender_email_update->count = $sender_email_update->count +1;
                                    $sender_email_update->update();

                                    // Delete from Email Queue
                                    $model_lt = EmailQueue::find($mail_data->id);
                                    $model_lt->delete();
                                }
                            }

                        }
                    }

                    Session::flash('flash_message_error', 'Sent Successfully!');
                }catch (\Exception $e){
                    Session::flash('flash_message_error', $e->getMessage());
                }
            }
        }else{
            Session::flash('flash_message_error', 'No Queued mail found to reply !');
        }
        #}else{
        #    Session::flash('flash_message_error', 'Settings is not allowed to send email automatically !');
        #}
        return redirect('mail-queue');
    }

    /***
     *  Test for Imap emailing
     */
    function imap_test_email(){
        /* connect to gmail */
        $hostname = '{imap.googlemail.com:993/imap/ssl/novalidate-cert}INBOX';
        $username = 'devdhaka404@gmail.com';
        $password = 'etsb1234';
        /*$username = 'bdcode404@gmail.com';
        $password = '3duT3chS0lutions';*/
        /*$username = 'tanin.coding@gmail.com';
        $password = 'tanin1990';*/

        /* try to connect */
        #$inbox = imap_open($hostname,$username,$password) or die(imap_last_error())or die("can't connect: ".imap_last_error());
        try{
            $inbox = imap_open($hostname,$username,$password);
        }
        catch(\Exception $e)
        {
            Session::flash('flash_message_error', 'Enable IMAP from Gmail Settings and Enable Less Secure by this https://www.google.com/settings/security/lesssecureapps ');
            return redirect('popped-message');
        }

        /* grab email_template */
        $emails = imap_search($inbox,'UNSEEN');

        /* if email_template are returned, cycle through each... */
        if($emails) {

            //Check if Exists Popping Email and Campaing
            $popping_email = PoppingEmail::where('email', $username)->first();
            if($popping_email != null) {
                $campaign = Campaign::where('popping_email_id', $popping_email->id)->first();
                if ($campaign != null) {
                    /* begin output var */
                    $output = '';

                    /* put the newest email_template on top */
                    rsort($emails);

                    /* for every email... */
                    foreach($emails as $email_number) {

                        /* get information specific to this email */
                        $overview = imap_fetch_overview($inbox,$email_number,0);
                        $message = imap_fetchbody($inbox,$email_number,2);

                        /* Store all Emails into database */
                        $model = new PoppedMessageHeader();
                        $model->campaign_id = $campaign->id;

                        $split = explode(' <', $overview[0]->from);
                        $name = $split[0];
                        $email = rtrim($split[1], '>');
                        $model->user_email =  preg_replace('/<>*?/', '', $email);
                        $model->user_name = $popping_email->name;
                        $model->subject = $overview[0]->subject;
                        $model->save();

                    }

                    /* close the connection */
                    imap_close($inbox);

                    Session::flash('flash_message', 'Fetched Successfully !');

                }else{
                    Session::flash('flash_message_error', 'No Campaign Found!');
                }
            }else{
                Session::flash('flash_message_error', 'No Popped Emails');
            }
            /*  print_r($output); */
        }else{
            Session::flash('flash_message_error', 'No Unread Emails');
        }
        /* close the connection */
        //imap_close($inbox);
        return redirect('popped-message');
    }




    /*
     *
     * EMail Thread view
     */

    public function mail_thread(){

        $pageTitle = "Email Message Thread";

        $data = DB::table('popped_message_header')
            ->join('sender_email', function ($join) {
                $join->on('sender_email.id', '=', 'popped_message_header.sender_email_id');
            })
            ->select('popped_message_header.id','popped_message_header.user_email','popped_message_header.user_name', 'popped_message_header.subject','popped_message_header.message_order','popped_message_header.campaign_id','popped_message_header.status')
            ->where('popped_message_header.message_order', '>', '2')
            ->where('sender_email.status','=','domain')
            ->where('popped_message_header.status','!=','inactive')
            ->groupBy('popped_message_header.id')
            ->orderBy('popped_message_header.id', 'DESC')
            ->paginate(100);

        return view('mail_thread.index', [
            'data' => $data, 'pageTitle'=> $pageTitle,
        ]);
    }


    public function mail_detail($id){
        $pageTitle = "Email Message Details";

        $p_hd = PoppedMessageHeader::with('relCampaign','relSenderEmail')->where('id', $id)->first();
        $p_dt = PoppedMessageDetail::where('popped_message_header_id', $id)->get();

        $check_settings_is_paused = CentralSettings::where('title', 'is-paused')->first();
        $check_settings_public_domain = CentralSettings::where('title', 'first-mail-send-by-public-or-domain')->first();
//        print_r($check_settings);exit;
        return view('mail_thread.view', [
            'p_hd' => $p_hd, 'p_dt'=>$p_dt, 'pageTitle'=> $pageTitle,
            'check_settings_is_paused'=>$check_settings_is_paused,'check_settings_public_domain'=>$check_settings_public_domain
        ]);
    }



    public function send_custom_msg(Request $request){

        //Send email or from email configuration
        $send_email_public_domain = 'public';

        // Input and Get Popped Header Message
        $input = $request->all();
        $popped_message_header = PoppedMessageHeader::where('campaign_id','=',$input['campaign_id'])->where('id','=',$input['popped_message_header_id'])->first();

        if($popped_message_header){

            $sender_email = SenderEmail::with('relSmtp')->where('id', $popped_message_header->sender_email_id)->first();

            // custom message
            $custom_message = $input['custom_message'];

            if($sender_email){

                try{
                    $host = $sender_email->relSmtp->smtp;
                    #$host = $sender_email->relSmtp->host;
                    $port = $sender_email->relSmtp->port;
                    $from_email = $sender_email->email;
                    $reply_to = $sender_email->email;
                    $from_name =  $sender_email->name;
                    $username  =  $sender_email->email; //$sender_email->relSmtp->server_username;
                    $password  =  $sender_email->password; //$sender_email->relSmtp->server_password;

                    if (strpos($popped_message_header->user_email, ' <') !== false) {
                        $split = explode(' <', $popped_message_header->user_email );
                        $name = $split[0];
                        $email = rtrim($split[1], '>');
                        $to_email = preg_replace('/<>*?/', '', $email); // final email
                    } else {
                        $to_email = $popped_message_header->user_email;
                    }
                    $subject  =  "Re: ".$popped_message_header->subject;
                    $body =      $custom_message;

                    if($request->hasFile('files')){
                        $files = Input::file('files');
                        // start count how many uploaded
                        $upload_count = 0;
                        foreach($files as $file) {
                            $destinationPath = public_path().'/uploads/mail_thread';
                            $filename = $file->getClientOriginalName();
                            $upload_success = $file->move($destinationPath, $filename);
                            $upload_count ++;

                            $file_name []=public_path().'/uploads/mail_thread/'.$filename;
                        }
                    }else{
                        $file_name = null;
                    }


                    // fire email
                    $result = EmailSend::custom_reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to);


                    if($result){

                        DB::beginTransaction();
                        try{
                            SenderEmail::UpdateSenderEmailById($sender_email->id);

                            /* Store all Emails into database */
                            $model = new PoppedMessageDetail();
                            $model->sender_email = $sender_email->email;
                            $model->d_status = 'mail-sent';

                            $model->fill($input)->save();

                            // Update header table status = queued
                            $popped_message_header->status = 'queued';
                            $popped_message_header->save();

                            //Commit
                            DB::commit();
                            Session::flash('flash_message', 'Successfully send mail.');

                        }catch (\Exception $e){
                            DB::rollback();
                            Session::flash('flash_message_error', $e->getMessage());
                        }
                    }
                }catch (\Exception $e){
                    DB::rollback();
                    Session::flash('flash_message_error', $e->getMessage());
                }

            }else{
                Session::flash('flash_message_error', 'Domain email is not found for this mail.');
            }
        }else{
            Session::flash('flash_message_error', 'No Mail Found.');
        }

        return redirect()->back();
    }

    /*
     * Mails per day and gmail email count will be zero each day
     *
     */
    public function reset_count_mails(){
        // Start transaction
        DB::beginTransaction();
        try{

            // Update count for sender_email
            DB::table('sender_email')
                //->where('status', 'gmail')
                //->where('type', 'not-generated')
                ->update(['count' => 0]);

            // Update count for smtp
            DB::table('smtp')
                //->where('type', 'no-email-create')
                ->update(['count' => 0]);

            //Commit
            DB::commit();
            Session::flash('flash_message', 'Success');
        }catch (\Exception $e){
            DB::rollback();
            Session::flash('flash_message_error', $e->getMessage());
        }

        return redirect('settings');
    }



    /*
     * String replace
     */
    public function string_replace(){
        $string = "An infinite number of {name}, ";
        $newstring = str_replace("{name}", "SELIM", $string);
        print_r($newstring); exit;
    }



    public function check_email_exists_and_update_status(){

    }


    public function email_filt(){
        $email = 'tanintjt@gmail.com';
//        $email = rtrim($split[1], '>');
//        $result = $this->check_keyword_exists_in_email_subject($email);
//        print_r($result);exit;
    }

}