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

class ApproveTransferController extends Controller
{
	public function index()
    {
    	//dd("ok");
        $receivings = Receivings::with('site','warehouse')->where('receiving_req_id', '!=', 0)->orderBy('id','ASC')->get();
        
        $all_rec = Receivings::with('site','warehouse')->orderBy('id','ASC')->get();
        //dd($sites['job_describe']);
        return view('receivings.app_index', compact('receivings','all_rec'));
    }

    public function adminApprove($id)
    {
    	//dd($id);
        $receivings = Receivings::where('id', $id)->update([
        				'admin'		=>	'1',    
        				'complete'	=>	'1'		// 1 = admin level approval
        					]);
        return redirect()->back();
    }

    public function superAdminApprove($id)
    {
    	//dd($id);
        $receivings = Receivings::where('id', $id)->update([
        				'super_admin'	=>	'1',
        				'complete'		=>	'1'		// 1 = super admin level approval
        					]);
     return redirect()->back();   
    }

    public function declineDC($id){

    	$req_id = Receivings::where('id', $id)->first();
    	$warehouse_id = $req_id->warehouse_id;
    	$req_item = ReceivingsItem::where('receiving_id', $id)->get();
    	//dd($req_item);

    	foreach($req_item as $item)
          {
            purchase_stored_item::where('item_id', $item->item_id)
                                  ->where('warehouse_id', $warehouse_id)
                                  ->increment('quantity', $item->qty);
          }

          Receivings::where('id', $id)
      						->update([
      							'complete' => '2'  // 3 for dc declined
      						]);
        return redirect()->back();
    }
}