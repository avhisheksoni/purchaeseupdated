<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class item_quantity_hsty extends Model
{
   use SoftDeletes;
    protected $table= 'acco_item_qty_history';
    protected $guarded = [];
    public $timestamps = true;
}
