<?php

namespace App\Http\Controllers;

use App\PoppedMessageHeader;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Input;
use Illuminate\Support\Facades\DB;


class EmailThreadController extends Controller
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
        try {
            $model = PoppedMessageHeader::where('id', $id)->update(['status' => 'inactive']);
            Session::flash('flash_message', "Mail Thread Successfully Deleted.");
        } catch(\Exception $ex) {
            Session::flash('flash_message_error', $ex->getMessage());
       }
        return redirect()->back();
    }

    public function all_destroy()
    {

        $thread_ids = Input::get('ids');

        try {
            foreach($thread_ids as $ids) {
                $model = PoppedMessageHeader::where('id', $ids)->update(['status' => 'inactive']);
            }
            Session::flash('flash_message', "Mail Thread Successfully Deleted.");
        } catch(\Exception $ex) {
            Session::flash('flash_message_error', 'Check/Select the Mail Thread First');
        }
        return redirect()->back();
    }

    public function inactive_list()
    {
        $pageTitle = "Email Message Thread";

        $data = DB::table('popped_message_header')
            ->join('popped_message_detail', function ($join) {
                $join->on('popped_message_header.id', '=', 'popped_message_detail.popped_message_header_id');
            })->select('popped_message_header.id','user_email','user_name', 'subject','message_order','campaign_id','status')
            ->where('status', '=', 'inactive')
            ->groupBy('popped_message_header.id')->get();

        return view('mail_thread.inactive_list', [
            'data' => $data,'pageTitle'=> $pageTitle,
        ]);
    }


    public function active($id)
    {

        try {
            $model = PoppedMessageHeader::where('id', $id)->update(['status' => 'queued']);
            Session::flash('flash_message', "Mail Thread Successfully Activated.");
        } catch(\Exception $ex) {
            Session::flash('flash_message_error', $ex->getMessage());
        }

        return redirect()->back();
    }

    public function all_active()
    {

        $thread_ids = Input::get('ids');

        try {
            foreach($thread_ids as $ids) {
                $model = PoppedMessageHeader::where('id', $ids)->update(['status' => 'queued']);
            }
            Session::flash('flash_message', "Mail Thread Successfully Activated.");
        } catch(\Exception $ex) {
            Session::flash('flash_message_error', 'Check/Select the Mail Thread First');
        }
        return redirect()->back();
    }


}
