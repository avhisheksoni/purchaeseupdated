<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    /*protected $fillable = [
        'name', 'description'
    ];*/
    protected $guarded = [];
    protected $table = 'prch_locations';
}
