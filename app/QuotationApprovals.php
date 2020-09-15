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
}
