<?php

namespace App\Http\Controllers;

use App\Helpers\SenderEmailCheck;
use App\PublicDomain;
use App\SenderEmail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Session;

class PublicDomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = " Public Domain";
        $data = PublicDomain::orderBy('id', 'DESC')->paginate(100);
        return view('public_domain.index', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PublicDomainRequest $request)
    {
        $input = $request->all();

        //$input['domain_name'] = SenderEmail::EmailTypeIdentification($input['title'], 'status');
        $input['status'] = 1;

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            PublicDomain::create($input);

            DB::commit();
            Session::flash('flash_message', 'Successfully added!');
        }catch (\Exception $e) {

            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('flash_message_error', $e->getMessage());
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
//        $public_domain = PublicDomain::public_domain_list();
//        print_r($public_domain);exit;
        $data = PublicDomain::findOrFail($id);
        return view('public_domain.view', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PublicDomain::findOrFail($id);
        return view('public_domain.update', ['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PublicDomainRequest $request, $id)
    {
        $model = PublicDomain::findOrFail($id);

        $input = $request->all();
        /* Transaction Start Here */
        DB::beginTransaction();

        try {
            $model->update($input);

            DB::commit();
            Session::flash('flash_message', 'Successfully Updated!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('flash_message_error', "Data Do Not Updated");
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
            $model = PublicDomain::findOrFail($id);
            if ($model->delete()) {
                Session::flash('flash_message', "Public Domain Successfully Deleted.");
                return redirect()->back();
            }
        } catch(\Exception $ex) {
            Session::flash('flash_message_error', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
            return redirect()->back();
        }
    }
}
