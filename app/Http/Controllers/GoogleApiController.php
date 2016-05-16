<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\GoogleEmailAuth;
use App\SenderEmail;
use Illuminate\Support\Facades\DB;
use App\PoppingEmail;
use Session;

class GoogleApiController extends Controller
{
    public function index()
    {
        return view('api_google.google_login');
    }
    public function redirectToProvider()
    {
       /* $scopes = [
            'https://www.googleapis.com/auth/plus.profile.email_template.read',
            'https://mail.google.com/',
            'https://www.googleapis.com/auth/gmail.modify',
            'https://www.googleapis.com/auth/gmail.readonly',
            'https://www.googleapis.com/auth/gmail.labels',
        ];
        return Socialite::driver('google')->scopes($scopes)->redirect();*/
        //return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $code = $_GET['code'];
        $data = [
            'token'=>$user->token,
            'email_address' => $user->getEmail(),
            'user_id'=>$user->getId(),
            'user_nick_name' => $user->getNickname(),
            'user_name' => $user->getName(),
            'code' => $code,
        ];
        //load all popping email form data using session ------------------------------
        $input_value = $request->session()->get('popping_input');

        $result = $this->store_popping_email($data, $input_value);
        //$request->session()->forget('popping_input');
        if($result == 1){
            Session::flash('flash_message', 'Successfully added!');
            return redirect()->route('popping_email.index');
        }
        else{
            Session::flash('flash_message_error', "Invalid Request" );
            return redirect()->route('popping_email.index');
        }
       // print_r($result);exit;

    }


    public function store_popping_email($data, $input_value){
        $insert_data = [
            'name'=>$input_value['name'],
            'email'=>$input_value['email'],
            'password'=>$input_value['password'],
            'smtp_id'=>$input_value['smtp_id'],
            'imap_id'=>$input_value['imap_id'],
            'token'=>$data['token'],
            'code'=>$data['code'],
            'auth_id'=>$data['user_id'],
            'auth_email'=>$data['email_address'],
            'auth_type'=>'google'
        ];

            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                // store / update / code here
                PoppingEmail::create($insert_data);

                DB::commit();
                return true;
            }catch (Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                return false;
            }

    }


}
