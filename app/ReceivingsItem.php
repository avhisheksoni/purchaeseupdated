<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivingsItem extends Model
{

    protected $guarded = [];
    protected $table = 'acco_receiving_item';

    public function item(){
   	return $this->belongsTo('App\item', 'item_id');
   }
}
