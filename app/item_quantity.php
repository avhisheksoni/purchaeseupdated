<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class item_quantity extends Model
{
    use SoftDeletes;
    protected $table= 'acco_item_quantity';
    protected $guarded = [];
    public $timestamps = true;
}
