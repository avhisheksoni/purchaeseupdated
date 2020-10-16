<?php

namespace App\Http\Controllers;

use App\RequestForItem;
use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\vendor;
use App\item;
use App\unitofmeasurement;
use App\RfiUsers;
use App\RfiManager;
use App\RfiDiscardReason;
use App\User;
use App\VendorsMailSend;
use App\Warehouse;
use App\Model\store_inventory\StoreItem;
use App\Notifications\RFQ_Notification;
use \App\Mail\SendMailToVendors;
use Laravel\LegacyEncrypter\McryptEncrypter;
use PDF;
use DB;
use Helper;

class RequestForItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    		$user_id = Auth::user()->id;
        $request_for_items = RfiUsers::where('user_id',$user_id)->latest()->paginate(10);
        return view('request_for_item.index', compact('request_for_items'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = unitofmeasurement::get();
        return view('request_for_item.create', compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find(Auth::user()->id);
        $rolename = $user->hasRole('purchase_user'); //$role[0]->name;

        //dd($rolename);
      	$count = count($request->item_name);	
		  	if($count != 0){
		  	 	$x = 0;
		  	 	$data = array();
		  	 	while($x < $count){
		  	 		if($request->item_name[$x] !=''){
						  $RequestForItem = array(
					 				'item_name' => $request->item_name[$x],
			            'quantity' => $request->quantity[$x],
                  'unit_id' => $request->unit[$x],
			            'description' => $request->description[$x],
			            'user_id' => $request->user_id[$x],
					 		);
					 		$data[] = $RequestForItem;
						}			  
		  	 		$x++;
		  	 	}
          //dd($data);
		  	 	$request_data = new RfiUsers;
    			$request_data->requested_data = json_encode($data);
    			$request_data->user_id = $id;
    			$request_data->requested_role = ($rolename == 'true') ? 'Users' : 'Manager';
    			$request_data->save();

    			$request_data = new RfiManager;
    			$request_data->data = json_encode($data);
    			$request_data->requested_id = $id;
    			$request_data->save();

    			$member_details = $request_data->requested_id;
          /*$Auth = auth()->user()->roles()->get();
          $rol_id = $Auth[0]->id;*/
	        $details = Member::where('user_id',$member_details)->get();
	        $users = Member::whereIn('role_id',['22','23'])->get();
	        foreach ($users as $user) {
	        	$send_users = User::find($user->user_id);
	        	$send_users->notify(new RFQ_Notification($details));
	        }
		  	}
      	return redirect()->route('request_for_item.index')->with('success','Your RFI Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function show(RequestForItem $requestForItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
    		$data = RfiUsers::with('discardReason')->where('id',$id)->get();
        $unit = unitofmeasurement::get();
        foreach ($data as $requestForItem) {
        	return view('request_for_item.edit',compact('requestForItem','unit'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestForItem $requestForItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RfiUsers::find($id)->delete();
        return redirect()->route('request_for_item.index')->with('success','Your RFI deleted successfully');
    }

    public function UsersRequest()
    {
    		$uid = Auth::user()->id;
    		// $request_for_items = RfiUsers::latest()->paginate(10);
        $request_for_items = RfiUsers::where('requested_role','Users')->latest()->paginate(10);
    		foreach ($request_for_items as $key) {
    			$mid = $key->id;
    			//$MailStatus = VendorsMailSend::where('quotion_sent_id',$mid)->get();
    			// $MailStatus = VendorsMailSend::all();
    		}
        $MailStatus = VendorsMailSend::all();
    		return view('request_for_item.user_request', compact('request_for_items', 'MailStatus'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function ManagerRequest()
    {
        $uid = Auth::user()->id;
        $request_for_items = RfiUsers::where('requested_role','Manager')->latest()->paginate(10);
        $MailStatus = VendorsMailSend::all();
        return view('request_for_item.manager_request', compact('request_for_items', 'MailStatus'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function UsersRequestStatus(Request $request, $id)
    {
        $loggedin_Id = Auth::user()->id;
        $data = RfiUsers::with('discardReason')->where('id',$id)->get();
        $unit = unitofmeasurement::get();
        foreach ($data as $requestForItem) {
          $requested_user_id = $requestForItem->user_id;
          $mem = User::where('id',$requested_user_id)->get();
          foreach ($mem as $mem_details) {
            return view('request_for_item.user_req_status',compact('requestForItem', 'mem_details', 'unit'));
          }
        }
    }

    public function CheckUsersRFI(Request $request, $id)
    {
        $loggedin_Id = Auth::user()->id;
        $data = RfiUsers::with('discardReason')->where('id',$id)->get();
        $unit = unitofmeasurement::get();
        $warehouse = Warehouse::get();
        foreach ($data as $requestForItem) {
          $requested_user_id = $requestForItem->user_id;
          $mem = User::select('id','name','email','filestack_id','workspace_id','parent_id')->where('id',$requested_user_id)->get();
          foreach ($mem as $mem_details) {
            return view('request_for_item.check_users_rfi',compact('requestForItem', 'mem_details', 'unit', 'warehouse'));
          }
        }
    }

    public function UsersRequestUpdate(Request $request, $id){
            $request->validate([
                'status' => 'required'
            ]);

            $count = count($request->item_name);    
            if($count != 0){
                $x = 0;
                $data = array();
                while($x < $count){
                    if($request->item_name[$x] !=''){
                      $RequestForItem = array(
                        'item_name' => $request->item_name[$x],
                        'quantity' => $request->quantity[$x],
                        'unit_id' => $request->unit[$x],
                        'description' => $request->description[$x],
                        'user_id' => $request->user_id,
                      );
                      $data[] = $RequestForItem;
                    }             
                    $x++;
                }
                $update_data = array(
                    'requested_data'    =>      json_encode($data),
                    'user_id'           =>      $request->user_id,
                    'manager_status'    =>      $request->status,
                );
                $manager_status =   $request->status;
                if($manager_status == 2){
                    $request->validate([
                        'discardReason' => 'required'
                    ]);
                    $reason = array(
                        'rfi_id' =>  $id,
                        'discard_reason'  =>  $request->discardReason,
                    );
                    RfiDiscardReason::create($reason);
                }
                RfiUsers::where('id', $id)->update(['requested_data'=> json_encode($data), 'user_id' => $request->user_id, 'manager_status' => $request->status,]);
            }
            return redirect()->route('user_request')->with('success','Your status has been updated');
    }

    public function ApplyForQuotation($id)
    {
    		$data = RfiUsers::where('id',$id)->get();
    		$vendor = vendor::all();
	  		$role = $data[0]->requested_role;
        $unit = unitofmeasurement::get();
	  		if($role == 'Manager'){
	  			$status = 0;
	  		}else{
	  			$status = 1;
	  		}
	  		$requested = RfiUsers::where('id',$id)->where('requested_role',$role)->where('manager_status',$status)->get();
	  		return view('request_for_item.applyforquotation',compact('requested','vendor','unit'));
    }

    public function RfiQuotationToMail(Request $request, $id){
    		//$email = $request->vendor_name;
    		$vendor_id = $request->vendor_id;
    		foreach ($vendor_id as $vendor_ids) {
    			$vendor = vendor::find($vendor_ids);
    			$tbl = $request->table;
    			$pdf = PDF::loadView('request_for_item.rfi_quotation', compact('tbl'));
    			$pdf = $pdf->Output('', 'S');
    			//$pdf->stream('rfi_quotation'.date("d-M-Y").'.pdf', array("Attachment" => False));

    			$rfq = RfiUsers::find($id);
    			$autoId = DB::select(DB::raw("SELECT nextval('prch_vendors_mail_sends_id_seq')"));
  				$nextval = $autoId[0]->nextval+1;
  				//$nextval = Helper::getRFQSendMailAutoIncrementId();
    			$data = array(
    					'email'		=>		json_encode($vendor_id),
    					'quotion_id'	=>	'#RFQ'.str_pad($nextval, 4, '0', STR_PAD_LEFT),
    					'quotion_sent_id' => $id,
    					'item_list'		=>	$rfq->requested_data
    			);
    			$datas = VendorsMailSend::create($data);
    			$quotion_id = $datas->id;
    			$details = array(
    				'table' => $request->table,
    				'name' => $vendor->name,
    				'email' => $vendor->email,
    				'pdf' => $pdf,
    				'quotion_id' => $quotion_id,
    				'vendor_id' => $vendor->id,
    			);
    			\Mail::to($vendor->email)->send(new SendMailToVendors($details));
    		}
    		return redirect()->route('user_request')->with('success','Mail sends successfully');
    }

    public function fetch(Request $request)
    {
      if($request->get('query'))
      {
        $query = $request->get('query');
        $data = item::where('title', 'ILIKE', "%{$query}%")->orWhere('item_number', 'LIKE', "%{$query}%")->get();
        $output = '<ul class="dropdown-menu items-dropdown" style="display:block; position:relative">';
        if(count($data) != null)
        {
          foreach($data as $row)
          {
            $output .= '<li><a id="getItemID" href="?itemId='.$row->id.'" style="pointer-events: none;" value="'.$row->id.'">'.$row->title .' | '.$row->item_number.'</a></li>';
          }
        }
        else
        {
          $output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
        }
        $output .= '</ul>';
        echo $output;
      }
    }

    public function SetWareHouse(Request $request)
    { 
      //dd($request);
      $item_number = $request->item_num;
      $warehouse_id = $request->warehouse_id;
      $req_qty = $request->req_qty;

      $store_items = StoreItem::where('item_number', $item_number)->get();
      if(count($store_items) !== 0){
        foreach ($store_items as $store) {
          $wid = json_decode($store->warehouse_id);
          $wid1 = json_decode($store->warehouse_id);
          $quantity = json_decode($store->quantity);
          $count = count($wid);
          for ($i=0; $i < $count; $i++) { 
            if($warehouse_id == $wid[$i]){
              if($quantity[$i] >= $req_qty){
                return "";
              }elseif($quantity[$i] === "0"){
                return '0 item';
              }else{
                return 'only '.$quantity[$i].' item is available';
              }
            }
          }
        }
      }else{
        return $requsted_qty = 'item not available';
      }


      /*$item_number = $request->item_num;
      $warehouse_id = $request->warehouse_id;
      $req_qty = $request->req_qty;

      $store_items = StoreItem::where('item_number', $item_number)->Where('warehouse_id', $warehouse_id)->get();
      if(count($store_items) !== 0){
        $store_qty = (!empty($store_items[0]->quantity)) ? $store_items[0]->quantity : '0';
        if($store_qty >= $req_qty){
          return $requsted_qty = "";
        }else{
          return $requsted_qty = 'only '.$store_qty.' item is available';
        }
      }else{
        return $requsted_qty = 'item not available';
      }*/
    }
}
