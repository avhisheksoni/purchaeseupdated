<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivingsRequestItem extends Model
{

    protected $guarded = [];
    protected $table = 'acco_receiving_request_items';

   
   public function itemname(){
    	return $this->belongsTo('App\item', 'item_key');
    }
    
   
}
