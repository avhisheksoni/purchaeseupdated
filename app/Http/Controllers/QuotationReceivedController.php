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
use App\PO_SendToVendors;
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
    		//$rfq = VendorsMailSend::latest()->paginate(10);
    		$rfq = DB::table('vendors_mail_sends')->distinct(['quotion_sent_id'])->paginate(10);
    		$data = QuotationApprovals::with('vendors_mail_items')->orderBy('id','desc')->get();
    		if($rfq != ''){
	    		$vid = json_decode($rfq[0]->email);
	    		$vendor = array();
	    		foreach ($vid as $key) {
	    				$vendor[] = vendor::where('id',$key)->get();
	    		}
	    	}
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
    		$requested = VendorsMailSend::Where('id',$id)->get();
    		$vid = json_decode($requested[0]->email);
    		foreach ($vid as $key) {
    				$vendor[] = vendor::where('id',$key)->get();
        }
        return view('rfq.show',compact('requested','vendor'));
    }

    public function ReceivedQuotation($id){
    		$data = QuotationReceived::where('quotion_sends_id',$id)->get();
    		foreach ($data as $key) {
    			$vid[] = $key->vender_id;
    		}
    		$vndr = array_unique($vid);
    		foreach ($vndr as $val) {
    			$vendor[] = vendor::where('id',$val)->get();
    		} 
				return view('rfq.receivedQuotation',compact('data','vendor'));
    }

    public function VendorRFQFormData($id, $vid){
    		return view('rfq.vendor_form');
    }

    public function VendorRFQFormDataStore(Request $request){
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
			            'item_total_amount' => $request->item_total_amount[$x]
					 		);
					 		$data = array(
					 			'items' => json_encode($quotationItemsTable), 
					 			'quotion_id' => $request->quotion_id,
					 			'quotion_sends_id' => $request->quotion_sends_id,
					 			'vender_id' => $request->vender_id,
					 			'terms' => $request->terms
					 		);
					 		//dd($data);
			        QuotationReceived::create($data);
						}			  
		  	 		$x++;
		  	 	}
		  	 	$data1 = array(
			 			'quotation_id' => $request->quotion_id,
			 			'quote_id' => $request->quotion_sends_id,
			 			'vendor_id' => $request->vender_id
			 		);
			    QuotationApprovals::create($data1);
		  	}
    		return back()->with('success','Thank You for quotation, we will get back to you soon');
    }

    public function QuotationApproval(Request $request){
    		$manager_status = $request->manager_status;
    		$id = $request->quotion_id;
    		QuotationApprovals::where('id', $id)->update(['manager_status'=> $manager_status]);
    }

    public function QuotationReceivedAtLevelOne(){
    		$data = DB::table('quotation_approvals')
            ->join('vendors', 'quotation_approvals.vendor_id', '=', 'vendors.id')
            ->join('vendors_mail_sends', 'quotation_approvals.quote_id', '=', 'vendors_mail_sends.id')
            ->select('quotation_approvals.*', 'vendors.*', 'vendors_mail_sends.*')
            ->where('quotation_approvals.manager_status', '=', 1)->get();
    		return view('rfq.quotationReceived_levelone',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function QuotationApprovalByLevelOne($id){
    		$data = QuotationReceived::where('quotion_sends_id',$id)->get();
    		foreach ($data as $key) {
    			$vid[] = $key->vender_id;
    		}
    		$vndr = array_unique($vid);
    		foreach ($vndr as $val) {
    			$vendor[] = vendor::where('id',$val)->get();
    		}
    		return view('rfq.qa_level_one',compact('data','vendor','manager_approved'));
    }

    public function QuotationApprovalByL1(Request $request){
    		$level1_status = $request->level1_status;
    		$id = $request->ApprovalId;
    		QuotationApprovals::where('id', $id)->update(['level1_status'=> $level1_status]);
    }


    public function QuotationReceivedAtLevelTwo(){
    		/*$manager_approved = QuotationApprovals::where('manager_status','1')->where('level1_status','1')->get();
    		foreach ($manager_approved as $value) {
    			$quotation_id = $value->quote_id;
    			$v_id = $value->vendor_id;
    			$rfq[] = VendorsMailSend::where('id',$quotation_id)->get();
	    		$vendor[] = vendor::where('id',$v_id)->get();
    		} 
    		return view('rfq.quotationReceived_leveltwo',compact('rfq','vendor','manager_approved'))->with('i', (request()->input('page', 1) - 1) * 10);*/

    		$data = DB::table('quotation_approvals')
            ->join('vendors', 'quotation_approvals.vendor_id', '=', 'vendors.id')
            ->join('vendors_mail_sends', 'quotation_approvals.quote_id', '=', 'vendors_mail_sends.id')
            ->select('quotation_approvals.*', 'vendors.*', 'vendors_mail_sends.*')
            ->where('quotation_approvals.manager_status', '=', 1)->where('quotation_approvals.level1_status', '=', 1)->get();
        return view('rfq.quotationReceived_leveltwo',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function QuotationApprovalByLevelTwo($id){
    		$data = QuotationReceived::where('quotion_sends_id',$id)->get();
    		foreach ($data as $key) {
    			$vid[] = $key->vender_id;
    		}
    		$vndr = array_unique($vid);
    		foreach ($vndr as $val) {
    			$vendor[] = vendor::where('id',$val)->get();
    		}
    		return view('rfq.qa_level_two',compact('data','vendor','manager_approved'));
    }

    public function QuotationApprovalByL2(Request $request){
    		$level2_status = $request->level2_status;
    		$id = $request->ApprovalId;
    		QuotationApprovals::where('id', $id)->update(['level2_status'=> $level2_status]);
    		
    		/*$data = array(
  					'vendor_id'		=>	$id,
  					'approval_quotation_id' => $request->approval_quotation_id, 
  					'po_id'	=>	'#PO'.str_pad($nextval, 4, '0', STR_PAD_LEFT),
  			);
  			$datas = PO_SendToVendors::create($data);*/
    }

    public function ApprovalQuotation(){
    		$data = DB::table('quotation_approvals')
            ->join('vendors', 'quotation_approvals.vendor_id', '=', 'vendors.id')
            ->join('vendors_mail_sends', 'quotation_approvals.quote_id', '=', 'vendors_mail_sends.id')
            ->orderBy('quotation_approvals.created_at', 'desc')
            ->select('quotation_approvals.*', 'vendors.*', 'vendors_mail_sends.*')
            ->where('quotation_approvals.manager_status', '=', 1)->where('quotation_approvals.level1_status', '=', 1)->where('quotation_approvals.level2_status', '=', 1)->paginate(10);
        return view('rfq.approval_quotation',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function ApprovalQuotationItems($id){
    		$approvedData = DB::table('quotation_approvals')
            ->join('vendors', 'quotation_approvals.vendor_id', '=', 'vendors.id')
            ->join('vendors_mail_sends', 'quotation_approvals.quote_id', '=', 'vendors_mail_sends.id')
            ->orderBy('quotation_approvals.created_at', 'desc')
            ->select('quotation_approvals.*', 'vendors.*', 'vendors_mail_sends.*')
            ->where('quotation_approvals.manager_status', '=', 1)->where('quotation_approvals.level1_status', '=', 1)->where('quotation_approvals.level2_status', '=', 1)->where('quotation_approvals.quote_id', '=', $id)->paginate(10);
        foreach ($approvedData as $key) {
    			$quote_id = $key->quote_id;
    			$vid = $key->vendor_id;
    			$data = QuotationReceived::where('quotion_sends_id',$quote_id)->where('vender_id',$vid)->get();
    		}
    		// $data = QuotationReceived::where('quotion_sends_id',$id)->get();
    		// foreach ($data as $key) {
    		// 	$vid[] = $key->vender_id;
    		// }
    		// $vndr = array_unique($vid);
    		// foreach ($vndr as $val) {
    		// 	$vendor[] = vendor::where('id',$val)->get();
    		// }
    		return view('rfq.approvalQuotation_item',compact('data','vendor','manager_approved','vid'));
    }

    public function ApprovalQuotationItemSend(request $request,$id){
    		$tbl = $request->table;
    		$tbl1 = $request->terms;
    		$pdf = PDF::loadView('rfq.PO_mail_data', compact('tbl','tbl1'));
    		$pdf = $pdf->Output('', 'S');

    		$autoId = DB::select(DB::raw("SELECT nextval('po_send_to_vendors_id_seq')"));
				$nextval = $autoId[0]->nextval+1;
				//$nextval = Helper::getRFQSendMailAutoIncrementId();
  			$data = array(
  					'vendor_id'		=>	$id,
  					'approval_quotation_id' => $request->approval_quotation_id, 
  					'po_id'	=>	'#PO'.str_pad($nextval, 4, '0', STR_PAD_LEFT),
  			);
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
