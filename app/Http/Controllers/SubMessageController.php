<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\SubMessageAttachment;
use Validator;
use Input;
use Session;
use DB;
use App\Message;
use App\SubMessage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SubMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($message_id,$campaign_id)
    {
        $pageTitle = " Sub Message ";
        $sub_message_filter_title = Input::get('sub_message_filter_title');
        if($sub_message_filter_title){
            $message_id = Input::get('message_id');
            $data = SubMessage::with('relMessage')->where('sub_message.title','=',$sub_message_filter_title)->orderBy('id', 'DESC')->paginate(100);
        }
        else {
            $data = SubMessage::with('relMessage')->where('sub_message.message_id', '=', $message_id)->orderBy('id', 'DESC')->paginate(100);

        }
        //$campaign_id = Campaign::lists('name','id');
        //$message_all = Message::findOrFail($message_id);
        return view('sub_message.index', ['data' => $data, 'pageTitle'=> $pageTitle,'message_id'=>$message_id,'campaign_id'=>$campaign_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_index($message_id,$campaign_id){
        $pageTitle = " Sub Message ";
        $sub_message_filter_title = Input::get('sub_message_filter_title');
        if($sub_message_filter_title){
            $message_id = Input::get('message_id');
            $data = SubMessage::with('relMessage')->where('sub_message.title','=',$sub_message_filter_title)->orderBy('id', 'DESC')->paginate(100);
        }
        else {
            $data = SubMessage::with('relMessage')->where('sub_message.message_id', '=', $message_id)->orderBy('id', 'DESC')->paginate(100);

        }
        //$campaign_id = Campaign::lists('name','id');
        //$message_all = Message::findOrFail($message_id);
        return view('sub_message.add', ['data' => $data, 'pageTitle'=> $pageTitle,'message_id'=>$message_id,'campaign_id'=>$campaign_id]);
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
    public function store(Requests\SubMessageRequest $request)
    {
        $input = Input::all();

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            $sub_message = SubMessage::create($input); // store / update / code here
            DB::commit();
        }catch (Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Invalid Request" );
            return redirect()->back();
        }

        $sub_message_id = $sub_message->id;

        $files = Input::file('attchment');
        $file_count = count($files);
        foreach($files as $file) {
            if(!empty($file)) {
                $data = new SubMessageAttachment();
                //$data->file_type
                $file_type = $file->getMimeType();
                $file_type = explode("/",$file_type);
                $data->file_type = $file_type[0];
                $data->file_size = $file->getSize();

                $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,xlsx,xls,docx,pptx,ppt,pub');
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    // Files destination
                    $destinationPath = 'uploads/sub_message/';

                   // Create folders if they don't exist
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    $file_original_name = $file->getClientOriginalName();
                    $file_name = rand(11111, 99999) . $file_original_name;
                    $upload_success = $file->move($destinationPath, $file_name);
                    $data->sub_message_id = $sub_message_id;
                    $data->file_name = 'uploads/sub_message/'.$file_name;

                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {

                        $data->save(); // store / update / code here

                        DB::commit();
                        Session::flash('flash_message', 'Message successfully Added!');
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
        return redirect()->route('sub-message.index',$input['message_id'].'/'.$input['campaign_id']);
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
        $data = SubMessage::findOrFail($id);

        $message_data = SubMessageAttachment::where('sub_message_id','=',$id)->get();
        return view('sub_message.view', ['data' => $data, 'pageTitle'=> $pageTitle, 'message_data'=>$message_data]);
    }

    public function image_show($id){
        $pageTitle = 'Image';
        $image = SubMessageAttachment::where('id','=',$id)->get();
        return view('sub_message.view_image', [
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
        $data = SubMessage::with('relMessage')->findOrFail($id);
        $message_id = SubMessage::with('relMessage')->findOrFail($id)->message_id;
        $campaign_id = $data->relMessage->campaign_id;
        $message_data = SubMessageAttachment::where('sub_message_id','=',$id)->get();
        return view('sub_message.update', ['data'=>$data,'message_id'=>$message_id,'campaign_id'=>$campaign_id,'message_data'=>$message_data,'pageTitle'=>$pageTitle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\SubMessageRequest $request, $id)
    {
        $model = SubMessage::findOrFail($id);
        //all input field value
        $input = Input::all();
        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $model->fill($input)->save(); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Successfully updated!');
        }catch (Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Invalid Request" );
            return redirect()->back();
        }
        $sub_message_id = $model->id;
        $files = Input::file('attchment');
        $file_count = count($files);
        foreach($files as $file) {
            if(!empty($file)) {
                $data = new SubMessageAttachment();
                //$data->file_type
                $file_type = $file->getMimeType();
                $file_type = explode("/",$file_type);
                $data->file_type = $file_type[0];
                $data->file_size = $file->getSize();

                $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,xlsx,xls,docx,pptx,ppt,pub');
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    // Files destination
                    $destinationPath = public_path().'/uploads/sub_message/';

                    // Create folders if they don't exist
                    if (!file_exists($destinationPath)) {
                        File::makeDirectory($destinationPath, $mode = 0777, true, true);
                    }

                    $file_original_name = $file->getClientOriginalName();
                    $file_name = rand(11111, 99999) . $file_original_name;
                    $upload_success = $file->move($destinationPath, $file_name);
                    $data->sub_message_id = $sub_message_id;
                    $data->file_name = 'uploads/sub_message/'.$file_name;

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
        return redirect()->route('sub-message.index',$input['message_id'].'/'.$input['campaign_id']);
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
            SubMessageAttachment::where('sub_message_id','=',$id)->delete();
            $model = SubMessage::findOrFail($id);$model->delete();
            Session::flash('flash_message', "Successfully Deleted.");
            DB::commit();
        } catch
        (\Exception $ex) {
            DB::rollback();
            Session::flash('flash_message_error', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
        }
        return redirect()->back();
    }

    //attachment delete with ajax call
    public function destroy_file($id)
    {
        DB::beginTransaction();
        try {
            $model = SubMessageAttachment::findOrFail($id);
            $model->delete();
            DB::commit();
            return 'Success Fully deleted';
        } catch
        (\Exception $ex) {
            DB::rollback();
            return 'Something Error, Cannot delete attachment';
        }
    }
}
