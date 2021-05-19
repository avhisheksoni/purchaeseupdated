<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class acco_users extends Model
{
    use SoftDeletes;
    protected $table= 'acco_users';
    protected $guarded = [];
    public $timestamps = true;

    public function user_name()
    {
    	return $this->belongsTo('App\Users', 'id');
    }

    public function site(){
    	return $this->belongsTo('App\job_master', 'site_id');
    }
}
