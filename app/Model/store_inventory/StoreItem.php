<?php

namespace App\Model\store_inventory;

use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    protected $guarded = [];
    protected $table = 'prch_store_item';

    /*public function items_details(){
    	return $this->belongsTo('App\item', 'item_id', 'id');
    }*/

    public function store_warehouse(){
    	return $this->belongsTo('App\Warehouse', 'warehouse_id');
    }
}
