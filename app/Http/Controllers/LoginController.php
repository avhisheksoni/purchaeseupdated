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
	public function login($username,$pass){
		$data = User::where('email',$username)->first();	
		if($username !='' && $pass !=''){
			//dd($data);	
			if($data->log_status == true && $data->enc_password == $pass){
	      if (Auth::attempt(['email' => $username, 'password' =>$data->other_pass])) {
		       $user = Auth::user();
		      return redirect()->route('home');
		    }else {
		       return response()->json(['error' => 'Unauthorised'], 401);
		    }
		  }
		  else{
		  	return redirect('http://laxyo.org/login');
		  }
		}
		else{
			return response()->json(['error' => 'Unauthorised'], 401);
		}

  }

    public function logout(Request $request){
    	Auth::logout();
    	Session::flush();
  		return redirect('http://laxyo.org/login');
    }
}