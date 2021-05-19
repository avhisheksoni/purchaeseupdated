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

class chalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
      
    }

    public function show($id)
    {
      
      $rec_chalan = Receivings::with(['warehouse', 'site'])->where('id', $id)->first();
      $chalan_item = ReceivingsItem::with('item')->where('receiving_id', $id)->get();
      //dd([$chalan_item,$rec_chalan]);
      return view('receivings.chalan', compact('rec_chalan', 'chalan_item'));
    }

    public function back(){

      return redirect()->route('receiving');
    }
}
