<?php

namespace App\Http\Controllers;

use App\Message;
use Validator;
use App\Campaign;
use App\FollowupSubMessageAttachment;
use App\FollowupMessage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use File;
use Session;
use DB;

class MessageFollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($campaign_id)
    {
        $pageTitle = " Message Followup ";
        $data = FollowupMessage::with('relCampaign')->where('campaign_id','=',$campaign_id)->orderBy('id', 'DESC')->paginate(100);
//        $c_id = Campaign::lists('name','id');
        $data1 = FollowupMessage::where('campaign_id',$campaign_id)->orderBy('created_at', 'desc')->first();

        if($data1 == null){
            $order = 1;
        }
        else{
            $order = $data1->order +1;
        }
        $message_followup_id = FollowupMessage::lists('html','id');
        return view('message_followup.index', ['data' => $data, 'pageTitle'=> $pageTitle,'campaign_id'=>$campaign_id,'message_followup_id'=>$message_followup_id,'order'=>$order]);
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
    public function store(Requests\MessageFollowupRequest $request)
    {
        $input = Input::all();
        $model1 = new FollowupMessage();
        //print_r($input);exit;
        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $data = $model1::create($input); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully updated!');
        }catch (Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Invalid Request" );
        }
            $files = Input::file('file_name');
        if($files) {

            foreach ($files as $file) {
                if (!empty($file)) {
                    $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx');
                    $validator = Validator::make(array('file' => $file), $rules);
                    if ($validator->passes()) {
                        // Files destination
                        $destinationPath = 'uploads/msg_followup';
                        // Create folders if they don't exist
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                        $model2 = new FollowupSubMessageAttachment();
                        $model2->followup_sub_message_id = $data->id;

                        $file_type = $file->getMimeType();
                        $file_type = explode("/", $file_type);

                        $model2->file_type = $file_type[0];
                        //$model2->file_type = $file->getMimeType();
                        $model2->file_size = $file->getSize();

                        $extension = $file->getClientOriginalName();
                        $original_name = str_random(12) . '' . $extension;
                        $file_name = strtolower($original_name);
                        $destinationPath = 'uploads/msg_followup';
                        $file->move($destinationPath, $file_name);

                        $model2->file_name = $destinationPath . '/' . $file_name;
                        /* Transaction Start Here */
                        DB::beginTransaction();
                        try {

                            $model2->save(); // store / update / code here

                            DB::commit();
                            Session::flash('flash_message', 'Successfully updated!');
                        } catch (Exception $e) {
                            //If there are any exceptions, rollback the transaction`
                            DB::rollback();
                            Session::flash('flash_message_error', "Invalid Request");
                        }

                    }
                }
            }
        }
            Session::flash('flash_message', 'FollowupMessage successfully Added!');
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
        $data = FollowupMessage::with('relCampaign')->findOrFail($id);
        $followup_attachment = FollowupSubMessageAttachment::where('followup_sub_message_id','=',$id)->get();
        //print_r($followup_attachment);exit;
        return view('message_followup.view', ['data' => $data, 'pageTitle'=> $pageTitle,'followup_attachment' => $followup_attachment]);
    }

    public function image_show($id){
        $pageTitle = 'Image';
        $image = FollowupSubMessageAttachment::where('id','=',$id)->get();
        return view('message_followup.view_image', [
            'pageTitle'=> $pageTitle, 'image'=>$image
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = FollowupMessage::with('relCampaign')->findOrFail($id);
        $campaign_id = FollowupMessage::with('relCampaign')->findOrFail($id)->campaign_id;
        $followup_attachment = FollowupSubMessageAttachment::where('followup_sub_message_id','=',$id)->get();

        return view('message_followup.update', ['data'=>$data,'campaign_id'=>$campaign_id , 'followup_attachment' => $followup_attachment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\MessageFollowupRequest $request, $id)
    {

        $input = $request->all();
        $model1 = FollowupMessage::findOrFail($id);

        DB::beginTransaction();
        try {

            $model1->fill($input)->save(); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully updated!');
        }catch (Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Invalid Request" );
        }
            $files = Input::file('file_name');
        if($files) {
            foreach ($files as $file) {
                if (!empty($file)) {
                    $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx');
                    $validator = Validator::make(array('file' => $file), $rules);
                    if ($validator->passes()) {
                        // Files destination
                        $destinationPath = 'uploads/msg_followup';
                        // Create folders if they don't exist
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                        $model2 = new FollowupSubMessageAttachment();
                        $model2->followup_sub_message_id = $model1->id;

                        $file_type = $file->getMimeType();
                        $file_type = explode("/", $file_type);

                        $model2->file_type = $file_type[0];
                        //$model2->file_type = $file->getMimeType();
                        $model2->file_size = $file->getSize();

                        $extension = $file->getClientOriginalName();
                        $original_name = str_random(12) . '' . $extension;
                        $file_name = strtolower($original_name);
                        $destinationPath = 'uploads/msg_followup';
                        $file->move($destinationPath, $file_name);

                        $model2->file_name = $destinationPath . '/' . $file_name;
                        /* Transaction Start Here */
                        DB::beginTransaction();
                        try {

                            $model2->save(); // store / update / code here

                            DB::commit();
                        } catch (Exception $e) {
                            //If there are any exceptions, rollback the transaction`
                            DB::rollback();
                            Session::flash('flash_message_error', "Invalid Request");
                        }

                    }
                }
            }
        }

        Session::flash('flash_message', 'FollowupMessage successfully updated!');
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
            $model = FollowupMessage::findOrFail($id);
            if ($model->delete()) {
                Session::flash('flash_message', "Successfully Deleted.");
                return redirect()->back();
            }
        } catch
        (\Exception $ex) {
            Session::flash('error_message', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
            return redirect()->back();
        }
    }
    public function destroy_file($id)
    {
        try {
            $model = FollowupSubMessageAttachment::findOrFail($id);
            if ($model->delete()) {
                //Session::flash('flash_message', "Successfully Deleted.");
                return 'Success Fully deleted';
            }
        } catch
        (\Exception $ex) {
            Session::flash('error_message', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
            return redirect()->back();
        }
    }
}
