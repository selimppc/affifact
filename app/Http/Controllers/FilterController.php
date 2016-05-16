<?php

namespace App\Http\Controllers;

use DB;

use App\Filter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Input;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Filter";
        //$data = Filter::all()->paginate(5);


        $filter_filters_name = Input::get('filter_filters');

        if($filter_filters_name)
        {
            $data = Filter::where('name','LIKE','%'.$filter_filters_name.'%')->orderBy('id', 'DESC')->paginate(100);


        }
        else
        {
            $data = Filter::orderBy('id', 'DESC')->paginate(100);
        }

        return view('filter.index', ['data' => $data, 'pageTitle'=> $pageTitle]);
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
    public function store(Requests\FilterRequest $request)
    {
        // Validate the request...

        /*$this->validate($request, [
            'name' => 'required|unique:filter',
        ]);*/

        $input = $request->all();

        /* Transaction Start Here */
        DB::beginTransaction();
        try {

            Filter::create($input); // store / update / code here

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
        $data = Filter::findOrFail($id);
        return view('filter.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Filter::findOrFail($id);
        return view('filter.update', ['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\FilterRequest $request, $id)
    {
        $model = Filter::findOrFail($id);

        $input = $request->all();
        //print_r($input);exit;

        /* Transaction Start Here */
            DB::beginTransaction();
            try {

                $model->fill($input)->save(); // store / update / code here

                DB::commit();
                Session::flash('flash_message', 'Successfully added!');
            } catch (Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('flash_message_error', "Invalid Request");
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
        //return redirect()->route('filter.index');

        try {
            $model = Filter::findOrFail($id);
            if ($model->delete()) {
                Session::flash('flash_message', "Filter Successfully Deleted.");
                return redirect()->back();
            }
        } catch(\Exception $ex) {
            Session::flash('flash_message_error', 'Invalid Delete Process ! At first Delete Data from related tables then come here again. Thank You !!!');
            return redirect()->back();
        }
    }
}
