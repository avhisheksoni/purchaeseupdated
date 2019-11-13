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
                        <label>Vendor Name</label>
                        <input type="name" class="form-control" value="{{ $vendor->name }}" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ $vendor->email }}" readonly="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mobile No.</label>
                        <input type="mobile" class="form-control" value="{{ $vendor->mobile }}" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <input type="address" class="form-control" value="{{ $vendor->address }}" readonly="">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection