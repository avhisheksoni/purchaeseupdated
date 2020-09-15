<?php

namespace App\Http\Controllers;

use App\StoreManagement;
use App\PO_SendToVendors;
use App\vendor;
use App\QuotationReceived;
use App\QuotationApprovals;
use DB;
use Illuminate\Http\Request;

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

        $data = QuotationApprovals::with('vendors_mail_items','QuotationReceived.vendorsDetail','rfi_status')
                        ->where('rfi_id', '=', $id)->paginate(10);
        return view("store_management.view_accepted_po", compact('data'));
    }

    // Fetch GRN for store manager
    public function FetchAllGRN(){
    		$data = '';
    		return view("store_management.view_grn");
    }
}
