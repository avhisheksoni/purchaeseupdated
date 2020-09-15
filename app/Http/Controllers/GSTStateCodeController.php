<?php

namespace App\Http\Controllers;

use DB;
use App\GST_State_Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GSTStateCodeController extends Controller
{
		public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gst = DB::table('prch_gst_state_codes')->orderBy('id', 'ASC')->paginate(10);
        // $gst = DB::table('prch_gst_state_codes')->latest()->paginate(10);
        return view('gst_state_code',compact('gst'))->with('i', (request()->input('page', 1) - 1) * 10);
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
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'unique:item_categories',
            'description' => ''
        ]);
        if ($validation->fails())
        {
            return "The Category Name has already been taken";
        }
        else
        {
            $data = new GST_State_Code;
            $data->state_name = $request->input('state_name');
            $data->countryid = '1';
            $data->save ();
            return 'GST State added';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GST_State_Code  $gST_State_Code
     * @return \Illuminate\Http\Response
     */
    public function show(GST_State_Code $gST_State_Code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GST_State_Code  $gST_State_Code
     * @return \Illuminate\Http\Response
     */
    public function edit(GST_State_Code $gST_State_Code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GST_State_Code  $gST_State_Code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GST_State_Code $gST_State_Code)
    {
        DB::table('prch_gst_state_codes')->where('id', $request->input('id'))->update(['state_name' => $request->input('state_name')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GST_State_Code  $gST_State_Code
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('prch_gst_state_codes')->where('id',$id)->delete();
        return redirect()->route('gst_state_code.index')->with('success','GST State deleted successfully');
    }
}