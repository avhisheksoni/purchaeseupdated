<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//RequestForItemSingle
class RfiUsers extends Model
{
    protected $guarded = [];
    protected $table = 'prch_rfi_users';

    public function discardReason(){
    	return $this->belongsTo('App\RfiDiscardReason', 'id', 'rfi_id');
    }

    public function address(){
        return $this->belongsTo("App\Warehouse", "address_wareh_id", "id");
    }
}
