<?php

namespace App\Http\Controllers;

use App\Brand;
use App\item_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
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
        $brand = brand::with(['category'])->latest()->paginate(10);
        $item_category = item_category::all();
        return view('subcategory',compact('brand','item_category'))->with('i', (request()->input('page', 1) - 1) * 10);
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
        		'category_id' => 'required',
            'name' => 'unique:prch_brands',
            'description' => ''
        ]);
        if ($validation->fails())
        {
            return "The Subcategory Name has already been taken";
        }
        else
        {
            $data = new brand;
            $data->category_id = $request->input('category_id');
            $data->name = $request->input('name');
            $data->description = $request->input('description');
            $data->save ();
            return 'Subcategory added';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        brand::where('id', $request->input('id'))->update(['category_id'=> $request->input('category_id'), 'name'=> $request->input('name'), 'description' => $request->input('description')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        brand::find($id)->delete();
        return redirect()->route('subcategory.index')->with('success','Subcategory deleted successfully');
    }
}
