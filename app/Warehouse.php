<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $guarded = [];
    protected $table = 'prch_warehouses';

    public function warehouse(){
    	return $this->belongsTo('App\Model\store_inventory', 'warehouse_id', 'id');
    }
}
