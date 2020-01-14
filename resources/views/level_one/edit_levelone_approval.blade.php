@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/request_for_item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Update User RFI</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
						<?php //print_r($requested[0]->requested_data); die; ?>
            <form action="{{ route('update_levelone_approval',$requested[0]->id) }}" method="post">
                @csrf
                @method('PUT')
                <p><b>Update Status</b></p>
                <div class="row" id="row">
                    <div class="form-group col-md-4">
                      <label class="container green">Approve
											  <input type="checkbox" name="status" value="1" @if($requested[0]->level1_status == 1) checked @endif >
											  <span class="checkmark"></span>
											</label>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="container yellow">Pending
											  <input type="checkbox" name="status" value="0" @if($requested[0]->level1_status == 0) checked @endif >
											  <span class="checkmark"></span>
											</label>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="container red">Discard
											  <input type="checkbox" name="status" value="2" @if($requested[0]->level1_status == 2) checked @endif >
											  <span class="checkmark"></span>
											</label>
                    </div>
                </div>
                <table id="invoice-item-table" class="table table-bordered">
			            <tr>
			              <th>S.No</th>
			              <th>Item Name</th>
			              <th>Quantity</th>
			              <th>Description</th>
			              <th></th>
			            </tr>
			            <?php 
				            $m = 0; 
				            foreach($requested as $rows){
				            	$value = json_decode($rows->requested_data);
				            	foreach ($value as $row) {
				            		$m = $m + 1;
				          ?>
			            <tr>
			              <td>
			              	<span id="sr_no">{{ $m }}</span>
			              </td>
			              <td>
			              	<input type="text" name="item_name[]" id="item_name{{ $m }}" class="form-control input-sm" value="{{ $row->item_name }}" readonly />
			              </td>
			              <td>
			              	<input type="number" name="quantity[]" id="quantity{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm quantity" value="{{ $row->quantity }}" readonly />
			              </td>
			              <td>
			              	<textarea name="description[]" id="description{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm number_only description" readonly >{{ $row->description }}</textarea>
			              </td>
			              <td></td>
			            </tr>
			            <?php } } ?>
			          </table>
			          <input type="hidden" name="user_id" value="{{ $row->user_id }}" />
			          <input type="hidden" name="req_user_table_id" value="{{ $requested[0]->id }}" />
                <button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4">Submit</button>
            </form>
        </div>
    </div>
</div>
<style type="text/css">
	/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

#row {
	margin-right: 0;
  margin-left: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container.green  input:checked ~ .checkmark {
  background-color: green;
}

.container.red  input:checked ~ .checkmark {
  background-color: red;
}

.container.yellow  input:checked ~ .checkmark {
  background-color: #ffa80a;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
@endsection
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script>
$(document).ready(function(){
  var final_total_amt = $('#final_total_amt').text();
  var count = <?php echo $m; ?>;
  
  $(document).on('click', '#add_row', function(){
    count++;
    $('#total_item').val(count);
    var html_code = '';
    html_code += '<tr id="row_id_'+count+'">';
    html_code += '<td><span id="sr_no">'+count+'</span></td>';
    
    html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" /><input type="hidden" name="user_id[]" value="{{ Auth::user()->id }}" id="user_id'+count+'" class="form-control input-sm" /></td>';
    html_code += '<td><input type="text" name="quantity[]" id="quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only quantity" /></td>';
    html_code += '<td><textarea name="description[]" id="description'+count+'" data-srno="'+count+'" class="form-control input-sm number_only description"></textarea></td>';
    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
    html_code += '</tr>';
    $('#invoice-item-table').append(html_code);
  });
  
  $(document).on('click', '.remove_row', function(){
    var row_id = $(this).attr("id");
    var total_item_amount = $('#order_item_final_amount'+row_id).val();
    var final_amount = $('#final_total_amt').text();
    var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
    $('#final_total_amt').text(result_amount);
    $('#row_id_'+row_id).remove();
    count--;
    $('#total_item').val(count);
  });
  
});
</script>