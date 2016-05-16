<?php

namespace App\Http\Controllers;

use App\EmailQueue;
use App\FollowupMessage;
use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use App\Message;
use App\MessageFollowup;
use App\PoppedMessageDetail;
use App\PoppedMessageHeader;
use App\SenderEmail;
use App\SubMessage;
use App\SubMessageAttachment;
use DB;
use App\Campaign;
use App\PoppingEmail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Mockery\CountValidator\Exception;
use Session;
use Input;

class CampaignController extends Controller
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


    public function index()
    {
        $pageTitle = " Campaign ";
        if($this->isPostRequest()){
            $campaign_name = Input::get('name');
            $popping_email = Input::get('popping_email_id');
            if(empty($campaign_name)){
                $data = Campaign::with('relPoppingEmail')->where('popping_email_id','=',$popping_email)->orderBy('id', 'DESC')->paginate(100);
            } if(empty($popping_email)){
                $data = Campaign::with('relPoppingEmail')->where('name', '=', $campaign_name)->orderBy('id', 'DESC')->paginate(100);
            }
            if($campaign_name && $popping_email){
                $data = Campaign::with('relPoppingEmail')->where('name','=',$campaign_name)
                    ->where('popping_email_id','=',$popping_email)->orderBy('id', 'DESC')->paginate(100);
            }
        }else{
            $data = Campaign::with('relPoppingEmail')->orderBy('id', 'DESC')->paginate(100);
        }

        //get popping email which was not used in campaign----------------
        $popping_email_id = PoppingEmail::whereNotExists(function($query)
        {
            $query->select('*')
                ->from('campaign')
                ->whereRaw('popping_email.id = campaign.popping_email_id');
        })
            ->lists('name','id');

        //get all popping email for filter search-------------------------
        $popping_email_all = PoppingEmail::lists('name','id');
        return view('campaign.index', ['data' => $data, 'pageTitle'=> $pageTitle,'popping_email_id'=>$popping_email_id,'popping_email_all'=>$popping_email_all]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Requests\CampaignRequest $request)
    {
        $data = $request->all();
        $data['status'] = 'inactive';
        $model = new Campaign();
            DB::beginTransaction();
            try {
                $model->create($data);
                DB::commit();
                Session::flash('flash_message', "Successfully  Added");
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('flash_message_error', "Not added.Invalid Request!");
            }
        return redirect()->back();
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
        $data = Campaign::with('relPoppingEmail')->findOrFail($id);
        return view('campaign.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Campaign::with('relPoppingEmail')->findOrFail($id);
            $popping_email_id = PoppingEmail::whereNotExists(function($query)
            {
                $query->select('*')
                    ->from('campaign')
                    ->whereRaw('popping_email.id = campaign.popping_email_id');
            })
                ->lists('name','id');
        //$popping_email_id = PoppingEmail::lists('name','id');
        return view('campaign.update', ['data'=>$data,'popping_email_id'=>$popping_email_id]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CampaignRequest $request, $id)
    {
        $model = Campaign::findOrFail($id);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $model->fill($data)->save();
            DB::commit();
            Session::flash('flash_message', "Successfully  Updated");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('flash_message_error', " Not added.Invalid Request!");
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
        $campaign_data = Campaign::findOrFail($id);
        $campaign_id = $campaign_data->id;

        if($campaign_data->status=='active'){
            Session::flash('flash_message_error', "Campaign is Active. Please inactive and try to delete again!");
        }else{

            //TODO:: Popped Message header , popped message details and email queue
            DB::beginTransaction();
            $pop_head_data = PoppedMessageHeader::where('campaign_id', $campaign_id)->get();
            foreach ($pop_head_data as $popped_head) {
                PoppedMessageDetail::where('popped_message_header_id', $popped_head->id)->delete();
                EmailQueue::where('popped_message_header_id', $popped_head->id)->delete();
                PoppedMessageHeader::where('id', $popped_head->id)->delete();
            }

            //TODO:: Start Follwup Message ,Followup Sub Message ,Followup Sub Message Attachment
            $follw_msg_data = FollowupMessage::where('campaign_id', $campaign_id)->get();
            foreach ($follw_msg_data as $follw_msg) {
                $follw_sub_msg_data = FollowupSubMessage::where('followup_message_id', $follw_msg->id)->get();
                foreach ($follw_sub_msg_data as $follw_sub_msg) {
                    FollowupSubMessageAttachment::where('followup_sub_message_id', $follw_sub_msg->id)->delete();
                }
                FollowupSubMessage::where('followup_message_id', $follw_msg->id)->delete();
            }
            FollowupMessage::where('campaign_id', $campaign_id)->delete();

            //TODO:: Message || Sub Message || Sub Message Attachment
            $msg_data = Message::where('campaign_id', $campaign_id)->get();
            foreach($msg_data as $msg){
                $sub_msg_data = SubMessage::where('message_id', $msg->id)->get();
                foreach($sub_msg_data as $val_sub_msg){
                    SubMessageAttachment::where('sub_message_id', $val_sub_msg->id)->delete();
                }
                SubMessage::where('message_id', $msg->id)->delete();
            }
            Message::where('campaign_id', $campaign_id)->delete();


            //TODO::campaign  , sender email delete
            $not_deleted_emails_for_domain = null;
            try {
                $sender_email_data = SenderEmail::where('campaign_id', $campaign_id)->get();
                foreach ($sender_email_data as $sender_email) {
                    $sender_email_id = $sender_email->id;
                    $sender_email_type = $sender_email->type;
                    $email = $sender_email->email;
                    if ($sender_email_type == 'generated') {
                        //delete from cpanel------------------
                        $sender_details = SenderEmail::with('relSmtp')->where('id', '=', $sender_email_id)->first();
                        $smtp_details = $sender_details->relSmtp;
                        $email = explode('@', $email);
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
                            $not_deleted_emails_for_domain[] = $sender_email->email;
                        }
                    }
                    SenderEmail::where('id', $sender_email_id)->delete();
                }
                //Campaign Delete
                Campaign::where('id', $campaign_id)->delete();

                // Finally Commit
                DB::commit();

                if($not_deleted_emails_for_domain) {
                    //Store $not_deleted_emails_for_domain to any CSV or txt
                    //$not_deleted_emails_for_domain
                    // make directory
                    $dir = public_path();
                    if(file_exists($dir)){
                        if(fileperms($dir) != 0755){
                            umask(0);
                            chmod($dir, 0755);
                        }
                        $fl = '/';
                    }else{
                        umask(0);  // helpful when used in linux server
                        mkdir ($dir, 0755);
                        $fl = '/';
                    }
                    $dir = $dir."/uploads";
                    if ( !file_exists($dir) ) {
                        umask(0);  // helpful when used in linux server
                        mkdir ($dir, 0755);
                        $fl = '/uploads';
                    }else{
                        $fl = '/uploads';
                    }

                    $dir = $dir."/campaign_se";
                    if ( !file_exists($dir) ) {
                        umask(0);  // helpful when used in linux server
                        mkdir ($dir, 0755);
                        $fl = '/uploads/campaign_se';
                    }else{
                        $fl = '/uploads/campaign_se';
                    }

                    $file_name_gen = uniqid().".txt";
                    $file_name = $dir.'/'.$file_name_gen;
                    $file_link =URL::to($fl.'/'.$file_name_gen);
                    $handle = fopen($file_name, "w");

                    foreach($not_deleted_emails_for_domain as $arr)
                    {
                        fwrite($handle, $arr."\r\n");
                    }
                    fclose($handle);

                    Session::flash('flash_message_error', "Campaing is deleted successfully but couple of domain emails are not deleted from server. Please check the '".$file_link."' file.'");
                }else{
                    Session::flash('flash_message', "Successfully delete campaign !!!" );
                }

            }catch (Exception $ex){
                DB::rollback();
                Session::flash('flash_message_error', $ex->getMessage());
            }
        }

        return redirect()->back();
    }


    /**
     * Change Campaign STat
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_stat_active($id)
    {
        $check_message = Message::where('campaign_id', $id)->first();
        $sender_email = SenderEmail::where('campaign_id', $id)->having('status', '=', 'domain')->get();

        if(count($check_message)>0 && count($sender_email)>0 ){
            $check_sub_message = SubMessage::where('message_id', $check_message->id)->get();
            if(count($check_sub_message)>0){
                try {
                    $model = Campaign::findOrFail($id);
                    $model->status = 'active';
                    $model->save();
                    Session::flash('flash_message', "Successfully Activated.");
                } catch(\Exception $ex) {
                    Session::flash('flash_message_error', 'Invalid Request !');
                }
            }else{
                Session::flash('flash_message_error', 'Sub-Message is Not Found!');
            }
        }else{
            Session::flash('flash_message_error', 'Message / Sender Email is Not Found. There should be at least one domain email !');
        }
        return redirect()->back();
    }

    /**
     * Change Campaign STat
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_stat_inactive($id)
    {
        $check_message = Message::where('campaign_id', $id)->first();
        $sender_email = SenderEmail::where('campaign_id', $id)->get();
       /* if(count($check_message)>0 && count($sender_email)>0 ){
            $check_sub_message = SubMessage::where('message_id', $check_message->id)->get();
            if(count($check_sub_message)>0){*/
                try {
                    $model = Campaign::findOrFail($id);
                    $model->status = 'inactive';
                    $model->save();
                    Session::flash('flash_message', "Successfully Deactivated.");
                } catch(\Exception $ex) {
                    Session::flash('flash_message_error', 'Invalid Request !');
                }
        /* }else{
             Session::flash('flash_message_error', 'Sub-Message is Not Found!');
         }
     }else{
         Session::flash('flash_message_error', 'Message / Sender Email is Not Found !');
     }*/
        return redirect()->back();
    }
}
