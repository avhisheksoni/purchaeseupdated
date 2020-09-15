<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationReceived extends Model
{
    protected $guarded = [];
    protected $table = 'prch_quotation_receiveds';

    public function vendorsDetail(){
    	return $this->hasOne('App\vendor', 'id', 'vender_id');
    }
}
