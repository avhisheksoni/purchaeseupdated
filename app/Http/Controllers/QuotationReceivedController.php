<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;
use App\Member;
use App\VendorsMailSend;
use App\QuotationReceived;
use App\User;
use App\vendor;
use App\QuotationApprovals;
use App\QuotationApprovedById;
use App\PO_SendToVendors;
use App\prch_itemwise_requs;
use App\Notifications\RFQ_Notification;
use App\Mail\PO_SandsToVendor;

class QuotationReceivedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => array('VendorRFQFormData', 'VendorRFQFormDataStore')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
    		$rfq = DB::table('prch_vendors_mail_sends')->distinct(['quotion_sent_id'])->paginate(10);
    		$data = QuotationApprovals::distinct(['quotation_id'])->get();
        //dd($rfq);

        return view('rfq.index',compact('rfq','vendor','data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VendorsMailSend  $VendorsMailSend
     * @return \Illuminate\Http\Response
     */
    public function show(VendorsMailSend $VendorsMailSend, $id)
    {
       //return $id;
    		$requested = VendorsMailSend::Where('id',$id)->get();
        $requestt = VendorsMailSend::Where('id',$id)->first();
        $pqitems = prch_itemwise_requs::where('prch_rfi_users_id',$requestt->quotion_sent_id)->where('unavaible_in_wh',1)->get();
    		$vid = json_decode($requested[0]->email);
    		foreach ($vid as $key) {
    				$vendor[] = vendor::where('id',$key)->get();
        }
        
        return view('rfq.show',compact('requested','vendor','pqitems'));
    }

    public function ReceivedQuotation($id){
    		$vendor = QuotationApprovals::with('QuotationReceived.vendorsDetail')->where('rfi_id',$id)->get();

        //dd($vendor);

				return view('rfq.receivedQuotation',compact('data','vendor','approval'));
    }

    public function VendorRFQFormData($id, $vid,$pidnew){
      //return $pidnew;
    		return view('rfq.vendor_form',compact('pidnew'));
    }

    public function VendorRFQFormDataStore(Request $request){
    		$count = count($request->item_name);	
		  	if($count != 0){
		  	 	$x = 0;
		  	 	while($x < $count){
		  	 		if($request->item_name[$x] !=''){
						  $quotationItemsTable[] = array(
					 				'item_name' => $request->item_name[$x]."|".$request->item_no[$x],
			            'item_quantity' => $request->item_quantity[$x],
			            'item_price' => $request->item_price[$x],
			            'item_actual_amount' => $request->item_actual_amount[$x],
			            'item_tax1_rate' => $request->item_tax1_rate[$x],
			            'item_tax1_amount' => $request->item_tax1_amount[$x],
			            'item_total_amount' => $request->item_total_amount[$x]
					 		);
					 		$data = array(
					 			'items' => json_encode($quotationItemsTable), 
					 			'quotion_id' => $request->quotion_id,
					 			'quotion_sends_id' => $request->quotion_sends_id,
					 			'vender_id' => $request->vender_id,
					 			'terms' => $request->terms,
					 			'rfi_id' => $request->rfi_id,
					 		);
						}			  
		  	 		$x++;
		  	 	}
		  	 	QuotationReceived::create($data);
		  	 	$data1 = array(
			 			'quotation_id' => $request->quotion_id,
			 			'quote_id' => $request->quotion_sends_id,
			 			'vendor_id' => $request->vender_id,
			 			'rfi_id' => $request->rfi_id
			 		);
			    QuotationApprovals::create($data1);
		  	}
    		return back()->with('success','Thank You for quotation, we will get back to you soon');
    }

    public function QuotationApproval(Request $request){
    		$manager_status = $request->manager_status;
    		$id = $request->quotion_id;
    		$arr = array(
    				'quotation_approval_id' => $id
    		);
    		QuotationApprovedById::create($arr);
    		QuotationApprovals::where('id', $id)->update(['manager_status'=> $manager_status]);
    }

    public function QuotationReceivedAtLevelOne(){
    		$data = DB::table('prch_quotation_approvals')
            ->join('prch_vendors', 'prch_quotation_approvals.vendor_id', '=', 'prch_vendors.id')
            ->join('prch_vendors_mail_sends', 'prch_quotation_approvals.quote_id', '=', 'prch_vendors_mail_sends.id')
            ->select('prch_quotation_approvals.*', 'prch_vendors.*', 'prch_vendors_mail_sends.*')
            ->where('prch_quotation_approvals.manager_status', '=', 1)->get();

    		return view('rfq.quotationReceived_levelone',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function QuotationApprovalByLevelOne($id){
    		$vendor = QuotationApprovals::with('QuotationReceived.vendorsDetail')->where('rfi_id',$id)->get();
    		return view('rfq.qa_level_one',compact('data','vendor','manager_approved'));
    }

    public function QuotationApprovalByL1(Request $request){
    		$level1_status = $request->level1_status;
    		$id = $request->ApprovalId;
    		QuotationApprovals::where('id', $id)->update(['level1_status'=> $level1_status]);
    }


    public function QuotationReceivedAtLevelTwo(){
    		$data = DB::table('prch_quotation_approvals')
            ->join('prch_vendors', 'prch_quotation_approvals.vendor_id', '=', 'prch_vendors.id')
            ->join('prch_vendors_mail_sends', 'prch_quotation_approvals.quote_id', '=', 'prch_vendors_mail_sends.id')
            ->select('prch_quotation_approvals.*', 'prch_vendors.*', 'prch_vendors_mail_sends.*')
            ->where('prch_quotation_approvals.manager_status', '=', 1)->where('prch_quotation_approvals.level1_status', '=', 1)->get();
            
        return view('rfq.quotationReceived_leveltwo',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function QuotationApprovalByLevelTwo($id){
    		$vendor = QuotationApprovals::with('QuotationReceived.vendorsDetail')->where('rfi_id',$id)->get();

    		return view('rfq.qa_level_two',compact('data','vendor','manager_approved'));
    }

    public function QuotationApprovalByL2(Request $request){
    		$level2_status = $request->level2_status;
    		$id = $request->ApprovalId;
    		QuotationApprovals::where('id', $id)->update(['level2_status'=> $level2_status]);
    }

    public function ApprovalQuotation(){
    		$data = QuotationApprovals::with('QuotationReceived.vendorsDetail')
        				->where('manager_status',1)
        				->where('level1_status',1)
        				->where('level2_status',1)
        				->get();

        return view('rfq.approval_quotation',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function ApprovalQuotationItems($id){
      //return $id;
    		$data = QuotationApprovals::with(['QuotationReceived.vendorsDetail','rfuser.address'])->where('id',$id)->get();
        //dd($data[0]);
    		return view('rfq.approvalQuotation_item',compact('data','vendor','manager_approved','vid'));
    }

    public function ApprovalQuotationItemSend(request $request,$id){
    		$tbl = $request->table;
    		$tbl1 = $request->terms;
    		$pdf = PDF::loadView('rfq.PO_mail_data', compact('tbl','tbl1'));
    		$pdf = $pdf->Output('', 'S');

    		$autoId = DB::select(DB::raw("SELECT nextval('prch_po_send_to_vendors_id_seq')"));
				$nextval = $autoId[0]->nextval+1;
				//$nextval = Helper::getRFQSendMailAutoIncrementId();
  			$data = array(
  					'vendor_id'		=>	$id,
  					'approval_quotation_id' => $request->approval_quotation_id, 
  					'po_id'	=>	'#PO'.str_pad($nextval, 4, '0', STR_PAD_LEFT),
  			);
        // dd($data); avhi
  			$datas = PO_SendToVendors::create($data);
  			$vendor = vendor::find($id);
  			$details = array(
  				'table' => $request->table,
  				'pdf' => $pdf,
  				'vendor_data' => $vendor,
  				'po_id' => $nextval,
  			);
  			\Mail::to($vendor->email)->send(new PO_SandsToVendor($details));

  			return redirect()->route('approval_quotation')->with('success','Purchase Order and Mail sends successfully');
    }
}
