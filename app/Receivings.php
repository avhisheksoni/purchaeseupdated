<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receivings extends Model
{

    protected $table = 'acco_receivings';
    protected $guarded = [];

   /*public function receiving_items(){
   	return $this->hasMany('App\ReceivingsItem', 'receiving_id');
   }*/

   public function site(){
    	return $this->belongsTo('App\job_master', 'site_id');
    }

    public function warehouse(){
    	return $this->belongsTo('App\PurchaseWarehouse', 'warehouse_id');
    }
}
