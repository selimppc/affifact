<?php

namespace App\Http\Controllers;

use App\Helpers\Xmlapi;
use DB;
use Input;
use App\Smtp;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Session;
use App\SenderEmail;

class SmtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $pageTitle = "SMTP";
        $smtp_name = Input::get('smtp_name');
        if($smtp_name){
            $data = Smtp::where('name','Like','%'.$smtp_name.'%')->orderBy('id', 'DESC')->paginate(100);
        }
        else {
            $data = Smtp::orderBy('id', 'DESC')->paginate(100);
        }
        return view('smtp.index', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SmtpRequest $request)
    {
        // Get input data
        $input = $request->all();

        // TODO actually not todo as type has been identified by $input['domain']
        //$type = SenderEmail::EmailTypeIdentification($input['host'], 'type');

        // Prepare data
        $input_data = [
            'name' => $input['name'],
            'server_username' => isset($input['server_username']) ? $input['server_username'] : null,
            'server_password' => isset($input['server_password']) ? $input['server_password'] : null,
            'host' => $input['host'],
            'port' => $input['port'],
            'auth' => $input['auth'],
            'secure' => $input['secure'],
            'mails_per_day_per_email' => $input['mails_per_day_per_email'],
            'type' => $input['domain'] == 'private' ? 'email-create' : 'no-email-create' ,
            'smtp' => $input['smtp'],
            'c_port' => $input['c_port']
        ];

        try{
            $f = fsockopen($input['host'], $input['port'], $errno, $errstr, 30);
            if($input['domain'] == 'private'){

                /* Smtp Validation only Cpanel Based :start*/
                try {
                    $port = $request->c_port;
                    $host = $request->host;

                    $username = $request->server_username;
                    $passwd = $request->server_password;

                    $xmlapi = new Xmlapi($host);

                    $xmlapi->set_port($port);
                    //exit;
                    $xmlapi->password_auth($username, $passwd);

                    // cpanel email addpop function Parameters
                    $email_user = 'aftest';
                    $email_quota = 5;
                    $call = array('domain' => $host, 'email' => $email_user, 'password' => $passwd, 'quota' => $email_quota);
                    $xmlapi->set_debug(0);      //output to error file  set to 1 to see error_log.

                    $result = $xmlapi->api2_query($username, "Email", "addpop", $call);
                    if (isset($result)) {
                        if(isset($result->error)){
                            $access_denied = strpos($result->error, 'denied');
                            $exist = strpos($result->error, 'exists');

                            if($access_denied){
                                $msg = 'Error: '.$result->data->reason;
                                Session::flash('flash_message_error', $msg );
                                return redirect()->back();
                            }elseif(!$exist){
                                $msg = $result->data->reason;
                                Session::flash('flash_message_error', $msg );
                                return redirect()->back();
                            }
                        }

                        /*if (!isset($result->data->result)) {
                            $msg = $result->data->reason;
                            Session::flash('flash_message_error', $msg );
                            return redirect()->back();
                        }*/
                    }else{
                        Session::flash('flash_message_error', "Please check your cpanel access info once again!" );
                        return redirect()->back();
                    }
                }catch (\Exception $ex){
                    Session::flash('flash_message_error', $ex->getMessage() );
                    return redirect()->back();
                }
                //Smtp Validation only Cpanel Based :End
            }

            //Transaction Start Here
            DB::beginTransaction();
            try {
                Smtp::create($input_data); // store / update / code here
                DB::commit();
                Session::flash('flash_message', 'Successfully Added!');

            }catch (\Exception $e) {
                DB::rollback();
                Session::flash('flash_message_error', $e->getMessage() );
            }
            fclose($f) ;
        }catch (\Exception $e){
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
        $data = Smtp::findOrFail($id);
        return view('smtp.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Smtp::findOrFail($id);
        return view('smtp.update', ['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\SmtpRequest $request, $id)
    {
        $model = Smtp::findOrFail($id);
        $input = $request->all();

        // TODO actually not todo as type has been identified by type in the table already
        //$type = SenderEmail::EmailTypeIdentification($input['host'], 'type');
        $type = $model->type;

        $input_data = [
            'name' => $input['name'],
            'server_username' => isset($input['server_username']) ? $input['server_username'] : null,
            'server_password' => isset($input['server_password']) ? $input['server_password'] : null,
            'host' => $input['host'],
            'port' => $input['port'],
            'auth' => $input['auth'],
            'secure' => $input['secure'],
            'mails_per_day_per_email' => $input['mails_per_day_per_email'],
            'type' => $type ,
            'smtp' => $input['smtp'],
            'c_port' => isset($input['c_port']) ? $input['c_port'] : null,
        ];

        try{
            $f = fsockopen($input['host'], $input['port'], $errno, $errstr, 30);
            if($type == 'email-create'){

                /* Smtp Validation only Cpanel Based :start*/
                try {
                    $port = $request->c_port;
                    $host = $request->host;

                    if(!empty($input['server_username']))
                        $username = $request->server_username;
                    else
                        $username = $model->server_username;
                    $input_data['server_username'] = $username;

                    if(!empty($input['server_password']))
                        $passwd = $request->server_password;
                    else
                        $passwd = $model->server_password;
                    $input_data['server_password'] = $passwd;

                    $xmlapi = new Xmlapi($host);

                    $xmlapi->set_port($port);

                    $xmlapi->password_auth($username, $passwd);

                    // cpanel email addpop function Parameters
                    $email_user = 'aftest';
                    $email_quota = 5;
                    $call = array('domain' => $host, 'email' => $email_user, 'password' => $passwd, 'quota' => $email_quota);
                    //output to error file  set to 1 to see error_log.
                    $xmlapi->set_debug(0);

                    $result = $xmlapi->api2_query($username, "Email", "addpop", $call);

                    if (isset($result)) {
                        if(isset($result->error)){
                            $access_denied = strpos($result->error, 'denied');
                            $exist = strpos($result->error, 'exists');

                            if($access_denied){
                                $msg = 'Error: '.$result->data->reason;
                                Session::flash('flash_message_error_update', $msg );
                                return redirect()->back();
                            }elseif(!$exist){
                                $msg = $result->data->reason;
                                Session::flash('flash_message_error_update', $msg );
                                return redirect()->back();
                            }
                        }
                    }else{
                        Session::flash('flash_message_error_update', "Please check your cpanel access info once again!" );
                        return redirect()->back();
                    }
                }catch (\Exception $ex){
                    Session::flash('flash_message_error_update', $ex->getMessage() );
                    return redirect()->back();
                }
                //Smtp Validation only Cpanel Based :End
            }


            if($f) {
                DB::beginTransaction();
                try {
                    $model->fill($input_data)->save(); // store / update / code here
                    DB::commit();
                    Session::flash('flash_message', 'Successfully updated!');

                } catch (\Exception $e) {
                    DB::rollback();
                    Session::flash('flash_message_error_update', $e->getMessage());
                }
                fclose($f);
            }else{
                Session::flash('flash_message_error_update', '');
            }

        }catch (\Exception $e){
            Session::flash('flash_message_error_update', $e->getMessage() );
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
        $model = Smtp::findOrFail($id);

        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            $model->delete(); // store / update / code here

            DB::commit();
            Session::flash('flash_message', 'Smtp successfully deleted!');
        }catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!" );
        }

        return redirect()->route('smtp.index');
    }
}
