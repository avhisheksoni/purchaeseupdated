<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\unitofmeasurement;
use App\Member;
use App\RfiUsers;
use App\RfiManager;
use App\RfiDiscardReason;
use App\prch_itemwise_requs;

class LevelOne extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ManagerApproval()
    {
    		$requested = RfiUsers::where('requested_role','Manager')->latest()->paginate(10);
    		$managerApproval = RfiUsers::where('requested_role','Users')->where('manager_status','1')->latest()->paginate(10);
    		return view('level_one.manager_approval', compact('requested','managerApproval'))->with('i', (request()->input('page', 1) - 1) * 10);
	  }

	  public function LevelOneApproval($id){
	  		$data = RfiUsers::with('discardReason')->where('id',$id)->get();
            $quo = prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'ready_to_dispatch'=>0,'dispatch_status' =>0])->get();
	  		 $role = $data[0]->requested_role;
            $unit = unitofmeasurement::get();
	  		if($role == 'Manager'){
	  			$status = 0;
	  		}else{
	  			$status = 1;
	  		}
	  		$requested = RfiUsers::where('id',$id)->where('requested_role',$role)->where('manager_status',$status)->get();
	  		return view('level_one.edit_levelone_approval',compact('requested','unit','quo'));
	  }

	  public function UpdateLevelOneApproval(Request $request, $id){
        //return $id;
	  		$request->validate([
            'status' => 'required'
        ]);
        $status = $request->status;
        if($status == 2){
            $request->validate([
                'discardReason' => 'required'
            ]);
            $reason = array(
                'rfi_id'   =>  $id,
                'level1_discard'  =>  $request->discardReason,
            );
            RfiDiscardReason::create($reason);
        }
        RfiUsers::where('id',$id)->update(['level1_status'=> $status]);
        prch_itemwise_requs::where(['prch_rfi_users_id'=>$id,'ready_to_dispatch'=>3])->update(['level1_status'=> $status]);
        return redirect()->route('manager_approval')->with('success','Your status has been updated');
	  }
}
