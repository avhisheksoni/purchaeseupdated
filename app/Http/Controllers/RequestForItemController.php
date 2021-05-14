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
use App\prch_itemwise_requs;
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
      ///return "pg";
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

        //dd($request->item_name);
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
          $lastid = $request_data->id;
          //dd($request_data);

    			$request_data = new RfiManager;
    			$request_data->data = json_encode($data);
    			$request_data->requested_id = $id;
    			$request_data->save();
         // dd($data);
              $i = 0;
          while($i < $count){
            if($request->item_name[$i] !=''){
              $itno = explode("|",$request->item_name[$i]);
             //dd($itno);
              $itonly = intval($itno[1]);
              if(strlen($itonly) == 7){
                $itemns = '0'.$itonly;
              }else{
                $itemns = $itonly;
              }
              //return strlen($itonly);
              $itname = $itno[0];
              //return gettype($itonly);
              // return $idmain = item::where('item_number',$itemns)->first();
              $idmain = DB::table('prch_items')->where('item_number', $itemns)->value('id');
              $newdata = array(
                  'item_no' => $itonly,
                  'quantity' => $request->quantity[$i],
                  'unit_id' => $request->unit[$i],
                  'description' => $request->description[$i],
                  'user_id' => $request->user_id[$i],
                  'item_name' => $itname,
                  'prch_rfi_users_id' => $lastid,
                  'item_id' => $idmain,
                  'requested_role' => ($rolename == 'true') ? 'Users' : 'Manager',
              );
               

            prch_itemwise_requs::create($newdata);

            }       
            $i++;
          }

            //return $newdata;
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

    public function dispatchitem(){
       
      // $request_for_items = RfiUsers::where('requested_role','Users')->where('level1_status','1')->where('level2_status','1')->latest()->paginate(10);
      $prch_item = prch_itemwise_requs::groupBy('prch_rfi_users_id')->selectRaw('count(*) as prch_rfi_users_id')->select('prch_rfi_users_id')->paginate(10);

         
      return view('request_for_item.dispatch_list',compact('prch_item'));
    }

    public function showdisitem($id){
        
      $items = prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'ready_to_dispatch'=>4,'dispatch_status' =>1])->get();
     // dd($items);
      $user = DB::table('prch_req_itemwise')->where('prch_rfi_users_id', $id)->value('user_id');
      //return  $items;
      if($items->isEmpty() == false){
        $chk = '';
      return view('request_for_item.dispatch_item_detail',compact('items','user','chk'));
      }else{
        $chk = "item hasbeen Dispatch";
        return view('request_for_item.dispatch_item_detail',compact('items','user','chk'));

    }
    }

    public function dispatchtouser(Request $request,$id){
      $itemid = prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'ready_to_dispatch'=>4,'dispatch_status' =>1])->get();
       foreach($itemid as $item){
       
        // if($item->item_no == 8 ){
        //     $iditem = $item->item_no;
        // }else{
        //    $iditem = "0".$item->item_no;
        // }
       $iditem = $item->item_no;
       $itemins1 = StoreItem::where(['item_number'=>$iditem,'warehouse_id'=>$item->from_warehouse])->first();
        if($itemins1 == ''){
          $qty13 = 0;
        }else{
           $qty13 = $itemins1->quantity;
        }
       
        if($qty13 >= $item->squantity){
       
           $itemleft1 = $itemins1->quantity - $item->squantity;//9000
            "warehouse1";
           $sqty = StoreItem::where(['item_number'=>$iditem,'warehouse_id'=>$item->from_warehouse])->decrement('quantity',$item->squantity);
           prch_itemwise_requs::where('prch_rfi_users_id',$id)->where('item_no',$item->item_no)->update(['dispatch_status'=>'2','dispatch_date'=>date('Y-m-d')]);
           $mgs = "Item Dispatch successfully";
        }

        else{

          $mgs  = "Cant Dispatch Item Is Not In Stock";

      }

      }
       if($mgs != 'Cant Dispatch Item Is Not In Stock' ){
      
      return redirect()->back()->with('success',$mgs);
    }else{
      return redirect()->back()->with('success',$mgs);
    }
   
    }

    public function disabletodispatch(){
      $prch_item = prch_itemwise_requs::groupBy('prch_rfi_users_id')->selectRaw('count(*) as prch_rfi_users_id')->select('prch_rfi_users_id')->paginate(10);

      return view('request_for_item.newquotation_list',compact('prch_item'));
    }

    public function showdisbleForquo($id){

      $items = prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'ready_to_dispatch'=>0,'dispatch_status' =>0])->get();
      $MailStatus = VendorsMailSend::where('quotion_sent_id',$id)->first();
      $userrfi = RfiUsers::find($id);
      $user = DB::table('prch_req_itemwise')->where('prch_rfi_users_id', $id)->value('user_id');
      //return  $items;
      if($items->isEmpty() == false){
        $chk = '';
      return view('request_for_item.itemQuoation',compact('items','user','chk','userrfi','MailStatus'));
      }else{
        $chk = "item hasbeen Dispatch";
        return view('request_for_item.itemQuoation',compact('items','user','chk','userrfi','MailStatus'));
        
    }
    }

    public function itemofstock(){

       $uhi = prch_itemwise_requs::where('user_id',Auth::id())->where(['dispatch_status'=>2])->paginate(10);

       return view('request_for_item.stockwithuser',compact('uhi'));
    }

    public function unitemofstock(){

      $uhi = prch_itemwise_requs::where('user_id',Auth::id())->where(['dispatch_status'=>1])->paginate(10);

       return view('request_for_item.unstockwithuser',compact('uhi'));
    }


    public function backtostore(Request $request, $id){
         $qis = intval($request->squantityuser);
         $getitmno = prch_itemwise_requs::find($id);
                    StoreItem::where(['item_number'=>$getitmno->item_no,'warehouse_id'=>$getitmno->from_warehouse])->increment('quantity',$qis);
                    prch_itemwise_requs::where('id',$id)->where('item_no',$getitmno->item_no)->decrement('squantity',$qis,['received_date' => date('yy-m-d')]); 
          return redirect()->back()->with('success','Your Item has been succefully store to wahouse'); 

    }

    public function ManagerRequest()
    {
        $uid =               Auth::user()->id;
        $request_for_items = RfiUsers::where('requested_role','Manager')->latest()->paginate(10);
        $MailStatus =        VendorsMailSend::all();
        return view('request_for_item.manager_request', compact('request_for_items', 'MailStatus'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function UsersRequestStatus(Request $request, $id)
    {
        $loggedin_Id = Auth::user()->id;
        $data = RfiUsers::with('discardReason')->where('id',$id)->get();
        $unit = unitofmeasurement::get();
            foreach ($data as $requestForItem) {
              $requested_user_id = $requestForItem->user_id; 
              $poid = $requestForItem->id; 
               $mem = User::where('id',$requested_user_id)->get();

              foreach ($mem as $mem_details) {
                return view('request_for_item.user_req_status',compact('requestForItem', 'mem_details', 'unit' ,'poid'));
              }
        }
    }

    public function CheckUsersRFI(Request $request, $id)
    {

         $loggedin_Id = Auth::user()->id;
        // $data = RfiUsers::with('discardReason')->where('id',$id)->get();
        $data = prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'dispatch_status'=>0,'remove_item_status'=>0,'ready_to_dispatch'=>0])->get();
        //$data = prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'dispatch_status'=>0,'remove_item_status'=>0,'ready_to_dispatch'=>0])->get();
        if($data->isEmpty() == false){
        $ready_to_dispatch = "";
           $prchid = RfiUsers::find($id);
        foreach($data as $req){
           $name = User::find($req->user_id)->name;
           $email = User::find($req->user_id)->email;
        }

        return view('request_for_item.check_users_rfi',compact('ready_to_dispatch','data','name','email','id','prchid'));
      }else{
        //return "truru";
        $prchid = RfiUsers::find($id);
        foreach($data as $req){
           $name = User::find($req->user_id)->name;
           $email = User::find($req->user_id)->email;
        }
           $ready_to_dispatch = "Ready To Dispatch";
         return view('request_for_item.check_users_rfi',compact('ready_to_dispatch','name','email','id','prchid'));
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
    		$data = RfiUsers::where('id',$id)->first();
        $quo = prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'ready_to_dispatch'=>0,'dispatch_status' =>0])->get();
        
    		$vendor = vendor::all();
	  		$role = $data->requested_role;
        $unit = unitofmeasurement::get();
	  		if($role == 'Manager'){
	  			$status = 0;
	  		}else{
	  			$status = 1;
	  		}
        // dd($status);
	  		$requested = RfiUsers::where('id',$id)->where('requested_role',$role)->where('manager_status',$status)->get();
	  		return view('request_for_item.applyforquotation',compact('requested','vendor','unit','quo'));
    }

    public function RfiQuotationToMail(Request $request, $id){
    		$email = $request->vendor_name;

    		$vendor_id = $request->vendor_id;
        // return $vendor->email
    		foreach ($vendor_id as $vendor_ids) {
    			$vendor = vendor::find($vendor_ids);
          //$vendor->email;
    			$tbl = $request->table;
    			$pdf = PDF::loadView('request_for_item.rfi_quotation', compact('tbl'));
    			$pdf = $pdf->Output('', 'S');
    			//$pdf->stream('rfi_quotation'.date("d-M-Y").'.pdf', array("Attachment" => False));

    			$rfq = RfiUsers::find($id);
          $lft_item = prch_itemwise_requs::where('prch_rfi_users_id',$id)->first();
          $prchitemidnew = $lft_item->prch_rfi_users_id;

    			$autoId = DB::select(DB::raw("SELECT nextval('prch_vendors_mail_sends_id_seq')"));
  				$nextval = $autoId[0]->nextval+1;
  				//$nextval = Helper::getRFQSendMailAutoIncrementId();
    			$data = array(
    					'email'		=>		json_encode($vendor_id),
    					'quotion_id'	=>	'#RFQ'.str_pad($nextval, 4, '0', STR_PAD_LEFT),
    					'quotion_sent_id' => $id,
    					'item_list'		=>	$rfq->requested_data
    			);
    			$datas = VendorsMailSend::create($data);//prch_vendors_mail_sends
    			$quotion_id = $datas->id;
    			$details = array(
    				'table' => $request->table,
    				'name' => $vendor->name,
    				'email' => $vendor->email,
    				'pdf' => $pdf,
    				'quotion_id' => $quotion_id,
    				'vendor_id' => $vendor->id,
            'pitemnew' => $prchitemidnew,
    			);
          //$details;
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
                      if($i == 0){

                        return "only".$quantity[$i]." item is available in Indore and ".$quantity[1]."in Ratlam Warehouse";
                      }else {
                         return "only".$quantity[1]." item is available in Indore and ".$quantity[$i]."in Ratlam Warehouse";
                      }
                // return ' '.$lqty.'';
              }
            }
          }
        }
      }else{
        return $requsted_qty = 'item not available';
      }
    }

    public function managrapv(Request $request){
       $request->pid;
       $data['manager_status'] = '1';
       RfiUsers::where('id',$request->pid)->update($data);
       prch_itemwise_requs::where(['prch_rfi_users_id'=>$request->pid,'ready_to_dispatch'=>2])->update($data);

        //return true;
    }

    public function removereqitem($id){
        
        prch_itemwise_requs::where('id',$id)->update(['remove_item_status'=>1]);
         return redirect()->back()->with('success','Item is successfully Removed');
    }


    public function filterdisquo(Request $request ,$id){
      //return $id;
       $count = count($request->item_no);
       $wid =  $request->wahouse;
        if($count != 0){
                $x = 0;
                $data = array();
                while($x < $count){
                    if($request->item_no[$x] !=''){
                       if(strlen($request->item_no[$x]) != 8 ){
                           $ino = "0".$request->item_no[$x];
                       }else{
                           $ino =     $request->item_no[$x];
                       }

                      $warehouse = StoreItem::where('item_number',$ino)->where('warehouse_id',$wid)->first();
                      if($warehouse != null){
                        
                         $q_send = intval($request->squantity[$x]);
                         $q_having =intval($warehouse->quantity);
                         $q_instore = $q_having-$q_send;
                    if($q_having > $q_send){
                       prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'item_no'=>$request->item_no[$x]])->update(['ready_to_dispatch'=>4,'from_warehouse'=>$wid,'squantity'=>$q_send,'dispatch_status'=>1]);

                    }else{
                       prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'item_no'=>$request->item_no[$x]])->update(['unavaible_in_wh'=>1]);
                    }
                        

                    }else{
                        prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'item_no'=>$request->item_no[$x]])->update(['ready_to_dispatch'=>0,'from_warehouse'=>0,'squantity'=>0,'unavaible_in_wh'=>1]); //3 == item send for quatation && 0 == warehouse not any;
                      

                    }
                    }             
                    $x++;
                }
                 return redirect()->back();
            }  
    }

    public function uprfi_le_one(Request $request){
        $up['manager_status'] = '1';
        $status = RfiUsers::where('id',$request->id)->update($up);
        if(strlen($request->itemid != 8)){
        $warehouse = StoreItem::where('item_number','0'.$request->itemid)->where('warehouse_id',$request->wid)->first();
      }else{
        $warehouse = StoreItem::where('item_number', $request->itemid)->where('warehouse_id',$request->wid)->first();
      }
        if($warehouse == ''){
          $qty = 0; 
        }else{
          $qty = $warehouse->quantity; 
        }
          return $qty."||".$request->mgs;

    }

   public function uprfiaddress(Request $request){
          $data['address_wareh_id'] = $request->id;
          return RfiUsers::where('id',$request->itemid)->update($data);

   } 
}
