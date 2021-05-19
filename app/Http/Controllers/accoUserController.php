<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\item;
use App\Users;
use App\sites;
use Carbon\Carbon;
use App\Warehouse;
use App\acco_users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\store_inventory\StoreItem;
use Illuminate\Support\Facades\Validator;

class accoUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acc_user = acco_users::with('user_name', 'site')->get();

        $users = [];
        $sites = [];
        foreach($acc_user as $user){
            $users[] = $user->user_id;
            $sites[] = $user->site_id;
        }

        $sites = sites::whereNotIn('id', $sites)->get();
        $users = Users::whereNotIn('id', $users)->get();
        //dd($acc_user);
        //return view('users.index');
        return view('users.index',compact('sites', 'users', 'acc_user', 'site'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAdd(Request $request)
    {
        //dd($request->all());
        $data = new acco_users;
        $data->user_id = $request->input('user');
        $data->site_id = $request->input('site');
        $data->short_name = $request->input('short_name');
        $data->comment = $request->input('comment');
        $data->save ();
        return redirect()->route('users');
    }

    
    public function destroy($id)
    {
        Warehouse::find($id)->delete();
        return redirect()->route('warehouse.index')->with('success','Category deleted successfully');
    }
}
