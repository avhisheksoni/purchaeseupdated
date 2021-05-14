<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class job_master extends Model
{
    use SoftDeletes;
     protected $table= 'acco_job_master';
    protected $guarded = [];
    public $timestamps = true;


     function jobname()
    {

    	return $this->hasmany('App\Expense','job_id','id');
    }

    function gst(){

    	return $this->belongsTo('App\tax_gst','tax_gst');
    }

    function tds(){

    	return $this->belongsTo('App\TaxTdsmodel','tax_tds');
    }

    function gstin(){

    	return $this->belongsTo('App\Gstin','e_commerece_gstin');
    }

     function company(){

        return $this->belongsTo('App\Company_mast','comp_id');
    }

    function client(){

        return $this->belongsTo('App\Client','client_id');
    }

    function job_cat(){

        return $this->belongsTo('App\job_categorgy','job_cat_id');
    }
}
