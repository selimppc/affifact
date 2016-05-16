<?php

namespace App\Http\Controllers;

use App\CentralSettings;
use App\EmailQueue;
use App\Helpers\Xmlapi;
use App\PoppedMessageDetail;
use App\PoppedMessageHeader;
use App\PoppingEmail;
use App\SendMailFailed;
use App\TmpGarbage;
use DB;
use App\Campaign;
use App\Imap;
use App\SenderEmail;
use App\Smtp;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;
use Session;
use Input;
use App\Helpers\ValidateEmail;
use App\Helpers\SenderEmailCheck;
use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use Laravel\Socialite\Facades\Socialite;
use Google_Service_Books;
use Google_Auth_AssertionCredentials;
use Google_Service_Datastore;
use Google_Service_Urlshortener;
use Google_Service_Urlshortener_Url;
use App\Helpers\GmailSendMessage;


class SenderEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    public function index($campaign_id_single)
    {

        $pageTitle = " Sender Email ";
        $sendermail_filter_name = Input::get('sendermail_filter');

        if($sendermail_filter_name)
        {
            $campaign_id_single = Input::get('campaign_id_single');
            $data1 = SenderEmail::where('name','LIKE','%'.$sendermail_filter_name.'%')
                ->where('campaign_id','=',$campaign_id_single)
                ->where('status', '!=', 'invalid')
                ->orderBy('id', 'desc')
                ->paginate(100);
        }else{
            $data = SenderEmail::where('campaign_id','=',$campaign_id_single)
                ->where('status', '!=', 'invalid')
                ->orderBy('id', 'desc')
                ->paginate(100);
        }
        $campaign_id = Campaign::lists('name','id');
        $campaign_details = Campaign::where('id','=',$campaign_id_single)->get();
        $smtp_id = Smtp::lists('name','id');
        $imap_id = Imap::lists('name','id');

        return view('sender_email.index', ['data' => $data, 'pageTitle'=> $pageTitle,'campaign_id_single'=>$campaign_id_single,'campaign_id'=>$campaign_id,'smtp_id'=>$smtp_id,'imap_id'=>$imap_id,'campaign_details'=>$campaign_details]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)  //Requests\SenderEmailRequest $request
    {

        #Session::flush();
        $input = $request->all();
        #print_r($input);exit();

        if(Session::has('se_input')){
            $session_all = Session::get('se_input');
            $smtp_id =$session_all['smtp_id'];
            $smtp_h = Smtp::findOrNew($smtp_id);
            $smtp_host = $smtp_h['host'];
            $email = $session_all['email'];

        }else{
            $smtp_h = Smtp::findOrNew($input['smtp_id']);
            $smtp_host = $smtp_h['host'];
            $email = $input['email'];
            $se_input_data = array(
                'campaign_id_name' => $input['campaign_id_name'],
                'campaign_id' => $input['campaign_id'],
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'smtp_id' => $input['smtp_id'],
                'imap_id' => $input['imap_id'],
                'popping_status' => $input['popping_status'],

            );
            Session::put('se_input', $se_input_data);
            Session::put('camp_id', $input['campaign_id']);
        }
        $max_email_send = $smtp_h->mails_per_day_per_email;

        //if gmail then gmail validation using api-------------------------------
        if ($smtp_host == 'gmail.com' || $smtp_host == 'smtp.gmail.com') {

            //return Socialite::driver('google')->with(['login_hint' => $email])->redirect();
            define('SCOPES', implode(' ', array(
                    Google_Service_Gmail::MAIL_GOOGLE_COM,
                    Google_Service_Gmail::GMAIL_COMPOSE,
                    Google_Service_Gmail::GMAIL_READONLY,
                    Google_Service_Gmail::GMAIL_MODIFY,
                    //Google_Service_Gmail::GMAIL_SEND,
                    "https://www.googleapis.com/auth/urlshortener"
                )
            ));
            $client = new Google_Client();
            $client->setAuthConfigFile(public_path().'/apis/api_for_sender_email.json');
            $client->addScope(SCOPES);
            $client->setLoginHint($email);
            $client->setAccessType('offline');
            $client->setApprovalPrompt("force");

            #if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            if (Session::has('access_token')) {

                $client->setAccessToken( Session::get('access_token') );
                // If access token is not valid use refresh token
                if($client->isAccessTokenExpired()) {
                    $refresh_token =  $client->getRefreshToken();
                    #$client->refreshToken($refresh_token);
                    Session::put('access_token', $client->getAccessToken());
                }else{
                    $client->setAccessToken(Session::get('access_token'));
                }

                $code = Session::get('code');
                $token = Session::get('access_token');
                $input_data = Session::get('se_input');

                $data = [
                    'campaign_id'=>$input_data['campaign_id'],
                    'name'=>$input_data['name'],
                    'email'=>$input_data['email'],
                    'password'=>$input_data['password'],
                    'smtp_id'=>$input_data['smtp_id'],
                    'imap_id'=>$input_data['imap_id'],
                    'popping_status' => $input_data['popping_status'],
                    'status' => 'public',
                    'type' => 'not-generated',
                    'max_email_send'=>$max_email_send,
                    'auth_email'=>$input_data['email'],
                    'api_type'=>'google',
                    'auth_token'=> $token,
                    'auth_code' => $code,
                ];

                $name_exists = SenderEmail::where('email', $input_data['email'])->exists();
                if($name_exists){
                    Session::flash('flash_message_error', "This Email Name already exists." );
                }else{
                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {
                        $model = new SenderEmail();
                        // store / update / code here
                        $model->create($data);

                        DB::commit();
                        Session::flash('flash_message', 'Successfully added!');

                    }catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction`
                        #Session::forget('se_input');
                        DB::rollback();
                        Session::flash('flash_message_error', "Invalid Request" );
                    }
                }
                //clean session
                Session::forget('access_token');
                Session::forget('code');
                Session::forget('se_input');

                return redirect()->route('sender-email.index', array('camp_id' => Session::get('camp_id')));
            } else {
                $authUrl = $client->createAuthUrl();
                return redirect()->to($authUrl);
            }
        }else{
            // Model for sender email
            $model  = new SenderEmail();

            // Input all
            $input = $request->all();

            // Smtp and Imap
            $smtp= Smtp::findOrNew($input['smtp_id']);

            $imap = Imap::findOrNew($input['imap_id']);

            $max_email_send = $smtp->mails_per_day_per_email;

            // Identify the type
            $type = SenderEmail::EmailTypeIdentification($input['email'], 'type');
            $input['type'] = $type;

            // Identify the status
            $status = SenderEmail::EmailTypeIdentification($input['email'], 'status');
            if(strtolower($status) != 'domain')
                $input['status'] = 'public';
            else
                $input['status'] = 'domain';


            // do the validation
            if($status == 'domain'){
                $pre_text = 'mail.';
            }else {
                $pre_text = '';
            }
            $input['max_email_send'] = $max_email_send;

            //credential for Imap_open
            $hostname = '{'.$imap->host.':993/imap/ssl/novalidate-cert}INBOX';
            $username = $input['email'];
            $password = $input['password'];

            try{
                $inbox = @imap_open($hostname,$username,$password);
                if (imap_errors()) {
                    Session::flash('flash_message_error', 'Invalid Email Address or password' );
                }else{
                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {
                        $model->fill($input)->save();

                        DB::commit();
                        Session::flash('flash_message', 'Successfully added!');
                    }catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction`
                        DB::rollback();
                        Session::flash('flash_message_error', $e->getMessage() );
                    }
                }
            }catch(\Exception $e){
                Session::flash('flash_message_error', $e->getMessage() );
            }
            return redirect()->back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'Show the detail';
        $data = SenderEmail::with('relCampaign','relSmtp','relImap')->findOrFail($id);

        return view('sender_email.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = SenderEmail::with('relCampaign','relSmtp','relImap')->findOrFail($id);
        $campaign_id_single = $data->relCampaign->id;
        $campaign_details = Campaign::where('id','=',$campaign_id_single)->get();
        $smtp_list = Smtp::lists('name','id');
        $imap_list = Imap::lists('name','id');

        return view('sender_email.update', ['data'=>$data,'campaign_id_single'=>$campaign_id_single,'smtp_id'=>$smtp_list,'imap_id'=>$imap_list,'campaign_details'=>$campaign_details]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\SenderEmailRequest $request, $id)
    {
        $sender_email = SenderEmail::findOrFail($id);
        $input = $request->all();

        if($sender_email['api_type']== null || $sender_email['api_type'] != 'google'){

            // imap style
            $model = SenderEmail::findOrFail($id);
            $imap = Imap::findOrNew($input['imap_id']);
            $status = $model->status;

            // do the validation
            if($status == 'domain'){
                $pre_text = 'mail.';
            }else {
                $pre_text = '';
            }

            $hostname = '{'.$pre_text.$imap->host.':993/imap/ssl/novalidate-cert}INBOX';
            $username = $input['email'];
            $password = $input['password'];

            try{
                $inbox = imap_open($hostname,$username,$password);

                /* Transaction Start Here */
                DB::beginTransaction();
                try {

                    $model->campaign_id_name = $input['campaign_id_name'];
                    $model->campaign_id = $input['campaign_id'];
                    $model->name = $input['name'];
                    #$model->email = $input['email'];
                    #$model->password = $input['password'];
                    $model->smtp_id = $input['smtp_id'];
                    $model->imap_id = $input['imap_id'];
                    $model->popping_status = $input['popping_status'];

                    $model->save();

                    DB::commit();
                    Session::flash('flash_message', 'Successfully added!');
                }catch (Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    Session::flash('flash_message_error', $e->getMessage() );
                }
            }catch(\Exception $e){
                Session::flash('flash_message_error', $e->getMessage() );
            }

        }else{


            $from_email = $sender_email->email;
            $auth_token = $sender_email->auth_token;
            $se_email = GmailSendMessage::check_valid_gmail($from_email, $auth_token);

            if($se_email){
                if($se_email['status'] == 'valid_existing'){ // if valid
                    //TODO:: if valid run the following code

                    DB::beginTransaction();
                    try {

                        #$sender_email->campaign_id_name = $input['campaign_id_name'];
                        $sender_email->campaign_id = $input['campaign_id'];
                        $sender_email->name = $input['name'];
                        #$model->email = $input['email'];
                        #$model->password = $input['password'];
                        $sender_email->smtp_id = $input['smtp_id'];
                        $sender_email->imap_id = $input['imap_id'];
                        $sender_email->popping_status = $input['popping_status'];
                        $sender_email->save();

                        // commit your changes
                        DB::commit();
                        Session::flash('flash_message', 'Successfully Updated!');
                    }catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction`
                        DB::rollback();
                        Session::flash('flash_message_error', $e->getMessage() );
                    }

                }else{ //if invalid => $se_email['status'] == 'invalid'
                    //TODO:: after Invalid run the following code

                    Session::flash('error_message', $from_email.'Invalid email!');
                }
            }
        }

        return redirect()->back();
    }


    /** TODO It seems a unused function
     *   TODO It needs to remove later
     */
    public function create_user(Request $request)
    {
        $last_data = SenderEmail::orderBy('id', 'desc')->first();
        $smtp_data=Smtp::orderBy('id', 'desc')->first();
        $imap_data=Imap::orderBy('id', 'desc')->first();
        $campaign_data=Campaign::orderBy('id', 'desc')->first();

        if($last_data!=Null){
            $last_id=$last_data->id;
        } else {
            Session::flash('flash_message', 'Please Add Some E-Mail Manually!');
            return redirect()->back();
        }

        if($smtp_data!=Null){
            $smtp_ids=$smtp_data->id;
        } else {
            Session::flash('flash_message', 'Please Insert Some Smtp Ids!');
            return redirect()->back();
        }

        if($imap_data!=Null){
            $imap_ids=$imap_data->id;
        } else {
            Session::flash('flash_message', 'Please Insert Some Imap Ids!');
            return redirect()->back();
        }

        if($campaign_data!=Null){
            $campaign_id = $request->campaign_id;
        } else {
            Session::flash('flash_message', 'Please Insert Some Campaign Ids!');
            return redirect()->back();
        }

        $smtp_obj = Smtp::findOrFail($smtp_ids);
        $smtp_name=explode("@",$smtp_obj->host);
        $name = preg_replace('/\s+/', '_', $request->name);

        if ( ! isset($smtp_name[0]))
        {
            $domain = null;
        }
        else
        {
            $domain = $smtp_name[0];
        }

        for($i=0; $i<2;$i++)
        {
            $name = $name.($last_id + $i +2);
            $domain_name = explode('.',$domain,2);
            if($domain_name[0] == 'smtp'){
               $domain = $domain_name[1];
            }
            $email = $name.'@'.$domain;
            $password = 'test';
            $smtp_id = $smtp_ids;
            $imap_id = $imap_ids;

            $values = new SenderEmail();
            $values->campaign_id = $campaign_id;
            $values->name = $name;
            $values->email = $email;
            $values->password = $password;
            $values->smtp_id = $smtp_id;
            $values->imap_id = $imap_id;
            $values->max_email_send = $smtp_obj->mails_per_day_per_email;

            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                $values->save(); // store / update / code here
                DB::commit();
                Session::flash('flash_message', 'Successfully Created!');
            }catch (Exception $e) {

                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('flash_message_error', "Invalid Request" );
            }
        }
        return redirect()->back();
    }

    /*
     * Generate email account using cpanel
     *
     */
    public function generate_email()
    {
        $input = Input::all();
        $name_1 = Input::get('name');
        $name = preg_replace('/\s+/', '.', $name_1);
        $name = strtolower($name);
        $campaign_id = Input::get('campaign_id');

        $smtp_details = Smtp::where('type','=','email-create')->orderBy('mails_per_day_per_email', 'DESC')->orderBy('count', 'ASC')->first();

        if(count($smtp_details) > 0){
            $domain = $smtp_details->host;
            $imap_details = Imap::where('host', $domain)->first();
            if(count($imap_details) <= 0){
                Session::flash('flash_message_error_generate', "No imap is got related to ".$domain." smtp.");
                return redirect()->back();
            }

            try {
                if (isset($smtp_details->type) == 'email-create') {
                    //$email_name = $name . substr(mt_rand(1000, 9999 ), 0, 5);
                    $email_name = $name ;

                    $smtp_id = $smtp_details->id;
                    $imap_id = $imap_details->id;

                    // e.g. exampled, your cPanel main domain usually
                    $cpuser = $smtp_details->server_username;

                    // Your cPanel password.
                    $cppass = $smtp_details->server_password;

                    // The cPanel domain
                    $cpdomain = $smtp_details->host;

                    // The smtp port
                    $smtp_port = $smtp_details->port;

                    // cpanel port
                    $c_port = $smtp_details->c_port;

                    //The password for the email account
                    $emailpass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$'), 8, 15);

                    // Megabytes of space, 0 for unlimited
                    $quota = '25';

                    $ip = $cpdomain;

                    // cpanel user account name
                    $account = $cpuser;

                    // cpanel user password
                    $passwd = $cppass;

                    // cpanel secure authentication port unsecure port# 2082
                    $port = $c_port;

                    // email domain (usually same as cPanel domain)
                    $email_domain = $cpdomain;

                    // default amount of space in megabytes
                    $email_quota = $quota;

                    // Read the limit from central setting
                    $setting = CentralSettings::where('title' , 'no_of_generate_email')->first();
                    if($setting->no_of_generate_email > 0)
                        $generate_limit = $setting->no_of_generate_email;
                    else
                        $generate_limit = 1;

                    /*************End of Setting***********************/

                    $e_user         = $email_name;
                    $email_user     = $e_user;
                    $email_pass     = $passwd;
                    $email_vpass    = $emailpass;
                    $dest_email     = '';

                    if (!empty($email_user))
                        while (true) {
                            try {
                                $generate_no = CentralSettings::select('status')->where('title', '=', 'no_of_generate_email')->first();
                                $generate_limit = $generate_no->status;
                                for($i=0; $i < $generate_limit; $i++) {
                                    $xmlapi = new Xmlapi($ip);

                                    //set port number. cpanel client class allow you to access WHM as well using WHM port.
                                    $xmlapi->set_port($port);

                                    // authorization with password. not as secure as hash.
                                    $xmlapi->password_auth($account, $passwd);

                                    // cpanel email addpop function Parameters
                                    $email_user = $email_name.substr(mt_rand(1000, 9999 ), 0, 5);
                                    $call = array('domain' => $email_domain, 'email' => $email_user, 'password' => $email_vpass, 'quota' => $email_quota);

                                    //output to error file  set to 1 to see error_log.
                                    // making call to cpanel api
                                    $xmlapi->set_debug(0);
                                    $email_user_name[$i] = $email_user;

                                    $result = $xmlapi->api2_query($email_user, "Email", "addpop", $call);

                                }
                            } catch (\Exception $e) {
                                Session::flash('flash_message_error_generate', $e->getMessage());
                                return redirect()->back();
                            }

                            if ($result->data->result == 1) {
                                for($j=0; $j < count($email_user_name); $j++){

                                    //email create successfully
                                    //Sender Email Database information set
                                    $email_address = $email_user_name[$j] . '@' . $cpdomain;

                                    $sender_email_data = new SenderEmail();
                                    $sender_email_data->campaign_id = $campaign_id;
                                    $sender_email_data->email = $email_address;
                                    $sender_email_data->password = $emailpass;
                                    $sender_email_data->name = $name_1;
                                    $sender_email_data->smtp_id = $smtp_id;
                                    $sender_email_data->imap_id = $imap_id;
                                    $sender_email_data->popping_status = 'false';
                                    $sender_email_data->type = 'generated';
                                    $sender_email_data->status = 'domain';
                                    $sender_email_data->max_email_send = $smtp_details->mails_per_day_per_email;

                                    DB::beginTransaction();
                                    try {
                                        $sender_email_data->save();

                                        DB::commit();
                                        Session::flash('flash_message', 'Sender email successfully created!');
                                    } catch (Exception $e) {
                                        //If there are any exceptions, rollback the transaction`
                                        DB::rollback();
                                        Session::flash('flash_message_error_generate', "Invalid Request");
                                    }
                                }

                                //update smtp count -
                                $smtp_details->count = $smtp_details->count + $generate_limit;

                                //Transaction Start Here
                                DB::beginTransaction();
                                try {
                                    $smtp_details->save(); // store / update / code here

                                    DB::commit();
                                    Session::flash('flash_message', 'Sender email successfully created!');
                                } catch (Exception $e) {

                                    //If there are any exceptions, rollback the transaction`
                                    DB::rollback();
                                    Session::flash('flash_message_error_generate', "Invalid Request");
                                }
                            }
                            else{
                                Session::flash('flash_message_error_generate', "Cannot create domain email !!!");
                            }
                            return redirect()->back();
                        }
                }
                else{
                    Session::flash('flash_message_error_generate', "Email-Create Host not found in SMTP");
                    return redirect()->back();
                }
            }
            catch (Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('flash_message_error_generate', "Email-Create Host not found in SMTP");
                return redirect()->back();
            }
        }else{
            Session::flash('flash_message_error_generate', "No private domain is at the smtp list.");
            return redirect()->back();
        }

    }


    public function destroy($id)
    {
        //TODO:: Popped Message header , popped message details and email queue
        DB::beginTransaction();
        try {
            // To make relationship checking off
            DB::statement("SET foreign_key_checks = 0");

            $sender_email_data = SenderEmail::findOrFail($id);
            EmailQueue::where('sender_email_id', $sender_email_data->id)->Delete();

            $pop_head_data = PoppedMessageHeader::where('sender_email_id', $sender_email_data->id)->get();
            foreach ($pop_head_data as $popped_data) {
                PoppedMessageDetail::where('popped_message_header_id', $popped_data->id)->Delete();
            }
            PoppedMessageHeader::where('sender_email_id', $sender_email_data->id)->Delete();
            PoppedMessageDetail::where('sender_email', $sender_email_data->email)->Delete();
            TmpGarbage::where('from_email',$sender_email_data->email)->Delete();
            SendMailFailed::where('from_email',$sender_email_data->email)->Delete();

            if ($sender_email_data->type == 'generated') {
                //delete from cpanel------------------
                $sender_details = SenderEmail::with('relSmtp')->where('id', '=', $sender_email_data->id)->first();
                $smtp_details = $sender_details->relSmtp;
                $email = explode('@', $sender_email_data->email);
                $email_name = $email[0];

                //listed on cPanel as 'theme'
                $cpskin = 'x3';
                // e.g. exampled, your cPanel main domain usually
                $cpuser = $smtp_details->server_username;
                //Your cPanel password.
                $cppass = $smtp_details->server_password;
                //The cPanel domain
                $domain = $smtp_details->host;
                //fopne
                $a = @fopen("http://".$cpuser.":".$cppass."@".$domain.":2082/frontend/".$cpskin."/mail/realdelpop.html?domain=".$domain."&email=".$email_name, "r");

                if(!$a){
                    Session::flash('flash_message_error', "Email is deleted from system but not from server.");
                }
            }
            SenderEmail::where('id', $sender_email_data->id)->Delete();
            DB::commit();

            Session::flash('flash_message', "Successfully Deleted");
        }catch (Exception $ex){
            DB::rollback();
            Session::flash('flash_message_error', $ex->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Delete Using cpanel
     * @param $email
     * @param $id
     * @param $campaign_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_email_cpanel($email,$id,$campaign_id)
    {
        $sender_details = SenderEmail::with('relSmtp')->where('id','=',$id)->first();
        $smtp_details =  $sender_details->relSmtp;
        $email = explode('@',$email);
        $email_name = $email[0];

        // e.g. exampled, your cPanel main domain usually
        $cpuser = $smtp_details->server_username;
        //Your cPanel password.
        $cppass = $smtp_details->server_password;
        //The cPanel domain
        $domain = $smtp_details->host;
        //listed on cPanel as 'theme'
        $cpskin = 'x3';
        $model = SenderEmail::findOrFail($id);

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            $sender_email = SenderEmail::where('id', $id)->get();

                /*try {

                    @fopen("http://" . $cpuser . ":" . $cppass . "@" . $domain . ":2082/frontend/x3/mail/realdelpop.html?domain=" . $domain . "&email=" . $email_name, "r");
                }
                catch(\Exception $e){
//                    exit('1st catch block');
                    Session::flash('flash_message_error', "Invalid Delete Process, Something wrong to delete from cpanel !!!" );
                    return redirect()->route('sender-email.index',$campaign_id);
                }*/

                foreach($sender_email as $se){
                    $pm_header_exists = PoppedMessageHeader::where('sender_email_id', $se->id)->exists();
                    if($pm_header_exists){
                        $pm_header = PoppedMessageHeader::where('sender_email_id', $se->id)->get();

                        foreach($pm_header as $pmd){

                            PoppedMessageDetail::where('popped_message_header_id',$pmd->id)->delete();
                            EmailQueue::where('popped_message_header_id',$pmd->id)->delete();
                        }
                        PoppedMessageHeader::where('sender_email_id', $se->id)->delete();

                    }

                    SenderEmail::where('id', $id)->forceDelete();

                    /*@fopen("http://" . $cpuser . ":" . $cppass . "@" . $domain . ":2082/frontend/x3/mail/realdelpop.html?domain=" . $domain . "&email=" . $email_name, "r");*/

                    Session::flash('flash_message', "Successfully deleted .");
                }
//            }
//
            DB::commit();
            Session::flash('flash_message', 'Sender Email successfully deleted!');
        }catch (\Exception $e) {
//           exit('2nd catch block');
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * @param $path
     * @param $filename
     * @param $campaign_id
     * @param $smtp_id
     * @param $imap_id
     * @param $popping_status
     * @param $count
     * @param $type
     * @param $status
     * @param $max_gmail_send
     * @return mixed
     */
    public function import_csv($path, $filename, $campaign_id, $smtp_id, $imap_id,$popping_status,$count,$type,$status,$max_mail_send){
        $import_file = $path . $filename;

        //open csv file
        $handle = fopen($import_file, "r");

        // To get the type run the loop one time.
        // IT will add one item only.
        // To reduce the email_type_identification() each time calling, it has been exit after one iteration
        while (($data = fgetcsv($handle)) !== FALSE) {
            $type = SenderEmail::EmailTypeIdentification($data[1], 'type');
            $status = SenderEmail::EmailTypeIdentification($data[1], 'status');
            if($status != 'domain')
                $status = 'public';

            $import="INSERT into sender_email(campaign_id,name,email,password,smtp_id,imap_id,popping_status,count,max_email_send,type,status)values('$campaign_id','".$data[0]."','".$data[1]."','".$data[2]."','$smtp_id','$imap_id','$popping_status','$count','$max_mail_send','$type','$status')";

            //execute query with csv data---------------------
            $a = DB::connection()->getpdo()->exec($import);
            break;
        }

        while (($data = fgetcsv($handle)) !== FALSE) {
            $import="INSERT into sender_email(campaign_id,name,email,password,smtp_id,imap_id,popping_status,count,max_email_send,type,status)values('$campaign_id','".$data[0]."','".$data[1]."','".$data[2]."','$smtp_id','$imap_id','$popping_status','$count','$max_mail_send','$type','$status')";

            //execute query with csv data---------------------
            $a = DB::connection()->getpdo()->exec($import);
        }
        return $a;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulk_email(){
        if($this->isPostRequest()) {
            if (Input::hasFile('file')) {
                $campaign_id = Input::get('campaign_id');
                $smtp_id = Input::get('smtp_id');
                $smtp_details= Smtp::findOrNew($smtp_id);
                $imap_id = Input::get('imap_id');
                $popping_status = 'false';
                $count = 0;
                $type = 'not-generated';
                $status = 'public';

                // read max_email_send from smtp
                $max_email_send = $smtp_details->mails_per_day_per_email;

                $file = Input::file('file');
                $name = time() . '-' . $file->getClientOriginalName();

                // TODO if uploads folder does not exist then create it  first and
                // TODO give 777 permission
                $path = 'uploads/';
                $file->move($path, $name);

                $ret = $this->import_csv($path, $name, $campaign_id, $smtp_id, $imap_id,$popping_status,$count,$type,$status,$max_email_send);

                unlink($path.'/'.$name);

                if($ret){
                    Session::flash('flash_message', 'Sender email successfully Uploaded !');
                }else{
                    Session::flash('flash_message_error', 'Upload failed !');
                }
                return redirect()->back();

            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * This is for front end single email check function
     * which will call common checking function
     */
    public function check_sender_email($id){

        $sender_email = SenderEmail::findOrFail($id);

        if($sender_email['api_type']== null || $sender_email['api_type'] != 'google'){

            $sender_email_status = SenderEmail::EmailTypeIdentification($sender_email['email'], 'status');

            $ret = SenderEmailCheck::sender_email_checking($id);
            if($ret != null){
                if($sender_email->status == 'invalid'){

                    if($sender_email_status != 'domain'){
                        $sender_email->status = 'public';
                    }else{
                        $sender_email->status = 'domain';
                    }
                    $sender_email->save();
                }
                Session::flash('flash_message', 'Valid email.');
            }else{
                $sender_email->status = 'invalid';
                $sender_email->save();

                Session::flash('error_message', 'Invalid email.');
            }
        }else{
           # Session::flash('flash_message', 'Valid email using GMAIL Access key.');

            $from_email = $sender_email->email;
            $auth_token = $sender_email->auth_token;

            $se_email = GmailSendMessage::check_valid_gmail($from_email, $auth_token);
            if($se_email){
                if($se_email['status'] == 'valid_existing'){
                    Session::flash('flash_message', $from_email.'Valid email using GMAIL Access key.');
                }else{
                    Session::flash('error_message', $from_email.'Invalid email using GMAIL Access key.');
                }
            }
        }

        return redirect()->back();
    }


    public function inactive_emails($campaign_id_single){

        $pageTitle = " Sender Email ";
        $data = SenderEmail::where('campaign_id',$campaign_id_single)->where('status','invalid')->paginate(100);

        return view('sender_email.inactive_email_list',['campaign_id_single'=>$campaign_id_single,'pageTitle'=> $pageTitle,'data'=>$data]);
    }

    public function batch_delete()
    {
        $sender_email_ids = Input::get('ids');
//        print_r($sender_email_ids);exit;
        if($sender_email_ids){
            try {
                DB::statement("SET foreign_key_checks = 0");
                foreach($sender_email_ids as $se){
                    $pm_header_exists = PoppedMessageHeader::where('sender_email_id', $se)->exists();
                    if($pm_header_exists){
                        $pm_header = PoppedMessageHeader::where('sender_email_id', $se)->get();
                        if($pm_header){
                            foreach($pm_header as $pmd){
                                PoppedMessageDetail::where('popped_message_header_id',$pmd)->forceDelete();
                                EmailQueue::where('popped_message_header_id',$pmd)->forceDelete();
                            }
                            PoppedMessageHeader::where('sender_email_id', $se)->forceDelete();
                        }
                    }
                    SenderEmail::where('id', $se)->forceDelete();
//                    Session::flash('flash_message', " Successfully Deleted.");
                }
            } catch(\Exception $ex) {
                Session::flash('flash_message_error', $ex->getMessage());
            }
        }else{
            Session::flash('flash_message_error', " No Data Found. Please Select Sender Email. ");
        }
        return redirect()->back();
    }






    public function test_send_message(){

        $result = GmailSendMessage::sendMessage();

        print_r($result);
        exit("OK");

    }



    /**
     * Get User Access using GMAIL API.
     *
     */

    public function se_boot(){
        session_start();
        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                Google_Service_Gmail::GMAIL_MODIFY,
                //Google_Service_Gmail::GMAIL_SEND,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));

        $client = new Google_Client();
        $client->setAuthConfigFile(public_path().'/apis/api_for_sender_email.json');
        $client->addScope(SCOPES);
        $client->setLoginHint('');
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");

        #if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        if (Session::has('access_token')) {
            $client->setAccessToken(Session::get('access_token') );

            // If access token is not valid use refresh token
            if($client->isAccessTokenExpired()) {
                exit("OK");
                $refresh_token =  $client->getRefreshToken();
                $client->refreshToken($refresh_token);

                Session::put('access_token', $client->getAccessToken());
            }else{
                $client->setAccessToken(Session::get('access_token'));
            }
            print_r(Session::get('code'));
            echo "<br>";
            print_r(Session::get('access_token'));
            echo "<br>";


        } else {
            $authUrl = $client->createAuthUrl();
            #print_r($authUrl);exit;
            #$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/boot_fun/callback';
            return redirect()->to($authUrl);
        }
    }

    /**
     * CallBack function for User Access using GMAIL API.
     *
     */

    public function se_boot_callback(){

        session_start();
        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                Google_Service_Gmail::GMAIL_MODIFY,
                //Google_Service_Gmail::GMAIL_SEND,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));

        $client = new Google_Client();
        $client->setAuthConfigFile(public_path().'/apis/api_for_sender_email.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/se_boot/callback');
        $client->addScope(SCOPES);
        $client->setLoginHint('');
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");



        if (! isset($_GET['code']))
        {
            echo "NOT CODE";
            exit();
            $auth_url = $client->createAuthUrl();
            return redirect()->to($auth_url);
        }else{
            #Session::flush();

            $client->authenticate($_GET['code']);


            Session::put('code', $_GET['code']);
            Session::put('access_token', $client->getAccessToken());

            #exit("OK");

            #$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/boot_fun';
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/sender-email/store';

            return redirect()->to($redirect_uri);
            #header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }


    public static function set_max_email_send($camp_id = null){
        if($camp_id){
            $semails = SenderEmail::where('campaign_id', $camp_id)->get();
        }else {
            $semails = SenderEmail::get();
        }


        // Set column max_email_send number from Smtp
        foreach($semails as $se){
            $smtp = Smtp::where('id', $se->smtp_id)->first();
            $se->max_email_send = $smtp->mails_per_day_per_email;
            $se->save();
        }

        return redirect()->back();
    }

}