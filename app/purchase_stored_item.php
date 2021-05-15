<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_stored_item extends Model
{
    protected $guarded = [];
    protected $table = 'prch_store_item';


    public function itemdetails(){
   	return $this->belongsTo('App\item', 'item_id');
   }

   public function warehouse(){
   	return $this->belongsTo('App\Warehouse', 'warehouse_id');
   }
}
