@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/request_for_item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Update User RFI</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('success'))
		            <div class="alert alert-success">
		                <p>{{ $message }}</p>
		            </div>
		        @endif
						<?php //print_r($requested[0]->requested_data); die; ?>
            <form action="{{ route('rfiquotationtomail',$requested[0]->id) }}" method="post">
                @csrf
                <div class="row">
                	<div class="form-group col-md-12">
                		<button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4 float-right">Submit</button>
                	</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <select class="form-control" name="vendor_id[]" multiple="" id="userRequest_activity">
                        	<option disabled="">Select Vendors</option>
                        	@foreach($vendor as $vendors)
                        		<option value="{{ $vendors->id }}">{{ $vendors->firm_name }} | {{ $vendors->register_number }}</option>
                        	@endforeach
                        </select>
                    </div>
                </div>
                <?php  
					$table ='
					<table width="100%" border="1" cellpadding="5" cellspacing="0">
					    <tr>
					     	<td colspan="2" align="center" style="font-size:18px"><b>Request for Quotation</b></td>
					    </tr>
					    <tr>
						    <td colspan="2">
							    <table width="100%" cellpadding="5">
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
							    <table class="table table-hover">
							    	<thead>
								      <tr>
								        <th scope="col">Sr No.</th>
								        <th scope="col">Item Name</th>
								        <th scope="col">Quantity</th>
								        <th scope="col">Description</th>
								      </tr>
								    </thead>
								    <tbody>';
    							$m = 0;
								        foreach($requested as $rows){
								        	$value = json_decode($rows->requested_data);
								        	foreach ($value as $row) {
								        		foreach ($unit as $units) {
								        			if($units->id == $row->unit_id){
								        			$m = $m + 1;
							    $table .='<tr>
										    <td>'.$m.'</td>
										    <td>'.$row->item_name.'</td>
										    <td>'.$row->quantity.' '.$units->name.'</td>
										    <td>'.$row->description.'</td>
										  </tr>';
											} } } }
									$table .='</tbody>
								</table>
						   	</td>
						  </tr>
					</table>';

					echo $table;
				?>
				<textarea name="table" class="form-control" style="display: none"><?php echo $table; ?></textarea>
			</form>
        </div>
    </div>
</div>
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