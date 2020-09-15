<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class MemberController extends Controller
{
		public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {		
        //$member = Member::latest()->paginate(10);
        $member = Member::with(['assign_role'])->paginate(10);
        $role = Role::where('id', '!=', 2)->get();
        return view('members',compact('member','role'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users|unique:members|regex:/(.*)@laxyo\.in/i',
            'phone' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);
  			if ($validation->fails())
        {
            return json_encode($validation->errors()); 
            //'input fields must be required or email must me unique';
        }
        else
        {
	  			$userTable = [
	            'name' => $request->first_name.' '.$request->last_name,
	            'email' => $request->email,
	            'password' => Hash::make($request->password)
	        ];
	        $user = User::create($userTable);
	        //$user->assignRole($request->input('role_id'));
	        $user->attachRole($request->input('role_id'));
	        $LastInsertId = $user->id;
	        if(!empty($LastInsertId)){
			        $MemberTable = [
			            'emp_name' => $request->first_name.' '.$request->last_name,
			            'email' => $request->email,
			            'contact' => $request->phone,
			            'user_id' => $LastInsertId,
			            'role_id' => $request->role_id,
			        ];
			        Member::create($MemberTable);
			    }
			    return 'success';
	      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|regex:/(.*)@laxyo\.in/i',
            'phone' => 'required',
            'role_id' => 'required',
            'status' => 'required'
        ]);

        if ($validation->fails())
        {
            return json_encode($validation->errors());
        }
        else
        {
        	date_default_timezone_set('Asia/Calcutta');
					$date = date('Y-m-d H:i:s');
					if($request->status == 1)
					{
						$userTable = [
		            'name' => $request->first_name.' '.$request->last_name,
		            'email' => $request->email,
		            'deleted_at' => $date,
		        ];
		      }else{
		      	$userTable = [
		            'name' => $request->first_name.' '.$request->last_name,
		            'email' => $request->email,
		            'deleted_at' => null,
		        ];
		      }
	  			//print_r($userTable); die;
	  			$user = User::find($request->user_id);
	        $user->update($userTable);
	  			DB::table('role_user')->where('user_id',$request->user_id)->delete();
	  			$user->attachRole($request->input('role_id'));
	        $member->update($request->all());
	        
	        return 'success';
	      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
