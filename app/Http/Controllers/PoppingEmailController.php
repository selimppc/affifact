<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Requests\PoppingEmailRequest;
use App\PoppingEmail;
use App\SenderEmail;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Imap;
use App\Smtp;
use Illuminate\Support\Facades\Validator;
#use App\Http\Requests\Request;
#use App\Http\Controllers\Controller;
use Google_Service_Gmail;
use Google_Service_Gmail_ModifyMessageRequest;
use Google_Client;
use Laravel\Socialite\Facades\Socialite;
use Google_Service_Books;
use Google_Auth_AssertionCredentials;
use Google_Service_Datastore;
use Google_Service_Urlshortener;
use Google_Service_Urlshortener_Url;
use App\User;



use Session;

use Input;

class PoppingEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pageTitle = " Popping Email ";

        $popmail_filter_name = Input::get('popmail_filter');

        if($popmail_filter_name){
            $data = PoppingEmail::where('name','LIKE','%'.$popmail_filter_name.'%')
                ->orderBy('id', 'DESC')->paginate(100);
        }else{
            $data = PoppingEmail::orderBy('id', 'DESC')->paginate(100);
        }
        //$data = PoppingEmail::with('relSmtp','relImap')->paginate(5);
        $smtp_id = Smtp::lists('name','id');
        $imap_id = Imap::lists('name','id');
        $camp_id = Campaign::lists('name','id');
        //print_r($camp_id);exit;
        return view('popping_email.index', ['data' => $data, 'pageTitle'=> $pageTitle,'smtp_id'=>$smtp_id,'imap_id'=>$imap_id,'camp_id'=>$camp_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //store popping email with mail server authentication-----------------
    public function store(Request $request)
    {
        $input = $request->all();
        if(Session::has('popping_input')){
            $session_all = Session::get('popping_input');
            $smtp_id =$session_all['smtp_id'];
            $smtp_h = Smtp::findOrNew($smtp_id);
            $smtp_host = $smtp_h['host'];
            $email = $session_all['email'];
        }else{
            $smtp_h = Smtp::findOrNew($input['smtp_id']);
            $smtp_host = $smtp_h['host'];
            $email = $input['email'];
            Session::put('popping_input', $input);
        }

        //if gmail then gmail validation using api-------------------------------
        if ($smtp_host == 'gmail.com' || $smtp_host == 'smtp.gmail.com') {
            //return Socialite::driver('google')->with(['login_hint' => $email])->redirect();
            define('SCOPES', implode(' ', array(
                    Google_Service_Gmail::MAIL_GOOGLE_COM,
                    Google_Service_Gmail::GMAIL_COMPOSE,
                    Google_Service_Gmail::GMAIL_READONLY,
                    Google_Service_Gmail::GMAIL_MODIFY,
                    "https://www.googleapis.com/auth/urlshortener"
                )
            ));
            $client = new Google_Client();
            $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
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
                $input_data = Session::get('popping_input');
                $data = [
                    'name'=>$input_data['name'],
                    'email'=>$input_data['email'],
                    'password'=>$input_data['password'],
                    'smtp_id'=>$input_data['smtp_id'],
                    'imap_id'=>$input_data['imap_id'],
                    'auth_email'=>$input_data['email'],
                    'auth_type'=>'google',
                    'token'=>$token,
                    'code' => $code,
                ];

                $name_exists = PoppingEmail::where('name', $input_data['name'])->exists();
                if($name_exists){
                    Session::flash('flash_message_error', "This Email Name already exists." );
                }else{
                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {
                        $model = new PoppingEmail();
                        // store / update / code here
                        $model->create($data);

                        //clean session
                        Session::forget('access_token');
                        Session::forget('code');
                        Session::forget('popping_input');

                        DB::commit();
                        Session::flash('flash_message', 'Successfully added!');

                    }catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction`
                        Session::forget('popping_input');
                        DB::rollback();
                        Session::flash('flash_message_error', "Invalid Request" );
                        //return redirect()->route('popping_email.index');
                    }
                    #$request->session()->forget('popping_input');
                }
                return redirect()->route('popping_email.index');
            } else {
                $authUrl = $client->createAuthUrl();
                return redirect()->to($authUrl);
            }
        } else {
            $imap = Imap::findOrNew($input['imap_id']);
            // Identify the status
            $status = SenderEmail::EmailTypeIdentification($input['email'], 'status');
            // do the validation
            if ($status == 'domain')
                $pre_text = 'mail.';
            else
                $pre_text = '';

            try {
                $hostname = '{' . $pre_text . $imap->host . ':993/imap/ssl/novalidate-cert}INBOX';
                $username = $input['email'];
                $password = $input['password'];
                $inbox = imap_open($hostname, $username, $password);

                /* Transaction Start Here */
                DB::beginTransaction();
                try {
                    // store / update / code here
                    PoppingEmail::create($input);
                    if(Session::has('popping_input')) {
                        Session::forget('popping_input');
                    }

                    DB::commit();
                    Session::flash('flash_message', 'Successfully added!');
                } catch (Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    Session::flash('flash_message_error', "Invalid Request");
                }
            } catch (\Exception $e) {
                Session::flash('flash_message_error', $e->getMessage());
            }
        }
        return redirect()->back();
    }

    public function store_popping_email($data, $input_value){
        $insert_data = [
            'name'=>$input_value['name'],
            'email'=>$input_value['email'],
            'password'=>$input_value['password'],
            'smtp_id'=>$input_value['smtp_id'],
            'imap_id'=>$input_value['imap_id'],
            'token'=>$data['token'],
            'code'=>$data['code'],
            'auth_id'=>$data['user_id'],
            'auth_email'=>$data['email_address'],
            'auth_type'=>'google'
        ];

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            // store / update / code here
            PoppingEmail::create($insert_data);

            DB::commit();
            return true;
        }catch (Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            return false;
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
        $data = PoppingEmail::with('relSmtp','relImap')->findOrFail($id);

        return view('popping_email.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PoppingEmail::with('relSmtp','relImap')->findOrFail($id);
        $smtp_id = Smtp::lists('name','id');
        $imap_id = Imap::lists('name','id');

        return view('popping_email.update', ['data'=>$data,'smtp_id'=>$smtp_id,'imap_id'=>$imap_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = PoppingEmail::findOrFail($id);
        $input = $request->all();
        $imap = Imap::findOrNew($input['imap_id']);

        $status = SenderEmail::EmailTypeIdentification($input['email'], 'status');

        // do the validation
        if($status == 'domain')
            $pre_text = 'mail.';
        else
            $pre_text = '';

        $hostname = '{'.$pre_text.$imap->host.':993/imap/ssl/novalidate-cert}INBOX';
        $username = $input['email'];

        if(empty($input['password']))
            $password = $input['password'] = $model->password;
        else
            $password = $input['password'];

        try{
            $inbox = imap_open($hostname,$username,$password);

            // Transaction Start Here
            DB::beginTransaction();
            try {
                $rules = [
                    'name' => 'required|max:64|unique:popping_email,name,'.$id,
                    'email' => 'required|max:128',
                    'password' => 'required|max:64',
                    'smtp_id' => 'required',
                    'imap_id' => 'required',
                ];

                $validator = Validator::make($input, $rules);
                if(!$validator->passes()){
                    Session::flash('flash_message', $validator->errors());
                }else{
                    $model->update($input);
                    DB::commit();
                    Session::flash('flash_message', 'Successfully Updated!');
                }
            }catch (Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('flash_message_error', "Invalid Request" );
            }
        }catch(\Exception $e){
            Session::flash('flash_message_error', 'Error: '.$e->getMessage() );
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $model = PoppingEmail::findOrFail($id);
        DB::beginTransaction();
        DB::statement("SET foreign_key_checks = 0");
        $campaign = Campaign::with('relPoppingEmail')->where('popping_email_id',$id)->exists();
        try{
            if($campaign){
                // delete campaign
                Campaign::where('popping_email_id',$id)->update(['status' => 'inactive', 'popping_email_id' => null]);
                // delete popping email
                $model->forceDelete($id);
            }else{
                $model->forceDelete($id);
            }
            DB::commit();
            Session::flash('flash_message', "Successfully Deleted popping email and campaign is inactivated.");
        }catch(\Exception $e){
            DB::rollback();
            Session::flash('flash_message_error', $e->getMessage());
        }
        return redirect()->back();
    }




    /*
     *
     * Verify your email
     *
     */
    function verifyEmail($toemail, $fromemail, $getdetails = false){
        $email_arr = explode("@", $toemail);
        $domain = array_slice($email_arr, -1);
        $domain = $domain[0];
        $details = '';

        // Trim [ and ] from beginning and end of domain string, respectively
        $domain = ltrim($domain, "[");
        $domain = rtrim($domain, "]");

        if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) {
            $domain = substr($domain, strlen("IPv6") + 1);
        }

        $mxhosts = array();
        if( filter_var($domain, FILTER_VALIDATE_IP) )
            $mx_ip = $domain;
        else
            getmxrr($domain, $mxhosts, $mxweight);

        if(!empty($mxhosts) )
            $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
        else {
            if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
                $record_a = dns_get_record($domain, DNS_A);
            }
            elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
                $record_a = dns_get_record($domain, DNS_AAAA);
            }

            if( !empty($record_a) )
                $mx_ip = $record_a[0]['ip'];
            else {

                $result   = "invalid";
                $details .= "No suitable MX records found.";

                return ( (true == $getdetails) ? array($result, $details) : $result );
            }
        }

        $connect = @fsockopen($mx_ip, 25);
        if($connect){
            if(preg_match("/^220/i", $out = fgets($connect, 1024))){
                fputs ($connect , "HELO $mx_ip\r\n");
                $out = fgets ($connect, 1024);
                $details .= $out."\n";

                fputs ($connect , "MAIL FROM: <$fromemail>\r\n");
                $from = fgets ($connect, 1024);
                $details .= $from."\n";

                fputs ($connect , "RCPT TO: <$toemail>\r\n");
                $to = fgets ($connect, 1024);
                $details .= $to."\n";

                fputs ($connect , "QUIT");
                fclose($connect);

                if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){
                    $result = "invalid";
                }
                else{
                    $result = "valid";
                }
            }
        }
        else{
            $result = "invalid";
            $details .= "Could not connect to server";
        }
        if($getdetails){
            return array($result, $details);
        }
        else{
            return $result;
        }
    }


    public function google_api_auth_store(){
        session_start();
        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                Google_Service_Gmail::GMAIL_MODIFY,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));

        $client = new Google_Client();
        $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
        $client->addScope(SCOPES);
        $client->setLoginHint('');
        $client->setAccessType('offline');

        #if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        if (Session::has('access_token')) {
            #$client->setAccessToken( Session::get('access_token') );
            // If access token is not valid use refresh token
            if($client->isAccessTokenExpired()) {
                $refresh_token =  $client->getRefreshToken();
                $client->refreshToken($refresh_token);

                Session::put('access_token', $client->getAccessToken());
            }else{
                $client->setAccessToken(Session::get('access_token'));
            }

            // Gmail Service
            $gmail_service = new \Google_Service_Gmail($client);

            // Get List of messages
            $message_data = $this->listMessages($gmail_service, "me");

            //modify messages by message_id
            foreach($message_data as $values){
                $modify_message = $this->modifyMessages($gmail_service, $values['messageId']);
            }

        } else {
            $authUrl = $client->createAuthUrl();
            #print_r($authUrl);exit;
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/boot_fun/callback';
            #return redirect()->route("google-api-auth-store-callback");
            return redirect()->to($redirect_uri);
        }
    }

    public function boot_fun_callback(){
        /*print_r($_REQUEST);
        exit();*/
        session_start();
        define('SCOPES', implode(' ', array(
                Google_Service_Gmail::MAIL_GOOGLE_COM,
                Google_Service_Gmail::GMAIL_COMPOSE,
                Google_Service_Gmail::GMAIL_READONLY,
                Google_Service_Gmail::GMAIL_MODIFY,
                "https://www.googleapis.com/auth/urlshortener"
            )
        ));

        $client = new Google_Client();
        $client->setAuthConfigFile(public_path().'/apis/complete_api_affifact.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/boot_fun/callback');
        $client->addScope(SCOPES);
        $client->setLoginHint('');
        $client->setAccessType('offline');


        if (! isset($_GET['code']))
        {
            $auth_url = $client->createAuthUrl();
            return redirect()->to($auth_url);
        }
        else
        {
            $client->authenticate($_GET['code']);
            Session::put('code', $_GET['code']);
            Session::put('access_token', $client->getAccessToken());

            //$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/boot_fun';
            return redirect()->route("google-api-auth-store");
            #header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }

}