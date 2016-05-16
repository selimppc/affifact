<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use adLDAP\adLDAP;
use App\Filter;
use App\Helpers\EmailSend;
use App\Helpers\SenderEmailCheck;
use App\PoppedMessageDetail;
use App\PoppedMessageHeader;
use App\SenderEmail;
use DB;
use Illuminate\Support\Facades\Config;
use Session;
use App\Helpers\Xmlapi;
use App\Imap;
use App\Smtp;
use Illuminate\Support\Facades\Input;
use Queue;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserResetPassword;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home_dashboard(){
        $pageTitle = " Welcome to Affi Fact";
        $now = date('Y-m-d H:i:s');
        $last_24 = date('Y-m-d H:i:s', time() - 86400);
         // Last 24 hours data
        $mail_read_total = PoppedMessageDetail::whereNull('sub_message_id')
            ->whereNull('followup_sub_message_id')
            ->whereBetween('created_at', [$last_24, $now])
            ->count();
        $mail_sent_total = PoppedMessageDetail::whereNotNull('sub_message_id')->orwhereNotNull('followup_sub_message_id')
            ->whereBetween('created_at', [$last_24, $now])
            ->count();

        // Campaign wise
        //only campaign wise mail sent --------------------------------
        $campaign_wise_data_mail_sent = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })

             ->whereNotNull('read_dt.sub_message_id')
             ->orwhereNotNull('read_dt.followup_sub_message_id')
            //->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_read, count(sent_dt.id) as mail_sent'))
            ->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_sent'))
            ->groupBy('hd.campaign_id')
            ->get();

        //only campaign wise mail read --------------------------------
        $campaign_wise_data_mail_read =
            DB::table('popped_message_detail as read_dt')
                ->join('popped_message_header as hd', function ($join) {
                    //$join->on('read_dt.id', '=', 'read_dt.popped_message_header_id')
                    $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
                })

                ->whereNull('read_dt.sub_message_id')
                ->whereNull('read_dt.followup_sub_message_id')
                //->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_read, count(sent_dt.id) as mail_sent'))
                ->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_read'))
                ->groupBy('hd.campaign_id')
                ->get();

        // Sender Email wise
        $sender_email_wise_camp_mail_read = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            ->join('sender_email as se', function ($join) {
                $join->on('hd.sender_email_id', '=', 'se.id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->whereNull('read_dt.sub_message_id')
            ->whereNull('read_dt.followup_sub_message_id')
           // ->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_read, count(sent_dt.id) as mail_sent, se.email as sender_email, se.count, smtp.mails_per_day_per_email'))
            ->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_read, se.email as sender_email, se.count, smtp.mails_per_day_per_email'))
            ->groupBy('hd.campaign_id')
            ->get();

        $sender_email_wise_camp_mail_sent = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');
            })
            /*->join('sender_email as se', function ($join) {
                $join->on('hd.sender_email_id', '=', 'se.id');
            })*/
            ->join('sender_email as se', function ($join) {
                $join->on('read_dt.sender_email', '=', 'se.email');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->whereNotNull('read_dt.sub_message_id')
            ->orwhereNotNull('read_dt.followup_sub_message_id')
            ->orwhereNotNull('read_dt.custom_message')
            // ->select(DB::raw('hd.campaign_id, count(read_dt.id) as mail_read, count(sent_dt.id) as mail_sent, se.email as sender_email, se.count, smtp.mails_per_day_per_email'))
            ->select(DB::raw('count(read_dt.id) as mail_sent,se.email as sender_email'))
            ->groupBy('hd.campaign_id')
            ->get();

        $sender_email_wise_camp = DB::table('popped_message_detail as read_dt')
            ->join('popped_message_header as hd', function ($join) {
                $join->on('hd.id', '=', 'read_dt.popped_message_header_id');

            })
            ->join('popped_message_detail as sent_dt', function ($join) {
                $join->on('hd.id', '=', 'sent_dt.popped_message_header_id');
            })
            ->join('sender_email as se', function ($join) {
                $join->on('hd.sender_email_id', '=', 'se.id');
            })
            ->join('smtp as smtp', function ($join) {
                $join->on('se.smtp_id', '=', 'smtp.id');
            })
            ->select(DB::raw('hd.campaign_id, se.email as sender_email, se.count, smtp.mails_per_day_per_email'))
            ->groupBy('sender_email')
            ->get();
        //print_r($sender_email_wise_camp);exit;

        return view('home.dashboard_new', [
            'mail_read_total'=>$mail_read_total,
            'mail_sent_total'=>$mail_sent_total,
            //'campaign_wise_data'=>$campaign_wise_data,
            'campaign_wise_data_mail_read'=>$campaign_wise_data_mail_read,
            'campaign_wise_data_mail_sent'=>$campaign_wise_data_mail_sent,
            'sender_email_wise_camp'=>$sender_email_wise_camp,
            'sender_email_wise_camp_mail_read'=>$sender_email_wise_camp_mail_read,
            'sender_email_wise_camp_mail_sent'=>$sender_email_wise_camp_mail_sent,
            'pageTitle'=> $pageTitle
        ]);
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
        //
    }
}
