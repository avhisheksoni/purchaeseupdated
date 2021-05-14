<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itemconsumable extends Model
{
   protected $table= 'prch_item_consumable';
    protected $guarded = [];
    public $timestamps = true;
}
