<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Input;
//use App\Http\Requests;
use Session;
use Mail;
use App\Jobs\SendReminderEmail;





class QueueMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function send_email_queue()
    {
        for($i=0;$i<5;$i++)
        {
            $user = "shajjadhossain81@gmail.com";

            $job = (new SendReminderEmail($user))->delay(60 * $i);


            $this->dispatch($job);
        }

        //echo "OK";exit;
    }

    /*public function send_email_queue()
    {
        $emailList = array();
        $emailList[]='shajjad@edutechsolutionsbd.com';

        $confirmation_code = '';

        try
        {
            Mail::later(60,'imap.mail', array('link' => $confirmation_code),  function($message) use ($emailList)
            {
                $message->from('test@edutechsolutionsbd.com', 'Mail Notification');
                $message->to($emailList);
                $message->subject('Notification');
                $message->cc('shajjadhossain81@gmail.com');
                $message->bcc('shajjadhossain81@yahoo.com');
            });
            Session::flash('flash_message', 'Mail Sent Successfully !');
        }catch(\Exception $e){
            Session::flash('flash_message_error', "Mail Not Sent !!!" );
        }

        return redirect()->route('imap.index');

    }*/
}
