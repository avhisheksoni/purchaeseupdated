@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/manager_request' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
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
            {{-- @if($reason=='') {{ dd($reason[0]->discard_reason) }} @else {{ dd('no') }} @endif --}}
						<?php //print($requestForItem->requested_role); die; ?>
            <form action="{{ route('user_req_update',$requestForItem->id) }}" method="post">
                @csrf
                @method('PUT')
								
								<div class="row">
                    <div class="form-group col-md-6">
                        <label>User Name</label>
                        <input class="form-control" value="{{ $mem_details->name }} {{ $mem_details->last_name }}" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input class="form-control" value="{{ $mem_details->email }}" readonly="">
                    </div>
                </div>
								<?php //print_r($requestForItem->manager_status); die; ?>
                <!-- <p><b>Update Status</b></p>
                <div class="row" id="row">
                    <div class="form-group col-md-4">
                      <label class="container green">Approve
											  <input type="radio" name="status" value="1" @if($requestForItem->manager_status == 1) checked @endif >
											  <span class="checkmark"></span>
											</label>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="container yellow">Pending
											  <input type="radio" name="status" value="0" @if($requestForItem->manager_status == 0) checked @endif >
											  <span class="checkmark"></span>
											</label>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="container red">Discard
											  <input type="radio" name="status" value="2" @if($requestForItem->manager_status == 2) checked @endif  data-toggle="modal" data-target="#myModal" id="dismissResponce">
											  <span class="checkmark"></span>
											</label>
                    </div>
                </div> -->
                <table id="invoice-item-table" class="table table-bordered">
			            <tr>
			              <th>S.No</th>
			              <th>Item Name</th>
			              <th>Quantity</th>
			              <th>Description</th>
			              <th></th>
			            </tr>
			            <?php 
                    //dd($requestForItem->discardReason);
				            $m = 0; 
				            $data = json_decode($requestForItem);
				            $decoded_data = json_decode($data->requested_data);
				            foreach($decoded_data as $row){
				            	$m = $m + 1;
                      $reason = ($requestForItem->discardReason !=null) ? $requestForItem->discardReason->level1_discard: '';
                      $reason1 = ($requestForItem->discardReason !=null) ? $requestForItem->discardReason->level2_discard: '';
                      if(!empty($reason) || !empty($reason1)){
                        echo "<script src='/themes/sb-admin2/vendor/jquery/jquery.min.js'></script>
                        <script> 
                            $(window).on('load',function(){
                                $('#myModal1').modal({backdrop: 'static', keyboard: false});
                            });
                        </script>";
                      }
				            	//print_r($data->manager_status); die;
				          ?>
			            <tr>
			              <td>
			              	<span id="sr_no">{{ $m }}</span>
			              </td>
			              <td>
			              	<input type="text" name="item_name[]" id="item_name{{ $m }}" class="form-control input-sm" value="{{ $row->item_name }}" />
			              </td>
			              <td>
                      <div class="row">
                        <div class="col-md-8">
			              	    <input type="number" name="quantity[]" id="quantity{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm quantity" value="{{ $row->quantity }}" />
                        </div>
                        <div class="col-md-4">
                          <select name="unit[]" id="unit{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm unit" >
                              @foreach($unit as $rows)
                                <option value="{{$rows->id}}" @if($row->unit_id == $rows->id) selected @endif >{{ $rows->name }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
			              </td>
			              <td>
			              	<textarea name="description[]" id="description{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm number_only description" >{{ $row->description }}</textarea>
			              </td>
			              <td></td>
			            </tr>
			            <?php } ?>
			          </table>
                @permission('purchase_manager_approval') 
  			          @if($requestForItem->level1_status == 0 && $requestForItem->requested_role != 'Manager')
  			          <div align="right">
  			            <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">+</button>
  			          </div>
  			          @endif
                @endpermission
			          <input type="hidden" name="user_id" value="{{ $row->user_id }}" />
			          <input type="hidden" name="req_user_table_id" value="{{ $requestForItem->id }}" />
			           <!-- Modal -->
								  <div class="modal fade" id="myModal" role="dialog">
								    <div class="modal-dialog">
								      <!-- Modal content-->
								      <div class="modal-content">
								        <div class="modal-header">
								          <h4 class="modal-title">Discard Reason</h4>
								          <button type="button" class="close modalCloss" data-dismiss="modal">&times;</button>
								        </div>
								        <div class="modal-body">
								          <textarea name="discardReason" id="discardReason" class="form-control input-sm number_only discardReason" placeholder="Enter Reason.. Why you discard ?">@if($requestForItem->discardReason !=null) {{ $requestForItem->discardReason->discard_reason }} @endif</textarea>
								        </div>
								        <div class="modal-footer">
								          <button type="button" class="btn btn-default modalCloss" data-dismiss="modal">Close</button>
								        </div>
								      </div>
								    </div>
								  </div>
								 <!-- Modal -->

                @permission('purchase_manager_approval') 
			          @if($requestForItem->manager_status == 0 && $requestForItem->level1_status == 0 && $requestForItem->requested_role != 'Manager')
                	<button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4">Submit</button>
                @else
                  <button disabled="" class="btn btn-primary error-w3l-btn px-4">Submit</button>
                @endif
                @endpermission
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


<div id="myModal1" class="modal hide fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body text-center" style="color:#000">
        <h3>Discard Reason</h3>
        <p>@if($requestForItem->discardReason !=null) {{ $requestForItem->discardReason->level1_discard }}  {{ $requestForItem->discardReason->level2_discard }} @endif</p>
      </div>
    </div>
  </div>
</div>
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
<script>
	$(document).ready(function(){
		$('.modalCloss').on('click', function(){
			var val = $('#discardReason').val();
			if(val == ''){
				$('#dismissResponce').prop('checked', false);
			}
		});
	});
</script>