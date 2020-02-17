<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Validator;
use Auth;

class RoleController extends Controller
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
        $role = Role::orderBy('id','DESC')->paginate(10);
        return view('role',compact('role'))->with('i', (request()->input('page', 1) - 1) * 10);
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
            'name' => 'required|unique:roles,name',
        ]);
        if ($validation->fails())
        {
            return "Role Name has already taken";
        }
        else
        { 
        	$type = explode(" ",$request->input('name'));
        	$name = strtolower(implode('_',$type));
	        $role = Role::create(['name' => $name, 'display_name' => $request->input('name'), 'description' => ""]);
	        return 'Role Created';
	      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    		$validation = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id,
            //'permission' => 'required',
        ]);
        if ($validation->fails())
        {
            return "Role Name has already taken";
        }
        else
        { 
        	$type = explode(" ",$request->input('name'));
	        $name = strtolower(implode('_',$type));
	        $role = Role::find($id);
	        $role->name = $name;
	        $role->display_name = $request->input('name');
	        $role->save();
	        //$role->syncPermissions($request->input('permission'));
	        return "Role Updated";
	      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect()->route('role.index')->with('success','Category deleted successfully');
    }
}
