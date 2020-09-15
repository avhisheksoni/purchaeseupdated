<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    /*protected $fillable = [
        'name', 'email', 'mobile', 'address', 'gst_number', 'alt_number', 'firm_name', 'register_number','item_id'
    ];*/
    protected $guarded = [];
    protected $table = 'prch_vendors';
}
