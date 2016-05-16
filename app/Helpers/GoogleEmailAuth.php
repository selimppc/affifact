<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 11/15/15
 * Time: 1:38 PM
 */

namespace App\Helpers;

use App\Http\Requests;
use Laravel\Socialite\Facades\Socialite;

class GoogleEmailAuth
{
    public static function redirectToProvider()
    {
        /* $scopes = [
             'https://www.googleapis.com/auth/plus.profile.email_template.read',
             'https://mail.google.com/',
             'https://www.googleapis.com/auth/gmail.modify',
             'https://www.googleapis.com/auth/gmail.readonly',
             'https://www.googleapis.com/auth/gmail.labels',
         ];
         return Socialite::driver('google')->scopes($scopes)->redirect();*/
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $data = [
            'token'=>$user->token,
            'email_address' => $user->getEmail(),
            'user_id'=>$user->getId(),
            'user_nick_name' => $user->getNickname(),
            'user_name' => $user->getName(),
        ];
        return $data;
    }

}