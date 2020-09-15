<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RfiUsers;
use App\RfiDiscardReason;
use App\unitofmeasurement;

class LevelTwo extends Controller
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

    public function LevelTwoApproval()
    {
    		$requested = RfiUsers::where('level1_status','1')->latest()->paginate(10);
    		return view('level_two.items_approval', compact('requested'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function EditLevelTwoApproval($id)
    {
	  		$data = RfiUsers::with('discardReason')->where('id',$id)->get();
	  		$role = $data[0]->requested_role;
            $unit = unitofmeasurement::get();
	  		if($role == 'Manager'){
	  			$status = 0;
	  		}else{
	  			$status = 1;
	  		}
	  		$requested = RfiUsers::where('id',$id)->where('requested_role',$role)->where('manager_status',$status)->get();
	  		return view('level_two.edit_leveltwo_approval',compact('requested','unit'));
	}

	public function UpdateLevelTwoApproval(Request $request, $id) 
	{
	  	$request->validate([
            'status' => 'required'
        ]);
        $status = $request->status;
        //dd($status);
        if($status == 2){
            $request->validate([
                'discardReason' => 'required'
            ]);
            $reason = array(
                'rfi_id'   =>  $id,
                'level2_discard'  =>  $request->discardReason,
            );
            RfiDiscardReason::create($reason);
        }
        RfiUsers::where('id',$id)->update(['level2_status'=> $status]);
        return redirect()->route('items_approval')->with('success','Your status has been updated');
	}
}
