<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImapRequest;
use App\Imap;
use App\SenderEmail;
use DB;
use Input;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;
use Session;
use Illuminate\Http\Request;
use Mail;
use App\Jobs\SendReminderEmail;

class ImapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = " IMAP ";
        $imap_filter_name = Input::get('imap_filter');
        $imap_filter_host = Input::get('imap_filter_host');
        if($imap_filter_name){
            $data = Imap::where('name','Like','%'.$imap_filter_name.'%')->orderBy('id', 'DESC')->paginate(100);
        }
        else if($imap_filter_host){
            $data = Imap::where('host','Like','%'.$imap_filter_host.'%')->orderBy('id', 'DESC')->paginate(100);
        }
        else{
            $data = Imap::orderBy('id', 'DESC')->paginate(100);
        }

        return view('imap.index', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImapRequest $request)
    {
        $input=$request->all();
        $mail_server = $input['host'];
        $mail_port = $input['port'];

        try{
            $i = @fsockopen($mail_server, $mail_port, $errno, $errstr, 30);
            if($i){

                DB::beginTransaction();
                try {
                    Imap::create($input); // store / update / code here
                    DB::commit();
                    Session::flash('flash_message', 'Successfully added!');
                }catch (\Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    Session::flash('flash_message_error', "Invalid Request. Please Try Again" );
                }
            }else{
                Session::flash('flash_message_error', "Imap and/or port may be incorrect." );
            }
        }catch(\Exception $e){
            Session::flash('flash_message_error', $e->getMessage() );
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
        $data = Imap::findOrFail($id);
        return view('imap.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // echo $id;exit;

        $data = Imap::findOrFail($id);
        return view('imap.update', ['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImapRequest $request, $id)
    {
        $model = Imap::findOrFail($id);
        $input = $request->all();
        $mail_server = $input['host'];
        $mail_port = $input['port'];

        try{
            $i = @fsockopen($mail_server, $mail_port, $errno, $errstr, 30);
            if($i){
                /* Transaction Start Here */
                DB::beginTransaction();
                try {
                    $model->fill($input)->save(); // store / update / code here

                    DB::commit();
                    Session::flash('flash_message', 'Successfully Edited!');
                }catch (\Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    Session::flash('flash_message_error', "Invalid To insert" );
                }
            }else{
                Session::flash('flash_message_error', "Host or port might be worng." );
            }
        }catch(Exception $e){
            Session::flash('flash_message_error', $e->getMessage());
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
        $model = Imap::findOrFail($id);

        DB::beginTransaction();
        try {
            $model->delete(); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully Deleted!');
        }catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!" );
        }

        return redirect()->route('imap.index');
    }
}
