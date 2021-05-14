@extends('../layouts.sbadmin2')

@section('content')
<?php
	$user_id = request()->segment('2');
?>
<?php 
if($chk == '') { ?> 
<div class="container-fluid">
  <a href="{{ '/user_request' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Quotation Item Details</h5>
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
							{{-- <th>#Avaibility</th> --}}
							{{-- <th>#Description</th> --}}
							{{-- <th>#Action</th> --}}
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
						<td id="{{ "itemqt".$i++ }}"><span class="avail-item-msg" id=""><input type="text" value="{{ $item->quantity }}" class="form-control quantity" name="qty[]" readonly=""></span></td>
						{{-- <td><span class="avail-item-msg" id="item">{{ 
							     $qqty= DB::table("prch_store_item")->where(['item_number'=>$item->item_no])->get()->sum("quantity")  }}</span></td> --}}
                           

						</tr>
						@endforeach
						<input type="hidden" name="item_num[]" value="" class="item">
						<input type="hidden" name="req_qty[]" value="" class="itemqty">
					
						<input type="hidden" value="{{ $userrfi->id }}"  id="impid">
					</tbody>
				</table>
			</div>
        </div>
        <div class="row">
	    	  <div class="row">
            <div class="col-md-12">

                <div class="p-2 text-center">
                	<?php 
                	if($userrfi->manager_status == 0 ){  ?>
                	 <button class="btn btn-success" id="approveit">Approve</button>
                	 <?php } else if($userrfi->manager_status == 1 && $userrfi->level1_status == 1 && $userrfi->level2_status == 1 ){ ?>
                   <?php if(!empty($MailStatus)) { ?>
                    <button class="btn btn-primary" disabled >Qutation Send</button>
                  <?php }else { ?>
                   <a class="btn btn-primary" href="{{ route('applyforquotation',$userrfi->id) }}">Send Qutation</a>
                  <?php } ?>
                    <?php }else{ ?>
                     <button class="btn btn-success" id="">Send For Approval</button>
                     <?php } ?>
                  
               
                <input type="hidden" value="{{-- {{ $id }} --}}"  id="impid">
                    {{-- <button class="btn btn-danger"> Send For Approval</button>
                   --}}
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
    $('#approveit').on('click',function(){
          var pid = $('#impid').val();
          alert(pid);
          $.ajax({
                 type: "GET",
                 url: "{{ route('managr-apv') }}",
                 data: {'pid':pid},
                 success: function(res){
                   console.log(res);
                 }

             })


        });
});
</script>
