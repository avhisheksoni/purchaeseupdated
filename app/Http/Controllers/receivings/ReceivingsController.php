<?php

namespace App\Http\Controllers\receivings;

use DB;
use Auth;
use Session;
use App\item;
use App\sites;
use Carbon\Carbon;
use App\Warehouse;
use App\Department;
use App\Receivings;
use App\item_category;
use App\ReceivingsItem;
use App\ReceivingsRequest;
use Illuminate\Http\Request;
use App\purchase_stored_item;
use App\ReceivingsRequestItem;
use App\Http\Controllers\Controller;
use App\Model\store_inventory\StoreItem;
use Illuminate\Support\Facades\Validator;

class ReceivingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = sites::where('deleted_at', '=', Null)->orderBy('id','ASC')->get();
        //dd($sites['job_describe']);
        return view('receivings.index', compact('sites'));
    }

/*--------------------------------------------------------------------------------------------------------*/

    public function fetchItems(Request $request)
    {
       // dd($request->all());
        $query  = $request->get('query');
        $data   =  item::where('title', 'ILIKE', "%{$query}%")->orwhere('item_number', 'ILIKE', "%{$query}%")->get();
       // dd($data);
        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

        if(count($data) != null)
        {
              foreach($data as $row)
              {
                $output .= '<li id="selectLI"><a id="getItemID" href="?itemId='.$row->id.'" style="pointer-events: none;" value="'.$row->id.'">'.$row->title .' | '.$row->item_number.'  </a></li>';
              }
        }
        else
        {
            $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
        $output .= '</ul>';
        echo $output;
    }

/*--------------------------------------------------------------------------------------------------------*/

    public function store(Request $request)
    {
         if($request->flag == 'item_list_update')
          {
            $itemData = item::with('unit')->where("item_number",$request->item_number)->first();

            $actual_qty = purchase_stored_item::where("item_number",$request->item_number)->where('warehouse_id','1')->first();

           // dd($actual_qty);

            if(session('receiving_data') == null)
            {
              $insertData[$itemData->id] = $this->create_receiving_items($actual_qty,$itemData);
                session()->put('receiving_data',$insertData);
            }
            else
            {
                $sessionDatas = session('receiving_data');
                $sessionData = '';

                foreach ($sessionDatas as $key => $value) {
                    if($key == $itemData->id){
                        $sessionData = session('receiving_data')[$itemData->id];
                        // $sessionData[]
                       $value['qty'] = $value['qty'] + 1;
                       $sessionDatas[$key] = $value;
                    }
                }           
                    if($sessionData ==null){               
                        $sessionDatas[$itemData->id] = $this->create_receiving_items($actual_qty,$itemData);
                    }

                    session()->put('receiving_data',$sessionDatas);
            }

            //dd(session()->get('receiving_data'));

          }elseif($request->flag == 'item_quntity_update'){
            $sessionDatas = session('receiving_data');
            $sessionData = '';
            foreach ($sessionDatas as $key => $value) {
                if($key == $request->item_id){
                    $sessionData = session('receiving_data')[$request->item_id];
                    // $sessionData[]
                   $value['qty'] = $request->qty;
                   $sessionDatas[$key] = $value;
                }
            }     
             session()->put('receiving_data',$sessionDatas);
          }

      return view('receivings.itmes-display');

    }

/*--------------------------------------------------------------------------------------------------------*/


    public function create_receiving_items($actual_qty,$itemData){ //sesssion create itmes
        $data = [
            'actual_qty'    => $actual_qty->quantity,
            'item_id'       => $itemData->id,
            'name'          => $itemData->title,
            'unit_id'       => $itemData->unit->name,
            'item_number'   => $itemData->item_number,
            'qty'           => '1',
        ];
        return $data;
    }

    public function sessionDistroy(){
       session()->forget('receiving_data');
       Session::remove('receiving_session');
        Session::remove('receiving_request');
        Session::remove('receiving_data');

        return redirect()->back();
    }

/*--------------------------------------------------------------------------------------------------------*/

    public function remove_entry_session(Request $request)
    {
        $id = $request->item_id;
        //dd($id);
        session::forget('receiving_data.'.$id);  

        $data = session('receiving_data');

        session()->flash('success', 'Product removed successfully');

          return redirect()->back();
    }

/*--------------------------------------------------------------------------------------------------------*/
  
    public function saveReceivingItems(Request $request)
    {
      $var= Carbon::now('Asia/Kolkata');
      $request_id = session()->get('receiving_request')['request_id'];
      if($request_id != Null){
      	$req_id = session()->get('receiving_request')['request_id'];
      }else{
      	$req_id = '0';
      }
        $data['date']          = $var->format('Y-m-d H:i:s');
        $data['site_id']       = $request->destination_id;
        $data['remark']        = $request->comment;
        $data['manager']	   =  '1';
        $data['warehouse_id']  =  '1';
        $data['dispatcher_id'] =  Auth::id();
        $data['total_quantity']= $request->total_qty;
        $data['receiving_req_id'] = $req_id;

        $lastId = Receivings::create($data)->id;

        if($lastId == true){
          $session_data = session()->get('receiving_data');
          foreach($session_data as $item)
          {
            $items['receiving_id'] = $lastId;
            $items['item_id']      = $item['item_id'];
            $items['qty']          = $item['qty'];
            $items['unit']      = $item['unit_id'];
            $items['site_id']      = $request->destination_id;
            $items['warehouse_id'] = '1';
            $items['remain_qty_warehouse'] = $item['actual_qty']-$item['qty'];
            ReceivingsItem::create($items);

            purchase_stored_item::where('item_id', $item['item_id'])
                                  ->where('warehouse_id', '1')
                                  ->decrement('quantity', $item['qty']);
          }
        }


        if($request_id != Null){
      		ReceivingsRequest::where('id', $req_id)
      						->update([
      							'complete' => '1',  // 1 for dc generated by request
      							'return_receiving_id' => $lastId
      						]);
      	}
        session::forget('receiving_data');
        session::forget('receiving_request');
        session::forget('receiving_session');
        //Session::remove('receiving_data');
       
        return $lastId;
    }

    /*--------------------------------------------------------------------------------------------*/

    public function generateDC(Request $request)
    {
      $req_id = $request->request_id;
      $rec_req = ReceivingsRequest::with('req_items','sitename','warename')->where('id', $req_id)->first();

      $receiving_request = [];

        foreach ($rec_req['req_items'] as $index) {
          $item_name = item::with('unit')->where('id', $index->item_id)->first();

          $actual_qty = purchase_stored_item::where("item_id",$index->item_id)->where('warehouse_id', $rec_req->warehouse_id)->first();
          //dd($actual_qty);

          $item[$index->item_id] = [
              'item_id'         => $index->item_id,
              'actual_qty'      => $actual_qty->quantity,
              'name'            => $item_name->title,
              'unit_id'         => $item_name->unit->name,
              'item_number'     => $index->item_number,
              'qty'             => $index->qty,
            ];
        }

    $receiving_request['request_id']  = $req_id;
    $receiving_request['requested_by']  = $rec_req->site_id;
    $receiving_request['site_name']     = $rec_req->sitename->job_describe;
    $receiving_request['requested_to']  = $rec_req->warehouse_id;
    $receiving_request['ware_name']  = $rec_req->warename->name;

    session()->put('receiving_session', 1);
    session()->put('receiving_request', $receiving_request);
    session()->put('receiving_data', $item);

        return redirect()->route('receiving');
    }

    public function declineDC($id){

    	$req_id = ReceivingsRequest::where('id', $id)->first();
    	$warehouse_id = $req_id->warehouse_id;
    	$req_item = ReceivingsRequestItem::where('receiving_request_id', $id)->get();
    	//dd($req_item);

    	foreach($req_item as $item)
          {
            purchase_stored_item::where('item_id', $item->item_id)
                                  ->where('warehouse_id', $warehouse_id)
                                  ->increment('quantity', $item->qty);
          }

          ReceivingsRequest::where('id', $id)
      						->update([
      							'complete' => '2'  // 2 for dc declined
      						]);
        return redirect()->back();
    }

}
