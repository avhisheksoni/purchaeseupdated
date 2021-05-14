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

class ManagetransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $recreq =  ReceivingsRequest::all();
        return view('receivings.manage_transfer',compact('recreq'));
    }


    public function sitereq($id){
        $recrq = ReceivingsRequestItem::where('receiving_request_id',$id)->get();
        return view('receivings.requested_items',compact('recrq'));
    }

    
}
