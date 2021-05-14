<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class prch_itemwise_requs extends Model
{
	use SoftDeletes;
    protected $table= 'prch_req_itemwise';
    protected $guarded = [];
    public $timestamps = true;
}
