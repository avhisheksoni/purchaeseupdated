<?php

namespace App\Http\Controllers;

use App\StoreManagement;
use App\PO_SendToVendors;
use App\vendor;
use App\QuotationReceived;
use App\QuotationApprovals;
use App\item;
use App\prch_itemwise_requs;
use App\item_quantity;
use App\item_quantity_hsty;
use App\sites;
use App\Model\store_inventory\StoreItem;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$data = DB::table('prch_po_send_to_vendors')
            ->join('prch_vendors', 'prch_po_send_to_vendors.vendor_id', '=', 'prch_vendors.id')
            ->orderBy('prch_po_send_to_vendors.created_at', 'desc')
            ->select('prch_po_send_to_vendors.*', 'prch_vendors.*')
            ->where('prch_po_send_to_vendors.po_accept_status', '=', '1')->paginate(10);
            //dd($data);

        return view("store_management.index",compact("data"))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function ViewAcceptedPO($id){
        /*$approvedData = DB::table('prch_quotation_approvals')
            ->join('prch_vendors', 'prch_quotation_approvals.vendor_id', '=', 'prch_vendors.id')
            ->join('prch_vendors_mail_sends', 'prch_quotation_approvals.quote_id', '=', 'prch_vendors_mail_sends.id')
            ->orderBy('prch_quotation_approvals.created_at', 'desc')
            ->select('prch_quotation_approvals.*', 'prch_vendors.*', 'prch_vendors_mail_sends.*')
            ->where('prch_quotation_approvals.manager_status', '=', 1)->where('prch_quotation_approvals.level1_status', '=', 1)->where('prch_quotation_approvals.level2_status', '=', 1)->where('prch_quotation_approvals.rfi_id', '=', $id)->get(); //paginate(10);*/

        /*foreach ($approvedData as $key) {
			$quote_id = $key->quote_id;
            $rfi_id = $key->rfi_id;
			$vid = $key->vendor_id;
      //dd($approvedData);
			$data = QuotationReceived::where('quotion_sends_id',$quote_id)->where('vender_id',$vid)->get();
			$PO_no = PO_SendToVendors::where('approval_quotation_id',$rfi_id)->get();
		}
		return view("store_management.view_accepted_po", compact('data','PO_no'));*/
        $rfik = $id;
        $data = QuotationApprovals::with('vendors_mail_items','QuotationReceived.vendorsDetail','rfi_status','prchitemres')
                        ->where('id', '=', $id)->paginate(10);
        $pritem = $data[0]->prchitemres->prch_rfi_users_id;
                      // return $data[0]['prchitemres'];
        return view("store_management.view_accepted_po", compact('data','rfik','pritem'));
    }

    // Fetch GRN for store manager
    public function FetchAllGRN(){
    		$data = '';
    		return view("store_management.view_grn");
    }

    public function upstock(Request $request,$id,$ids){
          // return $ids;
          $item_q = explode('||',$id);
          $qtyofitem =$item_q[1];
          $itemno =   explode('|',$item_q[0]);
          $getno = $itemno[1]; 
          $itemname = $itemno[0]; 
          
          $sum = StoreItem::where('item_number',$getno)->get()->sum('quantity');
          //$purch = prch_itemwise_requs::where(['prch_rfi_users_id'=>$ids,'item_no'=>$getno])->update(['ready_to_dispatch'=>4]); //ready_to_dispatch ==4 means item now avaible to dispatch 
          if($sum == 0 ){
             $sum+= $qtyofitem;
           return view("store_management.warehouse_status",compact('itemname','getno','qtyofitem','sum','ids'));
              }else{
                $sum+= $qtyofitem;
return view("store_management.warehouse_status",compact('itemname','getno','qtyofitem','sum','ids'));
              }

    }

    public function upwareqty(Request $request){
      //return $request->ids;
      //return $request->all();
        $data = $request->validate([
        //'item_number'=>'required',
        'quantity'=>'required',
        'warehouse_id'=>'required',

    ]);
        if($request->warehouse_id == 1){   
        $dataw['quantity' ] = 0;
        $dataw['warehouse_id' ] = 2;
        }

        if($request->warehouse_id == 2){   
        $dataw['quantity' ] = 0;
        $dataw['warehouse_id' ] = 1;
        }


       $iqty['item_id'] = $request->item_number;
       $iqty['quantity'] = $request->sum;
       $iqty['current_date'] = date('Y-m-d');
        $hiqty['item_id'] = $request->item_number;
       $hiqty['quantity'] = $request->sum;
       $hiqty['current_date'] = date('Y-m-d');
       $hiqty['login_user_id'] = Auth::user()->id;
       $hiqty['wareh_id'] = $request->warehouse_id;
       // $hiqty['current_date'] = date('y-m-d');
       $hiqty['transection_id'] = 1;
        item_quantity::create($iqty);
        item_quantity_hsty::create($hiqty);
       $unit = item::where('item_number',$request->item_number)->first('unit_id');
        $sites = sites::pluck('id');
        foreach ($sites as $site) {
          $sitemq= item_quantity::where('site_id',$site)->where('item_id',$request->item_number)->get();
          if(count($sitemq) == 0){
            $ziq['quantity'] = 0;
            $ziq['current_date'] = date('Y-m-d');
            $ziq['site_id'] = $site;
            $ziq['item_id'] = $request->item_number;
            $ziq['unit_id'] = $unit->unit_id;
            $ziq['wareh_id'] = 1;
            //return $ziq;
            $ziqw['quantity'] = 0;
            $ziqw['current_date'] = date('Y-m-d');
            $ziqw['site_id'] = $site;
            $ziqw['item_id'] = $request->item_number;
            $ziqw['unit_id'] = $unit->unit_id;
            $ziqw['wareh_id'] = 2;
            item_quantity::create($ziq);
            item_quantity::create($ziqw);
          }
        }
       //return $hiqty;

        if(strlen($request->item_number) == 8 ){
          $iditem = $request->item_number;
        }else{
          $iditem = "0".$request->item_number;
        }
        $data['item_number'] = $iditem;
        $dataw['item_number'] = $iditem;
        //return $dataw;
        
       $item['quantity']= $request->quantity;
       $itemid = item::where('item_number',$iditem)->first();
       $data['item_id'] = $itemid->id;
       $dataw['item_id'] = $itemid->id;
       $qty = StoreItem::where('item_number',$iditem)->where('warehouse_id',$request->warehouse_id)->first();
       if($qty == null){
        StoreItem::create($data);
        StoreItem::create($dataw);
        $purch = prch_itemwise_requs::where(['prch_rfi_users_id'=>$request->ids,'item_no'=>$request->item_number])->update(['ready_to_dispatch'=>4,'dispatch_status'=>1,'from_warehouse'=>$request->warehouse_id]); //ready_to_dispatch ==4 means item now avaible to dispatch 
      }else{
        StoreItem::where('item_number',$iditem)->where('warehouse_id',$request->warehouse_id)->increment('quantity',$request->quantity);
        $purch = prch_itemwise_requs::where(['prch_rfi_users_id'=>$request->ids,'item_no'=>$request->item_number])->update(['ready_to_dispatch'=>4,'dispatch_status'=>1,'from_warehouse'=>$request->warehouse_id]); //ready_to_dispatch ==4 means item now avaible to dispatch 
      }


        return redirect()->back();

    }

    public function getwaredetails(Request $request){
      
       $qty = StoreItem::where('item_number',$request->it_no)->where('warehouse_id',$request->ware_id)->first();
        if($qty != ''){
          $data['add'] = $qty->quantity+$request->qty;
          $data['mgs'] = "Total Quantity In This warehouse will now ".$data['add'];
          return $data;
    }else{ 
       $data['add'] = $request->qty;
       $data['mgs'] = "Total Quantity In This warehouse will ".$request->qty;

       return $data;
    }


    }
    

    
}
