<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('api.google_login');
    }

    public function google_login($auth=NULL){

        if($auth == 'auth'){
            try{
                \Hybrid_Endpoint::process();
            }catch (Exception $e){
                return $e->getMessage();
            }
            return;
        }

        $oauth = new \Hybrid_Auth(config_path().'/google_auth.php');
        $provider = $oauth->authenticate('Google');
        $profile = $provider->getUserProfile();

        return Response::json(array(
            'user profile data' => $profile
        ));

    }

    public function google_logout(){
        $auth = new \Hybrid_Auth(Config::set('google_auth.php'));
        $auth->logoutAllProviders();
        return View::make('api.goolge_login');
    }
}
