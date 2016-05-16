<?php

namespace App\Http\Controllers;

use App\FollowupSubMessage;
use App\FollowupSubMessageAttachment;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Input;

class SubMessageFollowupController extends Controller
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
    public function index($campaign_id,$message_followup_id)
    {
        $pageTitle = "Followup Sub Message";
        $sub_message_followup_filter_title = Input::get('sub_message_followup_filter_title');
        //print_r($message_followup_id);exit();

        if($sub_message_followup_filter_title) {
            $campaign_id = Input::get('campaign_id');
            $message_followup_id = Input::get('message_followup_id');
            $data = FollowupSubMessage::with('relMessageFollowup')->where('followup_message_id','=',$message_followup_id)->where('title','Like','%'.$sub_message_followup_filter_title.'%')->orderBy('id', 'DESC')->paginate(100);
        }else{
            $data = FollowupSubMessage::with('relMessageFollowup')->where('followup_message_id','=',$message_followup_id)->orderBy('id', 'DESC')->paginate(100);
        }

        return view('sub_message_followup.index', ['data' => $data, 'pageTitle'=> $pageTitle,'message_followup_id'=>$message_followup_id,'campaign_id'=>$campaign_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_index($campaign_id,$message_followup_id){
        $pageTitle = "Followup Sub Message";
        $sub_message_followup_filter_title = Input::get('sub_message_followup_filter_title');
        //print_r($message_followup_id);exit();

        if($sub_message_followup_filter_title) {
            $campaign_id = Input::get('campaign_id');
            $message_followup_id = Input::get('message_followup_id');
            $data = FollowupSubMessage::with('relMessageFollowup')->where('followup_message_id','=',$message_followup_id)->where('title','Like','%'.$sub_message_followup_filter_title.'%')->orderBy('id', 'DESC')->paginate(100);
        }else{
            $data = FollowupSubMessage::with('relMessageFollowup')->where('followup_message_id','=',$message_followup_id)->orderBy('id', 'DESC')->paginate(100);
        }

        return view('sub_message_followup.add', ['data' => $data, 'pageTitle'=> $pageTitle,'message_followup_id'=>$message_followup_id,'campaign_id'=>$campaign_id]);
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
    public function store(Requests\SubMessageFollowupRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $sub_message_followup = FollowupSubMessage::create($input);
            DB::commit();
            Session::flash('flash_message', "Successfully  Added");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('flash_message', "  not added.Invalid Request!");
            return redirect()->back();
        }

        $sub_message_followup_id = $sub_message_followup->id;

        $files = Input::file('attchment');
        $file_count = count($files);
        foreach($files as $file) {
            if(!empty($file)) {
                $data = new FollowupSubMessageAttachment();
                //$data->file_type
                $file_type = $file->getMimeType();
                $file_type = explode("/",$file_type);
                $data->file_type = $file_type[0];
                $data->file_size = $file->getSize();

                $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,xlsx,xls,docx,pptx,ppt,pub');
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    // Files destination
                    $destinationPath = 'uploads/followup_sub_message/';


                    $file_original_name = $file->getClientOriginalName();
                    $file_name = rand(11111, 99999) . $file_original_name;
                    $upload_success = $file->move($destinationPath, $file_name);
                    $data->followup_sub_message_id = $sub_message_followup_id;
                    $data->file_name = 'uploads/followup_sub_message/'.$file_name;

                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {

                        $data->save(); // store / update / code here

                        DB::commit();
                    }catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction`
                        DB::rollback();
                        Session::flash('flash_message_error', "Invalid Request" );
                    }
                } else {
                    Session::flash('flash_message_error', 'uploaded file is not valid');
                }
            }
        }
        return redirect()->route('sub-message-followup.index',$input['campaign_id'].'/'.$input['followup_message_id']);
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
        $message_data = FollowupSubMessageAttachment::where('followup_sub_message_id','=',$id)->get();
        $data = FollowupSubMessage::with('relMessageFollowup')->findOrFail($id);
        return view('sub_message_followup.view', ['data' => $data, 'pageTitle'=> $pageTitle,'message_data'=>$message_data]);
    }
    public function image_show($id){
        $pageTitle = 'Image';
        $image = FollowupSubMessageAttachment::where('id','=',$id)->get();
        return view('sub_message_followup.view_image', [
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
        $pageTitle = 'Update the detail';
        $data = FollowupSubMessage::with('relMessageFollowup')->findOrFail($id);
        $campaign_id = $data->relMessageFollowup->campaign_id;
        $message_followup_id = FollowupSubMessage::with('relMessageFollowup')->findOrFail($id)->followup_message_id;
        $message_data = FollowupSubMessageAttachment::where('followup_sub_message_id','=',$id)->get();
        return view('sub_message_followup.update', ['data'=>$data,'message_followup_id'=>$message_followup_id,'campaign_id'=>$campaign_id,'message_data'=>$message_data,'pageTitle'=>$pageTitle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\SubMessageFollowupRequest $request, $id)
    {
        $model = FollowupSubMessage::findOrFail($id);
        $input = $request->all();
        DB::beginTransaction();
        try {
            $model->fill($input)->save();
            DB::commit();
            Session::flash('flash_message', "Successfully  Updated");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('flash_message', "  not updated.Invalid Request!");
            return redirect()->back();
        }

        $sub_message_followup_id = $model->id;
        $files = Input::file('attchment');
        $file_count = count($files);
        foreach($files as $file) {
            if(!empty($file)) {
                $data = new FollowupSubMessageAttachment();
                //$data->file_type
                $file_type = $file->getMimeType();
                $file_type = explode("/",$file_type);
                $data->file_type = $file_type[0];
                $data->file_size = $file->getSize();

                $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,xlsx,xls,docx,pptx,ppt,pub');
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    // Files destination
                    $destinationPath = 'uploads/followup_sub_message/';


                    $file_original_name = $file->getClientOriginalName();
                    $file_name = rand(11111, 99999) . $file_original_name;
                    $upload_success = $file->move($destinationPath, $file_name);
                    $data->followup_sub_message_id = $sub_message_followup_id;
                    $data->file_name = 'uploads/followup_sub_message/'.$file_name;

                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {

                        $data->save(); // store / update / code here

                        DB::commit();
                    }catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction`
                        DB::rollback();
                        Session::flash('flash_message_error', "Invalid Request" );
                    }
                } else {
                    Session::flash('flash_message_error', 'uploaded file is not valid');
                }
            }
        }
        return redirect()->route('sub-message-followup.index',$input['campaign_id'].'/'.$input['message_followup_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            FollowupSubMessageAttachment::where('followup_sub_message_id','=',$id)->delete();
            $model = FollowupSubMessage::findOrFail($id);
            $model->delete();
            DB::commit();
            Session::flash('flash_message', "Successfully Deleted.");
        } catch
        (\Exception $ex) {
            DB::rollback();
            Session::flash('error_message', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
        }
        return redirect()->back();
    }

    //attachment delete with ajax call
    public function destroy_file($id)
    {
        DB::beginTransaction();
        try {
            $model = FollowupSubMessageAttachment::findOrFail($id);
            $model->delete();
            DB::commit();
            return 'Success Fully deleted';
        } catch
        (\Exception $ex) {
            DB::rollback();
            return 'Attachment cannot delete, something wrong ';
        }
    }
}
