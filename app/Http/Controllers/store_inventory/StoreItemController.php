<?php

namespace App\Http\Controllers\store_inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\store_inventory\StoreItem;
use App\Department;
use App\item;
use App\item_category;
use App\Warehouse;
use App\purchase_stored_item;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class StoreItemController extends Controller
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
        $warehouse = Warehouse::all();
        $items =item::with(['brand_name','department_name','category','unit','items_qty', 'items_qty.store_warehouse'])->get();
        $war1 =  item::with(['brand_name','department_name','category','unit','items_qty', 'wonee'])->has('wonee')->get();//wonee
        $war2 =  item::with(['brand_name','department_name','category','unit','items_qty', 'wtwoo'])->has('wtwoo')->get();//wtwoo
        return view('store_item.index',compact('items','warehouse','war1','war2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_qty(Request $request)
    {
        $item_id = $request->item_id;
        $item_number = $request->item_number;
        $warehouse_id = json_encode($request->warehouse_id);
        $quantity = json_encode($request->quantity);
        $item_qty = StoreItem::where('item_id',$item_id)
                            ->where('item_number',$item_number)
                            ->get();
        if(count($item_qty) !== 0) {
            $fetch_wh_id = json_decode($item_qty[0]->warehouse_id);
            $text = array_intersect($request->warehouse_id, $fetch_wh_id);
            if(array_intersect($request->warehouse_id, $fetch_wh_id)){
                StoreItem::where('item_id', $item_id)->where('item_number',$item_number)->update(['quantity' => $quantity, 'warehouse_id' => $warehouse_id ]);
            }
        }else{
            $data = new StoreItem;
            $data->quantity = $quantity;
            $data->item_number = $item_number;
            $data->item_id = $item_id;
            $data->warehouse_id = $warehouse_id;
            $data->save();
        }


        /*$item_id = $request->item_id;
        $item_number = $request->item_number;
        $warehouse_id = $request->warehouse_id;

        $item_qty = StoreItem::where('item_id',$item_id)
                            ->where('item_number',$item_number)
                            ->get();
        if(count($item_qty) !== 0) {
            $fetch_wh_id = $item_qty[0]->warehouse_id;
            if($fetch_wh_id == $warehouse_id){
                StoreItem::where('item_id', $item_id)->where('item_number',$item_number)->where('warehouse_id',$warehouse_id)->update(['quantity' => $request->input('quantity')]);
            }else{
                StoreItem::where('item_id', $item_id)->where('item_number',$item_number)->update(['quantity' => $request->input('quantity'), 'warehouse_id' => $warehouse_id ]);
            }
        }else{
            $data = new StoreItem;
            $data->quantity = $request->input('quantity');
            $data->item_number = $item_number;
            $data->item_id = $item_id;
            $data->warehouse_id = $warehouse_id;
            $data->save();
        }*/
    }
}
