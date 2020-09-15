<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item_category extends Model
{
    /*protected $fillable = [
        'name', 'description'
    ];*/
    protected $guarded = [];
    protected $table = 'prch_item_categories';
}
