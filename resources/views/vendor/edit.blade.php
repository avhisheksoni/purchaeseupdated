@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/vendor' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Edit Vendor</h5>
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
			<?php
                if($vendor->na_gst == 0){
    				$gsts = $vendor->gst_number;
    				$gst_state_no = substr($gsts, 0, 2);
    				$gst_no = substr($gsts, 2, (int)$gsts);
                    //dd(gettype(substr($gsts, "2", $gsts)));
                }else{
                    $gst_state_no = '';
                    $gst_no = '';
                }
			?>                        		
            <form action="{{ route('vendor.update',$vendor->id) }}" method="post">
                @csrf
                @method('PUT')
				<div class="row">
                    <div class="form-group col-md-6">
                        <label>Registered Vendor Number</label>
                        <input type="text" class="form-control" value="{{ $vendor->register_number }}" name="register_number" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Firm Name</label>
                        <input type="text" class="form-control" value="{{ $vendor->firm_name }}" name="firm_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Vendor Name</label>
                        <input type="text" class="form-control" value="{{ $vendor->name }}" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ $vendor->email }}" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mobile No.</label>
                        <input type="number" class="form-control" value="{{ $vendor->mobile }}" name="mobile">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Altername Number</label>
                        <input type="number" class="form-control" value="{{ $vendor->alt_number }}" name="alt_number">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>GST State Code</label>
                        <select class="form-control" name="gst_state_code">
                            <option disabled="" selected="" style="@if($vendor->na_gst == 0) display:none @endif">Select GST State Code</option>
                        	@foreach($gst as $gst_state)
                        	<?php $gst_id = str_pad($gst_state->id, 2, '0', STR_PAD_LEFT); ?>
                        		<option value="{{ $gst_id }}" @if($gst_state_no==$gst_id) selected @endif >{{ $gst_id }} | {{ $gst_state->state_name }}</option>
                        	@endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>GST No.</label>
                        <input type="text" class="form-control" value="{{ $gst_no }}" name="gst_number">
                    </div>
                    <div class="col-md-12 checkbox" style="font-size: 12px; font-weight: bold; ">
                        <span style="color:#a94444; margin-right: 5px">If not GST no. </span>
                        <label><input type="checkbox" name="na_gst" value="1" @if($vendor->na_gst == 1) checked @endif><span style="color: #000; margin-left: 2px">N/A</span></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Items Dealing : </label>
                        <select name="item_id[]" class="form-control" multiple>
                        	<option disabled="">Select Items</option>
                        	@foreach($items as $item)
                        		<?php 
									$itemid = json_decode($vendor->item_id);
								?>
                        		<option value="{{ $item->id }}" @if(!empty($itemid)) @if(in_array($item->id,$itemid)) selected @endif @endif >{{ $item->title }}</option>
                        	@endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="5" placeholder="Address">{{ $vendor->address }}</textarea>
                    </div>
                </div>
				<button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection