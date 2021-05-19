<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class acco_users extends Model
{
    protected $table= 'acco_users';
    protected $guarded = [];
    public $timestamps = true;

    public function user_name()
    {
    	return $this->hasOne('App\Users', 'id');
    }

    public function site(){
    	return $this->belongsTo('App\job_master', 'site_id');
    }
}
