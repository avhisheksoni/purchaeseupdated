<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    		/*$data = User::find(Auth::id());
    		if($data->hasRole('level_2')){
    			return "teur";
    		}
    		else{
    			return "skdfgjsdhbf";
    		}*/
        return view('home');
    }
}
