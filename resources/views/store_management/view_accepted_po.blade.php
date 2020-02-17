@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/store_management' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Received Accepted PO</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('success'))
		            <div class="alert alert-success">
		                <p>{{ $message }}</p>
		            </div>
		        @endif
						<?php // dd($data); die; ?>
            <form action="" method="post">
                @csrf
                <?php  
								$table ='
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
										         PO No. : '.$PO_no[0]->po_id.' <br />
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
                							foreach($data as $rows){
											        	$value = json_decode($rows->items);
											        		$m = $m + 1;
											        		$sum_item_actual_amount += $value->item_actual_amount;
        													$item_tax_amount += $value->item_tax1_amount;
        													$totalAmount += $value->item_total_amount;
										    $table .='<tr>
													    <td>'.$m.'</td>
													    <td>'.$value->item_name.'</td>
													    <td>'.$value->item_quantity.'</td>
													    <td>Rs. '.$value->item_price.'</td>
													    <td>Rs. '.$value->item_actual_amount.'</td>
													    <td>'.$value->item_tax1_rate.'%</td>
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
						</form>
        </div>
    </div>
</div>

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