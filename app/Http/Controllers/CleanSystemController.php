<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\EmailQueue;
use App\PoppedMessageDetail;
use App\PoppedMessageHeader;
use App\SenderEmail;
use App\Smtp;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Input;
use Session;
use DB;

class CleanSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Level 1 clean up----
     * campaign,header,detail,message,submessage,followup message,followup submessage,tmp-garbage,send_mail_failed,popping_email,queue,sender email table delete----
     * --------------------
     */

    public function combing_clean(){
        DB::statement("SET foreign_key_checks = 0");
        DB::beginTransaction();
        try{
            DB::table('popped_message_header')->truncate();
            DB::table('popped_message_detail')->truncate();
            DB::table('email_queue')->truncate();
            DB::table('sender_email')->truncate();
            DB::table('campaign')->truncate();
            DB::table('message')->truncate();
            DB::table('popping_email')->truncate();
            DB::table('followup_message')->truncate();
            DB::table('followup_sub_message')->truncate();
            DB::table('followup_sub_message_attachment')->truncate();
            DB::table('sub_message_attachment')->truncate();
            DB::table('sub_message')->truncate();
            DB::table('tmp_garbage')->truncate();
            DB::table('send_mail_failed')->truncate();
            DB::commit();
            Session::flash('flash_message', "Campaign, Sender emails, Popping email, Message, Sub_message, Followup message, Followup sub message, Send mail failed, Email queue, Popped message  Successfully Deleted");
        }catch(\Exception $ex){
            DB::rollback();
            Session::flash('flash_message_error', $ex->getMessage());
        }
        return redirect()->route('settings');
    }

    /**
     * Level 2 clean up----
     * header,detail,queue,tmp-garbage,sent-failed table delete
     * sender email reset count------------------------
     */
    public function combing_clean_level2(){
        DB::statement("SET foreign_key_checks = 0");
        DB::beginTransaction();
        try{
            DB::table('popped_message_header')->truncate();
            DB::table('popped_message_detail')->truncate();
            DB::table('email_queue')->truncate();
            DB::table('tmp_garbage')->truncate();
            DB::table('send_mail_failed')->truncate();
            // Update count for sender_email
            DB::table('sender_email')->update(['count' => 0,'popping_status' =>'false']);
            DB::commit();
            Session::flash('flash_message', "Popped message, Email queue, Send Failed data Successfully Deleted and Sender Email count was reset ");
        }catch(\Exception $ex){
            DB::rollback();
            Session::flash('flash_message_error', $ex->getMessage());
        }
        return redirect()->route('settings');
    }

    /*
     * Clean System Per Campaign ...................
     */
    public function clean_system_per_campaign()
    {
        $pageTitle = 'Clean System';
        $campaign_id = Campaign::lists('name','id');
        $smtp_host = Smtp::where ('type','=','email-create')->lists('host','id');

        return view('clean_system.per_campaign.index',['pageTitle'=>$pageTitle,'campaign_id'=>$campaign_id,'smtp_host'=>$smtp_host]);
    }

    public function delete_customer_mail_per_camp(Request $request){
        //TODO day field numeric validation

        $input_days = Input::get('days');
        $rules = array('days' => 'required|numeric');
        $validator = Validator::make(array('days' => $input_days), $rules);
        if ($validator->passes()) {
            $days = -$input_days.' days';
            $days_ago = date('Y-m-d H:i:s', strtotime($days, strtotime(date('Y-m-d H:i:s'))));
            $campaign_id = Input::get('campaign_id');
            DB::statement("SET foreign_key_checks = 0");
            DB::beginTransaction();
                try{
                    $popped_message_header = PoppedMessageHeader::where('campaign_id',$campaign_id)->where('created_at','<=',$days_ago)->get(array('popped_message_header.id'));
                    foreach($popped_message_header as $hd){
                        PoppedMessageDetail::where('popped_message_header_id',$hd->id)->forceDelete();
                        EmailQueue::where('popped_message_header_id',$hd->id)->forceDelete();
                        PoppedMessageHeader::where('id', $hd->id)->forceDelete();
                    }
                    Session::flash('flash_message', "$input_days Days Older Customer Mails Successfully Deleted!!");
                    DB::commit();
                }catch(\Exception $e){
                    DB::rollback();
                    Session::flash('flash_message_error', $e->getMessage());
                }
            return redirect()->back();
            }else{
                Session::flash('flash_message_error', $validator->errors());
                return redirect()->route('clean-system');
        }
    }

    public function delete_mail_server_per_camp(Request $request){
        $host = Input::get('host');
        $campaign_id = Input::get('campaign_id');

        DB::beginTransaction();
        DB::statement("SET foreign_key_checks = 0");
        $sender_emails = SenderEmail::where('campaign_id', $campaign_id)->where('smtp_id', $host)->get(array('id'));
        if(count($sender_emails)>0) {
            try{
                foreach ($sender_emails as $se) {
                    $popped_message_header = PoppedMessageHeader::where('sender_email_id', $se->id)->get(array('id'));
                    foreach($popped_message_header as $hd){
                        PoppedMessageDetail::where('popped_message_header_id', $hd->id)->forceDelete();
                        EmailQueue::where('popped_message_header_id', $hd->id)->forceDelete();
                        PoppedMessageHeader::where('id', $hd->id)->forceDelete();
                    }
                }
                DB::commit();
                Session::flash('flash_message', "Sender Mails for ($host) Successfully Deleted");
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('flash_message_error', $e->getMessage());
            }
        }else{
            Session::flash('flash_message_error', 'No Data Found');
        }
        return redirect()->back();

    }


    public function system_wise_clean()
    {
        $pageTitle = "System Wise";
        $smtp_host = Smtp::where ('type','=','email-create')->lists('host','host');
        return view('clean_system.system_wise', ['pageTitle'=> $pageTitle,'smtp_host'=>$smtp_host]);
    }

    public function system_wise_delete()
    {
        //TODO day field numeric validation

        $custom_days = Input::get('custom_days');
        $rules = array('custom_days' => 'required|numeric');
        $validator = Validator::make(array('custom_days' => $custom_days), $rules);
        if ($validator->passes()) {
            $abc = -$custom_days . ' days';
            $days_ago = date('Y-m-d H:i:s', strtotime($abc, strtotime(date('Y-m-d H:i:s'))));

            DB::statement("SET foreign_key_checks = 0");
            $header_data = DB::table('popped_message_header')->where('created_at', '<=', $days_ago)->get();

            if (count($header_data) > 0) {
                DB::beginTransaction();
                try {
                    foreach ($header_data as $val) {
                        PoppedMessageDetail::where('popped_message_header_id', '=', $val->id)->forceDelete();
                        EmailQueue::where('popped_message_header_id', '=', $val->id)->forceDelete();
                        PoppedMessageHeader::where('id', '=', $val->id)->forceDelete();
                    }

                    Session::flash('flash_message', "$custom_days Days Older Customer mails Successfully Deleted.");
                    DB::commit();
                } catch (\Exception $ex) {
                    DB::rollback();
                    Session::flash('flash_message_error', $ex->getMessage());
                }
            } else {
                Session::flash('flash_message_error', "$custom_days Days Older Customer Mails Not Exits.");
            }
            return redirect()->route('clean-system');
        }
        else{
            Session::flash('flash_message_error', $validator->errors());
            return redirect()->route('clean-system');
        }
    }

    public function system_wise_sender_mail_delete(){
        $smtp_id = Input::get('host');
        $sender_email = SenderEmail::where('smtp_id', $smtp_id)->get();
        if(count($sender_email)> 0){
            DB::statement("SET foreign_key_checks = 0");
            DB::beginTransaction();
            try {
                foreach($sender_email as $se) {
                    $pm_header = PoppedMessageHeader::where('sender_email_id', $se->id)->get();
                    if (count($pm_header) > 0) {
                        foreach ($pm_header as $hd) {
                            PoppedMessageDetail::where('popped_message_header_id', $hd->id)->forceDelete();
                            // Delete those queue email which have this header id.
                            EmailQueue::where('popped_message_header_id', $hd->id)->forceDelete();
                        }
                    }
                    // Delete those queue email which have this sender email id
                    EmailQueue::where('sender_email_id', $se->id)->forceDelete();
                    PoppedMessageHeader::where('sender_email_id', $se->id)->forceDelete();
                }
                Session::flash('flash_message', "Successfully Cleaned .");
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('flash_message_error', $e->getMessage());
            }
        }else{
            Session::flash('flash_message_error', "No Sender Email found .");
        }
        return redirect()->route('clean-system');
    }
}
