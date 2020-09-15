<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /*protected $fillable = [
      	'first_name', 'last_name', 'email', 'phone', 'user_id', 'role_id', 'status'
    ];*/
    protected $guarded = [];
    protected $table = 'emp_mast';

    public function assign_role(){
    	return $this->belongsTo('App\Role', 'role_id', 'id');
    } 
}
