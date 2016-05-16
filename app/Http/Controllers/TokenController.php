<?php

namespace App\Http\Controllers;

use DB;

use App\Token;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Input;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Token";
        //$data = Token::all();


        $token_filter_name = Input::get('token_filter');

        if($token_filter_name)
        {
            $data = Token::where('token','LIKE','%'.$token_filter_name.'%')->orderBy('id', 'DESC')->paginate(100);

        }
        else
        {
            $data = Token::orderBy('id', 'DESC')->paginate(100);
        }

        return view('token.index', ['data' => $data, 'pageTitle'=> $pageTitle]);
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
    public function store(Requests\TokenRequest $request)
    {
        // Validate the request...

        /*$this->validate($request, [
            'token' => 'required',
            //'description' => 'required',
        ]);*/

        $input = $request->all();

        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            Token::create($input); // store / update / code here

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
        $data = Token::findOrFail($id);
        return view('token.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Token::findOrFail($id);
        return view('token.update', ['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\TokenRequest $request, $id)
    {
        $model = Token::findOrFail($id);

        $input = $request->all();
        //print_r($input);exit;

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
        //return redirect()->route('token.index');

        try {
            $model = Token::findOrFail($id);
            if ($model->delete()) {
                Session::flash('flash_message', "Token Successfully Deleted.");
                return redirect()->back();
            }
        } catch(\Exception $ex) {
            Session::flash('flash_message_error', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
            return redirect()->back();
        }
    }
}
