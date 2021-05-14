
<?php //print_r(session('cart')); die; 
 ?>
@if(session('receiving_data') != null)
	<?php
	
		$session_data = session('receiving_data');
		?>
	@foreach($session_data as $data)

	<tr>
		
		<td>
	      
	        <button type="button" class="btn btn-danger deleteItem" value="{{ $data['item_id'] }}" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
	      
		</td>
		
		<td>
			<input type="text" name="item_number[]" id="item_number_{{$data['item_number']}}" value="{{$data['item_number'] }}" class="form-control" readonly="true">
		</td>
		<td>
			<input type="text" name="name[]" value="{{ $data['name'] }}" class="form-control" readonly="">
			<div align="center"><p style="font-size: 12px">[ in stock : {{ $data['actual_qty'] - $data['qty'] }} ]</p></div>
		</td>
		<td>
			<input type="number" name="qty[]" id="qty_{{$data['item_id']}}" data-id="{{$data['item_id']}}" value="{{ $data['qty']}}" class="form-control qty_item">
		</td>
		<td>
			<input type="text" name="name[]" value="{{ $data['unit_id'] }}" class="form-control" readonly="">
		</td>
	
	</tr>
@endforeach

@else
	<tr>
		<td colspan="8">
			<div class="alert alert-dismissible alert-info">There are no Items in the cart.</div>
		</td>
	</tr>
@endif

