@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/approval_quotation' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Send PO</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('success'))
		            <div class="alert alert-success">
		                <p>{{ $message }}</p>
		            </div>
		        @endif
						<?php //dd($data); die; ?>
            <form action="{{ route('approvalQuotation_item_send', $data[0]->QuotationReceived->vender_id) }}" method="post">
                @csrf
                <div class="row">
                	<div class="form-group col-md-12">
                		<input type="hidden" name="approval_quotation_id" value="{{ request()->segment(2) }}">
                		<button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4 float-right">Submit</button>
                	</div>
                </div>
                <?php  
								$table ='
								<table width="100%" cellpadding="5" style="color:#000;background: #9cadde;border:1px solid #000">
						      <tr class="vendorsDetail">
						        <td width="65%">
						         Vendor Firm : '.$data[0]->QuotationReceived->vendorsDetail->firm_name.' <br /> 
						         Vendor Name : '.$data[0]->QuotationReceived->vendorsDetail->name.' <br />
						         Email Address : '.$data[0]->QuotationReceived->vendorsDetail->email.' <br />
						        </td>
						        <td width="35%">
						         Register No. : '.$data[0]->QuotationReceived->vendorsDetail->register_number.' <br />
						         GST No. : '.$data[0]->QuotationReceived->vendorsDetail->gst_number.' <br />
						         Contact No. : '.$data[0]->QuotationReceived->vendorsDetail->mobile.' <br />
						        </td>
						      </tr>
						    </table>
								<table width="100%" border="1" cellpadding="5" cellspacing="0" style="color:#000">
								    <tr>
								     	<td colspan="2" align="center" style="font-size:18px"><b>Purchase Order Quotation</b></td>
								    </tr>
								    <tr>
									    <td colspan="2">
										    <table width="100%" cellpadding="5" style="color:#000">
										      <tr>
										        <td width="65%">
										         From,<br />
										         <b></b><br />
										         Name : Laxyo Energy Ltd. <br /> 
										         Email Address : info@laxyo.com<br />
										         Contact No. : 0731-4043798 <br />
										        </td>
										        <td width="35%">
										         Register No. : 0123456789 <br />
										         GST No. : lax1234<br />
										         Date : '.date("d-m-Y H:i:s").'<br />
										        </td>
										      </tr>
										    </table>
										    <br />
										    <table class="table table-bordered" style="color:#000">
										    	<thead>
											      <tr>
											        <th>Sr No.</th>
											        <th>Item Name</th>
											        <th>Quantity</th>
											        <th>Price</th>
											        <th>Actual Amt.</th>
											        <th colspan="2">Tax</th>
											        <th rowspan="2">Total</th>
											      </tr>
											      <tr>
											        <th></th>
											        <th></th>
											        <th></th>
											        <th></th>
											        <th></th>
											        <th>Rate (%)</th>
											        <th>Amt.</th>
											      </tr>
											    </thead>
											    <tbody>';
                							$m = 0;
                							$sum_item_actual_amount = 0;
        											$item_tax_amount = 0;
        											$totalAmount = 0;
        											$datas = json_decode($data[0]->QuotationReceived->items);
                							foreach($datas as $value){
											        		$m = $m + 1;
											        		$sum_item_actual_amount += $value->item_actual_amount;
        													$item_tax_amount += $value->item_tax1_amount;
        													$totalAmount += $value->item_total_amount;
        													$ttl_amt = (!empty($value->item_tax1_rate)) ? $value->item_tax1_rate : 0;
										    $table .='<tr>
													    <td>'.$m.'</td>
													    <td>'.$value->item_name.'</td>
													    <td>'.$value->item_quantity.'</td>
													    <td>Rs. '.$value->item_price.'</td>
													    <td>Rs. '.$value->item_actual_amount.'</td>
													    <td>'.$ttl_amt.'%</td>
													    <td>Rs. '.$value->item_tax1_amount.'</td>
													    <td>Rs. '.$value->item_total_amount.'</td>
													  </tr>';
														} 
												$table .='
														<tr>
													   <td align="right" colspan="7"><b>Total</b></td>
													   <td align="right"><b>Rs. '.$totalAmount.'</b></td>
													  </tr>
													  <tr>
													   <td colspan="7"><b>Total Amt. Before Tax :</b></td>
													   <td align="right">Rs. '.$sum_item_actual_amount.'</td>
													  </tr>
													  <tr>
													   <td colspan="7"><b>Total Tax Amt.  :</b></td>
													   <td align="right">Rs. '.$item_tax_amount.'</td>
													  </tr>
													  <tr>
													   <td colspan="7"><b>Total Amt. After Tax :</b></td>
													   <td align="right"><b>Rs. '.$totalAmount.'</b></td>
													  </tr>
													</tbody>
												</table>
											</td>
									  </tr>
								</table>
								';

								echo $table;
								?>
								<table border="1" width="100%" style="color:#000!important">
									<tbody>
										<tr>
											<td>
												<strong>Terms and Conditions: </strong>
												<textarea id="editor" name="terms" class="form-control input-sm"></textarea>
											</td>
										</tr>
									</tbody>
								</table>
								<textarea name="table" class="form-control" style="display: none"><?php echo $table; ?></textarea>
						</form>
        </div>
    </div>
</div>

<style type="text/css">
	.vendorsDetail > td{
			padding: 20px !important;
	}
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
        console.error( error );
    });
</script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var last_valid_selection = null;
  $('#userRequest_activity').change(function(event) {
    if ($(this).val().length > 5) {
			alert('only 5 vendors are selected at a time');
      $(this).val(last_valid_selection);
    } else {
      last_valid_selection = $(this).val();
    }
  });
});
</script>