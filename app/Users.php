<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    protected $table = 'users';
    protected $guarded = [];

   /*public function receiving_items(){
   	return $this->hasMany('App\ReceivingsItem', 'receiving_id');
   }*/

}
