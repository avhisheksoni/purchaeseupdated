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
use App\Exports\ItemsExport;
use App\itemconsumable;
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
      $items =item::with(['brand_name','department_name','category','unit','consum'])->paginate(10); 
     // dd($items);
      
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
        $itemconsumable = itemconsumable::get();
        return view('item.create',compact('units','category','location','brand', 'department','itemconsumable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return $request->all();
        $data = $request->validate([
            'title' => 'required|unique:prch_items',
            'brand' => 'required',
            'department' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'hsn_code' => 'required|max:9|min:9|unique:prch_items',
            'cons_id' => 'required',
        ]);
      //dd($data);
		$ids = DB::select(DB::raw("SELECT nextval('prch_items_id_seq')"));
		$id = $ids[0]->nextval+1;
		//$id = Helper::getAutoIncrementId();
        $cat = str_pad($request->category_id, 2, '0', STR_PAD_LEFT);
        $unit = str_pad($request->unit_id, 2, '0', STR_PAD_LEFT);
        $item = str_pad($id, 4, '0', STR_PAD_LEFT);
        $barcode = $cat.$unit.$item;
        $data['item_number'] = $barcode;

        // $data = array(
        // 		'item_number' => $request->
        // );
        //return $data;

        item::create($data);
   
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
        $itemconsumable = itemconsumable::get();
        return view('item.edit',compact('item','units','category','location','brand','department','itemconsumable'));
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
            'hsn_code' => 'required|max:9|min:9|unique:prch_items,'.$id,
            'cons_id' => 'required',
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
        //return "avhi";
	  	$path = storage_path('Items-import-sheet (00).xls');
	  	return Response::download($path);
	  }

	  public function excelImportItems(Request $request){
     	$datas = Excel::import(new ItemsImport,request()->file('excel_data'));

     	if($datas){
     		return redirect()->route('item.index')->with('success','Item Added successfully.');
     	}
    }


      public function excelItemsnew(){
            //return "avhipg";
           // $datas = Excel::toCollection(new ItemsImport,request()->file('excel_data'));
           $datas = Excel::toCollection(new ItemsImport,request()->file('excel_data'));
         //  dd($datas);

             
             $errors= array();
             $error_name = '';
             $workid = '';
        foreach($datas as $sales){
          foreach($sales as $items){
                //dd($items['subcategory_name']);
                    $status = true;
                    if($status){
                        if($items['category_name'] != ''){
                          $category_id = item_category::where('name', $items['category_name'])->first();
                          if($category_id){
                             $catid = $category_id->id;
                             $status = true;

                          }else{

                              $error_name = "Category is not found in database";
                              $status = 0;
                              $catid = '';
                          }
                    }else{

                              $error_name = "Category is Empty";
                              $status = 0;
                              $catid = '';
                    }
                    
                 }

                  if($status){
                        if($items['subcategory_name'] != ''){
                          $subcategory_id = Brand::where('name', $items['subcategory_name'])->where('category_id', $catid)->first();
                          if($subcategory_id){
                             $subcatid = $subcategory_id->id;
                             $status = true;

                          }else{

                              $error_name = "Sub-Category is not found in database or category is wrong";
                              $status = 0;
                              $subcatid = '';
                          }
                    }else{

                              $error_name = "Sub-Category is Empty";
                              $status = 0;
                              $subcatid = '';
                    }
                    
                 }


                 if($status){
                        if($items['department'] != ''){
                          $department = Department::where('name', $items['department'])->first();
                          if($department){
                             $dept = $department->id;
                             $status = true;

                          }else{

                              $error_name = "Department is not found in database";
                              $status = 0;
                              $dept = '';
                          }
                    }else{
                              $error_name = "Department is Empty";
                              $status = 0;
                              $dept = '';

                    }
                    
                 }


                  if($status){
                        if($items['units'] != ''){
                          $unit = unitofmeasurement::where('name', $items['units'])->first();
                          if($unit){
                             $unitid = $unit->id;
                             $status = true;

                          }else{

                              $error_name = "Unit of measurement is not found in database";
                              $status = 0;
                              $unitid = '';
                          }
                    }else{

                              $error_name = "Unit of measurement is Empty";
                              $status = 0;
                              $unitid = '';
                    }
                    
                 }

                 if($status){
                        if($items['consumeable'] != ''){
                          $consume = itemconsumable::where('cat_name', $items['consumeable'])->first();
                          if($consume){
                             $consum = $consume->id;
                             $status = true;

                          }else{

                              $error_name = "consumeable type is not found in database";
                              $status = 0;
                              $consum = '';
                          }
                    }else{

                              $error_name = "consumeable Field is Empty";
                              $status = 0;
                              $consum = '';
                    }
                    
                 }



                 if($status){
                        if($items['titles'] != ''){
                         $item_name = item::where('title',$items['titles'])->where('category_id',$catid)->where('brand',$subcatid)->where('department',$dept)->where('unit_id',$unitid)->where('cons_id',$consum)->first();
                          if($item_name){
                             $titles = $item_name->id;
                             $status = true;

                          }else{

                              $ids = DB::select(DB::raw("SELECT nextval('prch_items_id_seq')"));
                              $iditem = $ids[0]->nextval+1;
                              $cat = str_pad($catid, 2, '0', STR_PAD_LEFT);
                              $units = str_pad($unitid, 2, '0', STR_PAD_LEFT);
                              $item = str_pad($iditem, 4, '0', STR_PAD_LEFT);
                              $barcode = $cat.$units.$item;
                         $item_number = $barcode;
                         $array = array(
                                        'item_number'  =>  $item_number,
                                        'title'  => $items['titles'],
                                        'hsn_code'  => $items['hsn_code'],
                                        'category_id'  => $catid,
                                        'brand'  => $subcatid,
                                        'department'  => $dept,
                                        'unit_id'  => $unitid,
                                        'cons_id'  => $consum,
                                        'description' => $items['description'],
                                        //'quantity' => $items['quantity']
                               );
                          //dd($array);
                         $insrt = item::create($array);
                         $titles = $insrt->id;
                         $status = true;


                          }

                    }else{

                              $error_name = "Item is Field is Empty";
                              $status = 0;
                              $titles = '';
                    }
                    
                 }





                 // return $error_name."-".$status."-".$titles;

                  if($status){

            $array = array(
                             'quantity' => $items['quantity']
                         );
                //dd($array);
                    item::where('id',$titles)->increment('quantity', intval($items['quantity']));
          }else{

            
             $errors[] = array(
                            //'item_number'  =>  $item_number,
                            'title'  => $items['titles'],
                            'hsn_code'  => $items['hsn_code'],
                            'category_id'  => $items['category_name'],
                            'brand'  => $items['subcategory_name'],
                            'department'  => $items['department'],
                            'unit_id'  => $items['units'],
                            'cons_id'  =>$items['consumeable'],
                            'description' => $items['description'],
                            'quantity' => $items['quantity'],
                            'error_filed' => $error_name,

             );
          }

              }
      }
       if(count($errors) !=0){
            return Excel::download(new ItemsExport($errors), 'Item_error.xlsx');

        }else{
          
           return redirect()->route('item.index');
        }
  }

      
    public function excelItemsExport() 
    {
        return Excel::download(new ItemsExcelExport, 'Items_'.date("d-M-Y").'.xls');
    }

}
