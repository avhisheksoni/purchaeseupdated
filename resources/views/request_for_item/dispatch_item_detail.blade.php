@extends('../layouts.sbadmin2')

@section('content')
<?php
	$user_id = request()->segment('2');
?>
<?php 
if($chk == '') { ?>
<div class="container-fluid">
  <a href="{{ '/user_request' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Dispatch Item Details</h5>
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
                <label>For Name</label>
                <input class="form-control" value="{{ App\User::find($user)->name }}" readonly="">
            </div>
            <div class="form-group col-md-6">
                <label>At Location</label>
                <input class="form-control" value="" readonly="">
            </div>

        {{-- 	<div class="col-md-12 mt-2 mb-2">
        		<label>Select WareHouse</label>
        		@php 
        		$ware = App\Warehouse::all();
        		@endphp 
	      		<select name="warehouse_id" class="form-control warehouseCLS" id="warehouse">
	      			<option value="">--Select--</option>
	      			@foreach($ware as $war)
	      			<option value="{{ $war->id }}">{{ $war->name }}</option>
	      			@endforeach
	      		</select>
	      	</div> --}}
        </div>

	    <div class="row">
	      	<div class="col-md-12">
				<table class="table table-border" width="100%" id="userTable">
					<thead>
						<tr>
							<th>#Item Number</th>
							<th>#Name</th>
							<th>#Quantity</th>
							<th>#Avaibility</th>
							{{-- <th>#Description</th> --}}
							<th>#Action</th>
						</tr>
					</thead>
					<tbody id="purchBody">
						@php 
						$i=0;
						@endphp
						@foreach($items as $item)
						<tr>
						<td><input type="text" class="form-control" value="{{ $item->item_no }}" readonly="">
						<input type="hidden" class="form-control itemno" name="itemid[]" value="{{ $item->item_id }}" readonly=""></td>
						<td>{{ $item->item_name }}</td>
						<td id="{{ "itemqt".$i++ }}"><span class="avail-item-msg" id=""><input type="text" value="{{ $item->squantity }}" class="form-control quantity" name="qty[]" readonly=""></span></td>
						<td><span class="avail-item-msg" id="item">{{ 
							     $qqty= DB::table("prch_store_item")->where(['item_number'=>$item->item_no,'warehouse_id'=>$item->from_warehouse])->get()->sum("quantity")  }}</span></td>
						<?php if($item->dispatch_status == 1){ ?>
						<td>Dispatched</td>
						<?php } else { ?>
						<td><a class="btn btn-info" href="{{-- {{ route("dispatch_to_user",$item->prch_rfi_users_id) }} --}}">Dispatch item</a></td>
						<?php } ?>

						</tr>
						@endforeach
						<input type="hidden" name="item_num[]" value="" class="item">
						<input type="hidden" name="req_qty[]" value="" class="itemqty">
					
						<input type="hidden" value=""  id="impid">
					</tbody>
				</table>
			</div>
        </div>
        <div class="row">
	    	<div class="col-md-12">
	    		<div class="p-2 text-center">
	    			<?php
	    			if($item->dispatch_status == 2){ ?>
	    			<button class="btn btn-success" id="">Dispatched</button>
	    			<?php } else if($qqty == 0 ) { ?> 
		      		<a class="btn btn-info" href="">Item Not  In Stock</a>
		      		<?php  } else {?>
		      		<a class="btn btn-info" href="{{ route("dispatch_to_user",$item->prch_rfi_users_id) }}">Dispatch item</a>
		      		<?php } ?>
	      		</div>
	      	</div>
	    </div>
	  </div>
	</div>
</div>
<?php } else{
    echo $chk;
} ?>

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
<script>
$('document').ready(function(){
   $("#warehouse").on('change',function(){
             var wid = $(this).val();
// var arr = $('input[name="itemid[]"]').map(function () {
//     return this.value; // $(this).val()
// }).get();
// var qty = $('input[name="qty[]"]').map(function () {
//     return this.value; // $(this).val()
// }).get();
// console.log(qty);
           //var i = 0;
        $(".itemno").each(function(){
        	//alert($(this).attr(id));
            var itemid = $(this).val(); 
            var qty = $(".quantity").val();
              $.ajax({
                 type: "GET",
                 url: "",
                 data: {'wid':wid,'item_id':itemid,'qty':qty },
                 success: function(res){
                   console.log(res);
                   $("#items").text("Avhi");
                    }
                      });
            

   });
   });
});
</script>
