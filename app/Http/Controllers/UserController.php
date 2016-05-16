<?php

namespace App\Http\Controllers;

use App\CentralSettings;
use App\Country;
use App\PoppedMessageDetail;
use App\PoppedMessageHeader;
use App\Smtp;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Session;
use Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\SenderEmail;
use App\Imap;





class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function request()
    {
        return view('user.request._form');
    }

    public function user_request_mail(Request $request)
    {
        $user =  Auth::user()->id;
//        print_r($user);exit;
        $email = $request->email;
        $user_data = User::where('email','=',$email)->first();
        if($user_data){
            Session::flash('flash_message_error','This User Already Invited.');
        }else{
            if($email){
                $input_data = [
                    'email'=>$email,
                    'remember_token'=> str_random(30),
                    'status'=> 'invited',
                ];
                $model =  new User();
                if($model->create($input_data)) {
                    try{
                        Mail::send('user.request.mail_message', array('link' =>$input_data['remember_token']),
                            function($message) use ($email)
                            {
                                $message->from('test@edutechsolutionsbd.com', 'User Signup Request');
                                $message->to($email);
//                                $message->cc('tanvirjahan.tanin@gmail.com', 'Tanin');
                                $message->replyTo('tanintjt.1990@gmail.com','User Signup Request');
                                $message->subject('MemberShip Request');
                            });
                    }catch(\Exception $e){
                        Session::flash('danger', "Invalid Request! Your message do not send .Please try again.");
                    }
                }
                Session::flash('flash_message', " Successfully Send Email For MemberShip Request .");
            }else{
                Session::flash('danger', 'The Specified Email address Is not Listed On Your Account. Please Try Again.');
//                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function user_confirm($remember_token)
    {
        //exit("OK");

        $countryList = [''=>'Please Select'] + Country::lists('title', 'id')->all();
        $user = User::where('remember_token','=',$remember_token)->first();

        if(!$user){
            Session::flash('flash_message_error', 'Invalid Confirmation Link.Please Try Again.');
        }
        else{
            return view('user.signup.index', ['countryList'=> $countryList,'user_id'=>$user->id, 'email' => $user->email]);

            //return redirect()->route('user.user-registration')->with('data', ['countryList'=> $countryList,'user_id'=>$user->id, 'email' => $user->email]);


        }
        return redirect()->back();
    }


    public function store(Requests\UserRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $model = User::findOrFail($request->id);

            if($model->fill($input)->save()) {
                try{
                    Mail::send('user.request.activate', array('link' =>$model['remember_token']),

                        function($message) use($input)
                        {
                            $message->from('test@edutechsolutionsbd.com', 'Login Activation Request');
                            $message->to($input['email']);
//                            $message->cc('tanvirjahan.tanin@gmail.com', 'Tanin');
                            $message->replyTo('tanintjt.1990@gmail.com','Login Activation Request');
                            $message->subject('Login Activation');
                        });
                }catch(\Exception $e){
                    Session::flash('danger', "Invalid Request! Your message do not send .Please try again.");
                }
            }
            DB::commit();
            //Session::flash('flash_message', "Successfully  Added Information");
            Session::flash('flash_message', "Successfully Completed Registration Process.Please Check Your Email For Login Activation Link .");
        }
        catch ( \Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('flash_message_error', 'Invalid Request!');
        }
        //return view('user.login.activation_msg');
        return redirect()->back();
    }

    public function user_activation($remember_token)
    {

        $model = User::where('remember_token', $remember_token)->update(['status' => 'active']);

        if(!$remember_token){
            Session::flash('flash_message_error', 'Invalid Confirmation Link.Please Try Again.');
        }
        else{

           if(Auth::check()){
               Session::put('remember_token', isset(Auth::user()->get()->id));
               Session::flash('flash_message', "You Have Already Logged In.");
               return redirect()->route('home-dashboard');
           }
            else{
                Session::flash('flash_message', 'You have been activated successfully for login.');
                return redirect()->route('user-login');
            }
        }
        return redirect()->back();
    }


    public function user_login()
    {
        return view('user.login.login');
    }

    public function login()
    {
        #Session::flush(); //delete the session
        $admin_email = DB::table('user')->where('type','=','admin')->get(array('user.email'));

        $data = Input::all();
        date_default_timezone_set("Asia/Dacca");

        $date = date('Y-m-d H:i:s', time());

        $user_data = User::where('email', $data['email'])->first();
//        print_r($user_data);exit;

        if(Auth::check()){
            Session::put('email', isset(Auth::user()->get()->id));
            Session::flash('flash_message', "You Have Already Logged In.");

            return redirect()->route('home-dashboard');
        }else{
            if($user_data->status == 'inactive'){
                Session::flash('flash_message_error', "You are not permitted for login.Your account is in-active.");
            }else{
                if (Auth::attempt(['email' => $data['email'], 'password' =>$data['password']]))
                {
                    // Session area Start
                    Session::put('email', $user_data->email);
                    Session::put('user_type', $user_data->type);
                    Session::flash('flash_message', "Successfully  Logged In.");

                    $central_settings = CentralSettings::all();
                    Session::put('central_settings', $central_settings);


                    //mail
                    if($user_data->type == 'user' || 'admin'){
                        $model_cs = CentralSettings::where('title','login-notification')->where('user_type','admin')->first();

                        /*if($model_cs->status == 'yes'){
                            foreach($admin_email as $email){
                                Mail::send('user.login.login_msg', array('email'=>$user_data->email,'user_type'=>$user_data->type,'date'=>$date),

                                    function($message) use($user_data,$email)
                                    {
                                        $message->from('test@edutechsolutionsbd.com', 'Affifact'  );
                                        $message->to($email->email);
                                        $message->replyTo($user_data->email);
                                        $message->subject('User Login Information');
                                    });
                            }
                        }*/
                    }
                    return redirect()->route('home-dashboard');
                }else{
                    Session::flash('flash_message_error', "Email Address / Password InCorrect.Please Try Again");
                    return redirect()->back();
                }
            }
        }return redirect()->back();
    }

    public function user_dashboard(){

        $user_type = User::Where('type','admin')->first();
//       print_r($user_type);exit;
        return view('pages.index',['user_type'=>$user_type]);
    }

    public function logout() {

        Auth::logout();

        Session::flush(); //delete the session
        Session::flash('flash_message', "You are now logged out!");

        return redirect()->route('user-login');
    }


    public function profile()
    {
        if(Auth::check())
        {
            $user_id = Auth::user()->id;
            $userProfile = User::where('id', '=', $user_id)->first();
            $countryList = [''=>'Please Select'] + Country::lists('title', 'id')->all();
        }
        if($userProfile == Null) {
            Session::flash('info', "User Profile information is missing !");
        }
        return view('user.user_info.index', ['countryList'=> $countryList,'user_id'=>$user_id,'userProfile'=>$userProfile]);
    }

    //public function update(ImapRequest $request, $id)

    public function updateProfile(Requests\UserRequest $request, $id)
    {
        $model = User::findOrFail($id);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $model->fill($data)->save();
            DB::commit();
            Session::flash('flash_message', "Successfully  User Profile Updated");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('flash_message_error', " Not added.Invalid Request!");
        }
        return redirect()->route('home-dashboard');
    }

    public function password_change_view($id)
    {
        $data = User::findOrFail($id);
        return view('user.user_info.change_password', ['data'=>$data]);
    }

    public function update_passwd($id)
    {
        if(Auth::check())
        {
            $input = Input::all();

            if($input['confirm_password']==$input['password']) {

                $hash_check = Hash::check($input['old_password'], User::findOrNew(Auth::user()->id)->password);
                if ($hash_check > 0) {
                    $model = User::findOrNew(Auth::user()->id);
                    $model->password = $input['password'];
                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {
                        $model->save();

                        DB::commit();
                        Session::flash('flash_message', "Successfully  Password Updated");

                    } catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction
                        DB::rollback();
                        Session::flash('flash_message_error', "Invalid Request");
                    }
                } else {
                    Session::flash('flash_message_error', "Your Old Password Is Not Correct!");
                }
            }
            else{
                Session::flash('flash_message_error', "Password and Confirm Password Does not match !");
            }
        }
        else
        {
            Session::flash('flash_message_error', "Please Login !" );
        }

        return redirect()->back();
    }






    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function status_inactive($id)
    {
        $model = User::findOrFail($id);
        //$input = Input::all();
        $input_data = Input::all();

        /* Transaction Start Here */
        DB::beginTransaction();
        try{
            $model->status = "inactive";

            $model->update($input_data);

            DB::commit();
            Session::flash('flash_message', 'Successfully Changed Status!');
        }catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Failed !" );
        }
        return redirect()->route('user.user-list');
    }

    public function status_active($id)
    {
//        exit('ok');
        $model = User::findOrFail($id);
        $input_data = Input::all();

        $user = User::where('id','=',$id)->first();
//        print_r($user);exit('ok');
        /* Transaction Start Here */
        DB::beginTransaction();
        if($user->password && $user->status == 'inactive'){
            try{
                $model->status = "active";

                $model->update($input_data);

                Mail::send('user.user_info.status_activation_msg', array('link' =>$model->remember_token),
                    function($message) use($model)
                    {
                        $message->from('test@edutechsolutionsbd.com', 'User Activation Mail');
                        $message->to($model->email);
//                        $message->cc('tanintjt@gmail.com', 'Tanin');
                        $message->replyTo($model->email);
                        $message->subject('You have been activated by admin');
                    });

                DB::commit();
                Session::flash('flash_message', 'Successfully Changed Status!');
            }catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('flash_message_error', "Failed !" );
            }
        }else{
            Session::flash('flash_message_error', "Passoword is not set by  the user !" );
        }

        return redirect()->route('user.user-list');
    }


    public function active_user_login($remember_token)
    {
        return redirect()->route('user-login');
    }


}
