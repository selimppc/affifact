<?php

namespace App\Http\Controllers;

use App\Helpers\EmailSend;
use App\Helpers\SenderEmailCheck;
use App\SenderEmail;
use App\SendMailFailed;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Helpers\GmailSendMessage;

class SendMailFailedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Failed Email';
        $data = SendMailFailed::orderBy('no_of_try', 'ASC')
            ->orderBy('id', 'ASC')
            ->paginate(200);
        return view('send_mail_failed.index', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //send all failed email -------------
    public function single_send($id)
    {
        $data = SendMailFailed::findOrFail($id);
        #$check = SenderEmailCheck::sender_email_checking_byEmail($data->from_email);
        //if valid sender email then resend email--------------------
        $host = $data->host;
        $port = $data->port;
        $from_email = $data->from_email;
        $from_name = $data->from_name;
        $username = $data->username;
        $password = $data->password;
        $to_email  = $data->to_email;
        $subject = $data->subject;
        $body = $data->body;
        if($data->file_name)
            $file_name = explode(":",$data->file_name);
        else
            $file_name = null;
        $reply_to = $data->reply_to;
        $reply_to_name = $data->reply_to_name;
        $campaign_id = $data->campaign_id;
        $auth_token = $data->auth_token ;
        $auth_code = $data->auth_code;
        $popped_message_detail_id = $data->popped_message_detail_id;


        if($host == "smtp.gmail.com"){
            // checking valid email
            $se_email = GmailSendMessage::check_valid_gmail($from_email, $auth_token);

            if($se_email){
                if($se_email['status'] == 'valid_existing')
                    $result = GmailSendMessage::sendMessage($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $auth_token, $auth_code, $popped_message_detail_id);
                else {
                    $result = GmailSendMessage::sendMessage($host, $port, $se_email['email'], $from_name, $username, $password, $to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $se_email['auth_token'], $auth_code, $popped_message_detail_id);
                }
            }else{
                // This false will send this item to failed mail as no valid sender email
                $result = false;
            }
        }else{
            $result = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id, $popped_message_detail_id);
        }

        #$send = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id);
        if($result === true){
            $smf = SendMailFailed::find($data->id);
            DB::beginTransaction();
            try{
                $smf->delete();
                DB::commit();
                Session::flash('flash_message', 'Successfully Sent Failed Email!');
            }catch(\Exception $ex){
                DB::rollback();
                Session::flash('flash_message_error', $ex );
            }
        }else{
            Session::flash('flash_message_error', "Limit exceed OR Invalid OR email specific error for  ". $from_email );
        }

        return redirect()->route('failed-mail/index');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = SendMailFailed::findOrFail($id);

        DB::beginTransaction();
        try {
            $model->delete(); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully Deleted!');
        }catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', $e->getMessage());
        }

        return redirect()->route('failed-mail/index');
    }

    //batch delete send mail failed ---------------------
    public function batch_delete(){

        DB::beginTransaction();
        try {
            DB::table('send_mail_failed')->truncate(); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully Deleted!');
        }catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', $e->getMessage());
        }

        return redirect()->route('failed-mail/index');

    }

    /*
     * Batch Send Failed email
     *
     * */
    public function batch_send(){
        $failed_email_ids = Input::get('send_failed_ids');
       /* foreach($failed_email_ids as $sm){
            Session::push('teams', $sm);
        }
        $teams = Session::pull('teams');*/
        if(count($failed_email_ids)>0) {
            foreach($failed_email_ids as $smf){
                $data = SendMailFailed::findOrFail($smf);
                $check = SenderEmailCheck::sender_email_checking_byEmail($data->from_email);
                //if valid sender email then resend email--------------------
                if($check === true){
                    $host = $data->host;
                    $port = $data->port;
                    $from_email = $data->from_email;
                    $from_name = $data->from_name;
                    $username = $data->username;
                    $password = $data->password;
                    $to_email  = $data->to_email;
                    $subject = $data->subject;
                    $body = $data->body;
                    if($data->file_name)
                        $file_name = explode(":",$data->file_name);
                    else
                        $file_name = null;
                    $reply_to = $data->reply_to;
                    $reply_to_name = $data->reply_to_name;
                    $campaign_id = $data->campaign_id;

                    $send = EmailSend::reply_email($host, $port, $from_email,$from_name,$username,$password,$to_email, $subject, $body, $file_name, $reply_to, $reply_to_name, $campaign_id);
                    if($send === true){
                        $smf = SendMailFailed::find($data->id);
                        DB::beginTransaction();
                        try{
                            $smf->delete();
                            DB::commit();
                            //Session::flash('flash_message', 'Successfully Sent Failed Email!');
                            Session::push('send_email_success', 'Successfully sent To Email: '.$to_email.'->From_email: '.$from_email);
                        }catch(\Exception $ex){
                            DB::rollback();
                            Session::push('send_email_error', $ex);
                        }
                    }else{
                        Session::push('send_email_error', "Valid sender email: '".$from_email."' but it shows the error: To Email ".$to_email." Error: ".$send );
                    }
                }else{
                    Session::push('send_email_error', "Sender Email: ".$data->from_email." is not valid." );
                }

            }

        }else{
            Session::flash('flash_message_error', 'No eamil select');
        }
        return redirect()->route('failed-mail/index');
    }
}
