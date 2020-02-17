<?php

namespace App\Http\Controllers;

use App\PO_SendToVendors;
use Illuminate\Http\Request;

class POSendToVendorsController extends Controller
{
		public function __construct()
    {
        $this->middleware('auth', ['except' => array('POAcceptsByVendor', 'POAcceptsByVendorDataStore')]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PO_SendToVendors  $pO_SendToVendors
     * @return \Illuminate\Http\Response
     */
    public function show(PO_SendToVendors $pO_SendToVendors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PO_SendToVendors  $pO_SendToVendors
     * @return \Illuminate\Http\Response
     */
    public function edit(PO_SendToVendors $pO_SendToVendors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PO_SendToVendors  $pO_SendToVendors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PO_SendToVendors $pO_SendToVendors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PO_SendToVendors  $pO_SendToVendors
     * @return \Illuminate\Http\Response
     */
    public function destroy(PO_SendToVendors $pO_SendToVendors)
    {
        //
    }

    public function POAcceptsByVendor(request $request){
    		return view("purchase_order.po_accepts");
    }

    public function POAcceptsByVendorDataStore(request $request, $po_id){
    		$request->validate([
            'po_accept_status' => 'required',
        ]);

        PO_SendToVendors::where('id', $po_id)->where('vendor_id', $request->input('vendor_id'))->update(['po_accept_status'=> $request->input('po_accept_status')]);

        return back()->with('success','Thank You, Your PO acception status has been submited');
    }
}
