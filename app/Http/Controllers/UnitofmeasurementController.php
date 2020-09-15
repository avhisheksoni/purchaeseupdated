<?php

namespace App\Http\Controllers;

use App\unitofmeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UnitofmeasurementController extends Controller
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
        $um = unitofmeasurement::latest()->paginate(10);
        return view('um',compact('um'))->with('i', (request()->input('page', 1) - 1) * 10);
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
            'name' => 'unique:prch_unitofmeasurements',
            'description' => ''
        ]);
        if ($validation->fails())
        {
            return "The name has already been taken";
        }
        else
        {
            $data = new unitofmeasurement;
            $data->name = $request->input('name');
            $data->description = $request->input('description');
            $data->save ();
            return 'Units added';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\unitofmeasurement  $unitofmeasurement
     * @return \Illuminate\Http\Response
     */
    public function show(unitofmeasurement $unitofmeasurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\unitofmeasurement  $unitofmeasurement
     * @return \Illuminate\Http\Response
     */
    public function edit(unitofmeasurement $unitofmeasurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\unitofmeasurement  $unitofmeasurement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, unitofmeasurement $unitofmeasurement)
    {
        unitofmeasurement::where('id', $request->input('id'))->update(['name'=> $request->input('name'), 'description' => $request->input('description')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\unitofmeasurement  $unitofmeasurement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        unitofmeasurement::find($id)->delete();
        return redirect()->route('um.index')->with('success','Units deleted successfully');
    }
}
