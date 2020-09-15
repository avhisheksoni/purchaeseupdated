@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <!-- <a href="{{ '/request_for_item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a> -->
    <h5 class="main-title-w3layouts mb-2">View RFI</h5>
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
						
            <form action="{{ route('request_for_item.update',$requestForItem->id) }}" method="post">
                @csrf
                @method('PUT')
                <table id="invoice-item-table" class="table table-bordered">
			            <tr>
			              <th>S.No</th>
			              <th>Item Name</th>
			              <th>Quantity</th>
			              <th>Description</th>
			            </tr>
			            <?php 
				            $m = 0; 
				            $data = json_decode($requestForItem);
				            $decoded_data = json_decode($data->requested_data);
				            foreach($decoded_data as $row){
				            	$m = $m + 1;
				            	//print_r($row->item_name); die;
				          ?>
			            <tr>
			              <td>
			              	<span id="sr_no">{{ $m }}</span>
			              </td>
			              <td>
			              	<input type="text" name="item_name[]" id="item_name{{ $m }}" class="form-control input-sm" value="{{ $row->item_name }}" readonly="" />
			              </td>
			              <td>
			              	<div class="row">
                        		<div class="col-md-8">
			              			<input type="number" name="quantity[]" id="quantity{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm quantity" value="{{ $row->quantity }}" readonly="" />
			              		</div>

			                    <div class="col-md-4">
			                      	<select name="unit[]" id="unit1" data-srno="1" class="form-control input-sm unit" >
			                      		@foreach($unit as $rows)
				                          <option value="{{$rows->id}}" @if(!empty($unit)) @if($row->unit_id == $rows->id) selected @endif @endif >{{ $rows->name }}</option>
				                        @endforeach
				                    </select>
			                    </div>
			                </div>
			              </td>
			              <td>
			              	{{-- <input type="text" name="description[]" id="description{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm number_only description" value="{{ $row->description }}" /> --}}
			              	<textarea name="description[]" id="description{{ $m }}" data-srno="{{ $m }}" class="form-control input-sm number_only description" readonly="" >{{ $row->description }}</textarea>
			              </td>
			            </tr>
			            <?php } ?>
			          </table>
                {{-- <button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4">Submit</button> --}}
            </form>
        </div>
    </div>
</div>
@endsection