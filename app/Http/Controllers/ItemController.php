<?php

namespace App\Http\Controllers;

use App\Department;
use App\Brand;
use App\item;
use App\unitofmeasurement;
use App\item_category;
use App\location;
use Helper;
use PDF;
use PDFs;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Imports\ItemsImport;
use App\Exports\ItemsExcelExport;
use File;
use Response;

class ItemController extends Controller
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
    public function index(Request $request)
    {
  
      $category = item_category::get();     
      $department = Department::get();
      $items =item::with(['brand_name','department_name','category','unit'])->get(); 
      
      return view('item.index',compact('items','category','department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unitofmeasurement::get();
        $category = item_category::get();
        $location = location::get();
        $brand = Brand::get();
        $department = Department::get();
        return view('item.create',compact('units','category','location','brand', 'department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:prch_items',
            'brand' => 'required',
            'department' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'hsn_code' => 'required',
        ]);

		$ids = DB::select(DB::raw("SELECT nextval('prch_items_id_seq')"));
		$id = $ids[0]->nextval+1;
		//$id = Helper::getAutoIncrementId();
        $cat = str_pad($request->category_id, 2, '0', STR_PAD_LEFT);
        $unit = str_pad($request->unit_id, 2, '0', STR_PAD_LEFT);
        $item = str_pad($id, 4, '0', STR_PAD_LEFT);
        $barcode = $cat.$unit.$item;
        $request['item_number'] = $barcode;

        // $data = array(
        // 		'item_number' => $request->
        // );

        item::create($request->all());
   
        return redirect()->route('item.index')->with('success','Item Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(item $item)
    {
        $units = unitofmeasurement::get();
        $category = item_category::get();
        $location = location::get();
        $brand = Brand::get();
        $department = Department::get();
        return view('item.show',compact('item','units','category','location','brand','department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(item $item)
    {
        $units = unitofmeasurement::get();
        $category = item_category::get();
        $location = location::get();
        $brand = Brand::get();
        $department = Department::get();
        return view('item.edit',compact('item','units','category','location','brand','department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, item $item)
    {
    	$id = $item['id'];
        $request->validate([
            'title' => 'required|unique:prch_items,title,'.$id,
            'brand' => 'required',
            'department' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'hsn_code' => 'required|unique:prch_items,hsn_code,'.$id,
        ]);
  
        $item->update($request->all());
  
        return redirect()->route('item.index')->with('success','Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(item $item)
    {
        $item->delete();
        return redirect()->route('item.index')->with('success','Item deleted successfully');
    }

    public function filter(Request $request)
    {
      $category = $request->category;
      $dept = $request->department;
      if(!empty($category)){
      	$items =item::with(['brand_name','department_name','category','unit'])->where('category_id', $category)->get(); 
      }
      if(!empty($dept)){
      	$items =item::with(['brand_name','department_name','category','unit'])->where('department', $dept)->get(); 
      }
      if(!empty($dept) && !empty($category)){
      	$items =item::with(['brand_name','department_name','category','unit'])->where('category_id', $category)->where('department', $dept)->get(); 
      }
			return view('item.table',compact('items'));
    }

    public function export_pdf()
	  {
	    $items = item::with(['brand_name','department_name','category','unit'])->get();
	    $pdf = PDF::loadView('item.table', compact('items'));
	    return $pdf->download('Items_'.date("d-M-Y").'.pdf');
	  }

	  public function downloadSheetFormat(){
	  	$path = storage_path('Items-import-sheet.xls');
	  	return Response::download($path);
	  }

	  public function excelImportItems(Request $request){
     	$datas = Excel::import(new ItemsImport,request()->file('excel_data'));
     	if($datas){
     		return redirect()->route('item.index')->with('success','Item Added successfully.');
     	}
    }

    public function excelItemsExport() 
    {
        return Excel::download(new ItemsExcelExport, 'Items_'.date("d-M-Y").'.xls');
    }

}
