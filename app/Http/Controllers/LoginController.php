<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use Auth;
use Config;
use Illuminate\Support\Facades\Crypt;
use Session;

class LoginController extends Controller
{
	public function login($username){
		$data = User::where('email',$username)->first();
        if (Auth::attempt(['email' => $username, 'password' =>$data->other_pass])) {
	       $user = Auth::user();
	      return redirect()->route('home');
	    }else {
	       return response()->json(['error' => 'Unauthorised'], 401);
	    }
    }

    public function logout(Request $request){
    	$guard =null;
    	// Auth::guard($guard)->logout();
    	Session::flush();
  		return redirect('http://laxyo.org/login');
    }
}