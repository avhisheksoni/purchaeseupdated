<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseWarehouse extends Model
{
   //use SoftDeletes;
    protected $table	= 'prch_warehouses';
    protected $guarded 	= [];
    //public $timestamps 	= true;

    
}
