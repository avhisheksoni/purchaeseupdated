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
    		$data = DB::table('po_send_to_vendors')
            ->join('vendors', 'po_send_to_vendors.vendor_id', '=', 'vendors.id')
            ->orderBy('po_send_to_vendors.created_at', 'desc')
            ->select('po_send_to_vendors.*', 'vendors.*')
            ->where('po_send_to_vendors.po_accept_status', '=', '1')->paginate(10);
        return view("store_management.index",compact("data"))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function ViewAcceptedPO($id){
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
    			$PO_no = PO_SendToVendors::where('approval_quotation_id',$quote_id)->get();
    		}
    		return view("store_management.view_accepted_po", compact('data','PO_no'));
    }

    // Fetch GRN for store manager
    public function FetchAllGRN(){
    		$data = '';
    		return view("store_management.view_grn");
    }
}
