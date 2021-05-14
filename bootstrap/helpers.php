<?php 
use App\prch_itemwise_requs;
if(!function_exists('dispacthcount')){
	function dispacthcount($id){
		return prch_itemwise_requs::where('prch_rfi_users_id',$id)->count();
		
	}
}

?>