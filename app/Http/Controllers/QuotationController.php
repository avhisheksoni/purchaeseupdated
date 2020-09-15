<?php

namespace App\Http\Controllers;

use App\quotation;
use App\Quotation_items;
use App\Imports\QuotationImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use PDF;
use PDFs;
use DB;

class QuotationController extends Controller
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
        $quotations = quotation::latest()->paginate(10);
        return view('quotation.index',compact('quotations'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    		return view('quotation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    		//dd($request);
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:prch_quotations',
            'register_number' => 'required|unique:prch_quotations',
            'firm_name' => 'required',
            'gst_number' => 'required|unique:prch_quotations',
        ]);

        $quotation = quotation::create($request->all());
        $LastInsertId = $quotation->id;
        if(!empty($LastInsertId)){
        	$count = count($request->item_name);	
			  	if($count != 0){
			  	 	$x = 0;
			  	 	while($x < $count){
			  	 		if($request->item_name[$x] !=''){
							  $quotationItemsTable = array(
						 				'item_name' => $request->item_name[$x],
				            'item_quantity' => $request->item_quantity[$x],
				            'item_price' => $request->item_price[$x],
				            'item_actual_amount' => $request->item_actual_amount[$x],
				            'item_tax1_rate' => $request->item_tax1_rate[$x],
				            'item_tax1_amount' => $request->item_tax1_amount[$x],
				            'item_total_amount' => $request->item_total_amount[$x],
				            'quotation_id' => $LastInsertId,
				            'vendor_regno' => $request->register_number,
						 		);
				        Quotation_items::create($quotationItemsTable);
							}			  
			  	 		$x++;
			  	 	}
			  	}
			  	if(!empty($request->file)){
			  		$datas = Excel::toCollection(new QuotationImport,request()->file('file'));
			  		$sum = 0;
						foreach ($datas as $val) {
		  				foreach ($val as $value) {
		  					$import = array(
			  					'item_name' => $value['item_name'],
			  					'item_quantity' => $value['quantity'],
			  					'item_price' => $value['price'],
			  					'item_actual_amount' => $value['total_price'],
			  					'item_tax1_rate' => $value['tax_rate'],
			  					'item_tax1_amount' => $value['tax_amount'],
			  					'item_total_amount' => $value['final_amount'],
			  					'quotation_id' => $LastInsertId,
			            'vendor_regno' => $request->register_number,
			  				);
			  				$sum +=(int)$value['final_amount'];
			  				Quotation_items::create($import);
		  				}
							quotation::where('id', $LastInsertId)->update(['item_final_amount'=> $sum]);
		  			}
			  	}
        }
        return redirect()->route('quotation.index')->with('success','Quotation Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(quotation $quotation)
    {
        $quotation_item = Quotation_items::where('quotation_id',$quotation->id)->where('vendor_regno',$quotation->register_number)->get();
    		return view('quotation.show', compact('quotation', 'quotation_item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(quotation $quotation)
    {
    		$quotation_item = Quotation_items::where('quotation_id',$quotation->id)->where('vendor_regno',$quotation->register_number)->get();
    		return view('quotation.edit', compact('quotation', 'quotation_item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    		$vendors = array(
    			'name' => $request->name,
          'mobile' => $request->mobile,
          'alt_number' => $request->alt_number,
          'register_number' => $request->register_number,
          'firm_name' => $request->firm_name,
          'gst_number' => $request->gst_number, 
    		);
    		quotation::where('id', $id)->update($vendors);
    		$count = count($request->item_name);
    		if($count != 0){
	    		$x = 0;
	    		$sum = 0;
			  	while($x < $count){
			  		if($request->item_name[$x] !=''){
			    		$items = array(
								'id' => $request->item_id[$x],
								'item_name' => $request->item_name[$x],
		            'item_quantity' => $request->item_quantity[$x],
		            'item_price' => $request->item_price[$x],
		            'item_actual_amount' => $request->item_actual_amount[$x],
		            'item_tax1_rate' => $request->item_tax1_rate[$x],
		            'item_tax1_amount' => $request->item_tax1_amount[$x],
		            'item_total_amount' => $request->item_total_amount[$x],
			          'vendor_regno' => $request->register_number,
							);
							$sum +=(int)$items['item_total_amount'];
							Quotation_items::where('id',$items['id'])->update($items);
						}
						$x++;
						quotation::where('id', $id)->update(['item_final_amount'=> $sum]);
					}
				} 
				return redirect()->route('quotation.index')->with('success','Quotation Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    		DB::table("quotation_items")->where('quotation_id',$id)->delete();
    		quotation::find($id)->delete();
        return redirect()->route('quotation.index')->with('success','Quotation deleted successfully');
    }

    public function export_quotation($id) 
    {
    		$quotations = quotation::where('id',$id)->get();
    		foreach ($quotations as $quotation) {
    			$quotation_item = Quotation_items::where('quotation_id',$quotation->id)->where('vendor_regno',$quotation->register_number)->get();
        	$pdf = PDF::loadView('quotation.testpdf', compact('quotation', 'quotation_item'));
        }
	    	return $pdf->download('Quotation_'.date("d-M-Y").'.pdf');
    }
}
