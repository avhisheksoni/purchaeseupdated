@extends('../layouts.sbadmin2')

@section('content')
<?php
	$user_id = request()->segment('2');
?>
<div class="container-fluid">
  <a href="{{ '/user_request' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Select Items</h5>
  <div class="card shadow mt-3">
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('alert'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
            <div class="form-group col-md-6">
                <label>User Name</label>
                <input class="form-control" value="{{ $mem_details->name }} {{ $mem_details->last_name }}" readonly="">
            </div>
            <div class="form-group col-md-6">
                <label>Email</label>
                <input class="form-control" value="{{ $mem_details->email }}" readonly="">
            </div>

        	<div class="col-md-12 mt-2 mb-2">
        		<label>Select WareHouse</label>
	      		<select name="warehouse_id" class="form-control warehouseCLS" id="warehouse">
	      			<option disabled="" selected="">Select</option>
	      			@foreach($warehouse as $wh)
		      			<option value="{{ $wh->id }}">{{ $wh->name }}</option>
		      		@endforeach
	      		</select>
	      	</div>
        </div>

	    <div class="row">
	      	<div class="col-md-12">
				<table class="table table-border" width="100%" id="userTable">
					<thead>
						<tr>
							<th>#Item Number</th>
							<th>#Name</th>
							<th>#Quantity</th>
							<th>#Description</th>
						</tr>
					</thead>
					<tbody id="purchBody">
						<?php 
				            $m = 0;
				            $data = json_decode($requestForItem);
				            $decoded_data = json_decode($data->requested_data);
				            foreach($decoded_data as $row){
				            	$items = $row->item_name;
				            	$item = explode("|",$items);
				        ?>
						<tr>
							<td>{{ $item[1] }}</td>
							<td>{{ $item[0] }}</td>
							<td>{{ $row->quantity }} <span class="avail-item-msg" id="item-<?php echo str_replace(' ', '', $item[1]); ?>"></span></td>
							<td>{{ $row->description }}</td>
						</tr>
						<input type="hidden" name="item_num" value="<?php echo str_replace(' ', '', $item[1]); ?>">
						<input type="hidden" name="req_qty" value="{{ $row->quantity }}">
						<?php } ?>
					</tbody>
				</table>
			</div>
        </div>
        <div class="row">
	    	<div class="col-md-12">
	    		<div class="p-2 text-center">
		      		<button class="btn btn-success" id="err-{{ $user_id }}">Approve</button>
		      		<button class="btn btn-danger">Discard</button>
	      		</div>
	      	</div>
	    </div>
	  </div>
	</div>
</div>

@endsection

<style type="text/css">
	.avail-item-msg{
		color: #ad3636;
    	margin-left: 10px;
    	font-size: 12px;
    	font-weight: bold;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- search and store data in session -->
<script>
<?php 
    $m = 0;
    $data = json_decode($requestForItem);
    $decoded_data = json_decode($data->requested_data);
    foreach($decoded_data as $row){
    	$items = $row->item_name;
    	$item = explode("|",$items);
?>
$('document').ready(function(){
	$('.warehouseCLS').change(function(){
	    var value = document.getElementById("warehouse").value;
	    var item_num = "<?php echo str_replace(' ', '', $item[1]); ?>";
	    var req_qty = "<?php echo $row->quantity; ?>";
	    if(value != '')
	    {
	      var _token = $('input[name="_token"]').val();
	      $.ajax({
	        url:"{{ route('set_warehouse') }}",
	        method:"POST",
	        data:{warehouse_id:value, item_num:item_num, req_qty:req_qty, _token:_token},
	        success:function(data){
	        	$('#item-'+item_num).html(data);
	        	$('#err-<?php echo $user_id; ?>').attr("disabled", true);
	        }
	      });
	    }
	});  
});
<?php } ?>  
</script>