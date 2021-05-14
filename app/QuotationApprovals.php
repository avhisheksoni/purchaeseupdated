<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationApprovals extends Model
{
    protected $guarded = [];
    protected $table = 'prch_quotation_approvals';

    /*public function vendors_details(){
    		return $this->belongsTo('App\vendor', 'vendor_id', 'id');
    }*/
    public function vendors_mail_items(){
    		return $this->belongsTo('App\VendorsMailSend', 'quote_id', 'id');
    }

    public function QuotationReceived(){
    		return $this->belongsTo('App\QuotationReceived', 'quote_id', 'quotion_sends_id');
    }

    public function rfi_status(){
        return $this->belongsTo("App\PO_SendToVendors", "rfi_id", "approval_quotation_id");
    }
    public function rfuser(){
        return $this->belongsTo("App\RfiUsers", "rfi_id", "id");
    }
    public function prchitemres(){
        return $this->belongsTo("App\prch_itemwise_requs", "rfi_id", "prch_rfi_users_id");
    }

    // public function wareous(){
    //     return $this->hasOneThrough("App\Warehouse", "App\QuotationApprovals",'rfi_id','address_wareh_id','id','id');
    // }
}
