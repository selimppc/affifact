<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Campaign;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($campaign_id)
    {
        $pageTitle = " Message ";
        $data = Message::with('relCampaign')->where('message.campaign_id','=',$campaign_id)->orderBy('id', 'asc')->paginate(100);
        //$campaign_details = Campaign::lists('name','id');
        $campaign_details =Campaign::findOrFail($campaign_id);
        return view('message.index', ['data' => $data, 'pageTitle'=> $pageTitle,'campaign_details'=>$campaign_details, 'campaign_id'=>$campaign_id]);
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
    public function store(Requests\MessageRequest $request)
    {
        /*$this->validate($request, [
            'campaign_id' => 'required',
            'html' => 'required',
            'delay' => 'required|max:255|numeric',
        ]);*/
        $input = $request->all();
        $data = Message::where('campaign_id',$request->campaign_id)->orderBy('created_at', 'desc')->first();

        if($data == null){
            $input['order'] = 1;
        }
        else{
            $input['order'] = $data->order +1;
        }


        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            Message::create($input); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully added!');
        }catch (Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Invalid Request" );
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
        $data = Message::with('relCampaign')->findOrFail($id);
        return view('message.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Message::with('relCampaign')->findOrFail($id);
        $campaign_id = Message::with('relCampaign')->findOrFail($id)->campaign_id;
        return view('message.update', ['data'=>$data,'campaign_id'=>$campaign_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\MessageRequest $request, $id)
    {
        /*$this->validate($request, [
            'html' => 'required',
            'delay' => 'required|max:255|numeric',
        ]);*/
        $model = Message::findOrFail($id);
        $input = $request->all();

        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $model->fill($input)->save(); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully Updated!');
        }catch (Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', "Invalid Request" );
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
        try {
            $model = Message::findOrFail($id);
            if ($model->delete()) {
                Session::flash('flash_message', "Successfully Deleted.");
                return redirect()->back();
            }

        } catch
        (\Exception $ex) {
            Session::flash('flash_message_error', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
            return redirect()->back();
        }
    }
}
