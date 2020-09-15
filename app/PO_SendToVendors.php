<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PO_SendToVendors extends Model
{
    protected $guarded = [];
    protected $table = 'prch_po_send_to_vendors';

    public function approval_status(){
    		return $this->belongsTo("App\QuotationApprovals", "quote_id", "approval_quotation_id");
    }
}
