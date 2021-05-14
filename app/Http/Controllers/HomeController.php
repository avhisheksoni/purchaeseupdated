<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Member;
use Auth;
use Session;
use App\EmpMast;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$data = User::find(Auth::id());
        // return $data;
		$user_id = $data->id;
		foreach($data->roles as $datas){
			if($datas->name =='purchase_superadmin' || $datas->name =='purchase_admin' || $datas->name =='purchase_manager' || $datas->name =='purchase_user')
			{
					$role_id = $datas->id;
					Member::where('user_id', $user_id)->update(['role_id'=> $role_id]);
			}
		}

        $user  = EmpMast::where('user_id', Auth::id())->first();
        // return $user;
        Session::put('avatar', $user->emp_avatar);

        return view('home');      
    }
    public function check()
    {
        if (Auth::check()) {
          return redirect('http://purchase.laxyo.org/home');
        }
        else{
            return redirect('http://laxyo.org/login');
        }
   	
        return view('home');

    }
}