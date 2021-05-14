<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivingsRequest extends Model
{

    protected $guarded = [];
    protected $table = 'acco_receiving_request';


    public function req_items()
    {
        return $this->hasMany('App\ReceivingsRequestItem','receiving_request_id');
    }

    public function sitename()
    {

    	return $this->belongsTo('App\sites','site_id');
    }

    public function warename()
    {

    	return $this->belongsTo('App\Warehouse','warehouse_id');
    }
}
