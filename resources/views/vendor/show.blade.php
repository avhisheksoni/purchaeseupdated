@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/vendor' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Show Vendor</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
        		<form action="" method="">
								<div class="row">
                    <div class="form-group col-md-6">
                        <label>Registered Vendor Number</label>
                        <input type="text" class="form-control"  value="{{ $vendor->register_number }}" name="register_number" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Firm Name</label>
                        <input type="text" class="form-control"  value="{{ $vendor->firm_name }}" name="firm_name" readonly="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Vendor Name</label>
                        <input type="text" class="form-control"  value="{{ $vendor->name }}" name="name" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control"  value="{{ $vendor->email }}" name="email" readonly="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mobile No.</label>
                        <input type="number" class="form-control"  value="{{ $vendor->mobile }}" name="mobile" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Altername Number</label>
                        <input type="number" class="form-control"  value="{{ $vendor->alt_number }}" name="alt_number" readonly="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>GST No.</label>
                        @if($vendor->na_gst == 0)
                            <input type="text" class="form-control"  value="{{ $vendor->gst_number }}" name="gst_number" readonly="">
                        @else
                            <div class="checkbox" style="font-size: 12px; font-weight: bold; ">
                                <input type="checkbox" name="na_gst" value="1" checked=""><span style="color: #000; margin-right: 5px">
                                <span style="color:#a94444; margin-right: 5px">GST no. not available</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Items Dealing : </label>
                        <select name="item_id[]" class="form-control" multiple readonly="">
                        	@foreach($items as $item)
                        		<option value="{{ $item->id }}">{{ $item->title }}</option>
                        	@endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="5" placeholder="Address" readonly="">{{ $vendor->address }}</textarea>
                    </div>
                </div>
						</form>
        </div>
    </div>
</div>
@endsection