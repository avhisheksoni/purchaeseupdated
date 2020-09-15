@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
  <a href="{{ '/item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Edit Item</h5>
    <div class="card shadow mt-3">
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

            <form action="{{ route('item.update',$item->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Item Number</label>
                        <input type="text" class="form-control" value="{{ $item->item_number }}" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>HSN Code</label>
                        <input type="text" class="form-control" name="hsn_code" value="{{ $item->hsn_code }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $item->title }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Select Category</label>
                        <select name="category_id" class="form-control">
                            <option disabled="" selected="">Select Category</option>
                            @foreach ($category as $categorys)
                                <option value="{{ $categorys->id }}" @if($categorys->id == $item->category_id) selected @endif>{{ $categorys->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label>Select Subcategory</label>
                        <select name="brand" class="form-control">
                            <option disabled="" selected="">Select Subcategory</option>
                            @foreach ($brand as $brands)
                                <option value="{{ $brands->id }}" @if($brands->id == $item->brand) selected @endif>{{ $brands->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Select department</label>
                        <select name="department" class="form-control">
                            <option disabled="" selected="">Select department</option>
                            @foreach ($department as $departments)
                                <option value="{{ $departments->id }}" @if($departments->id == $item->department) selected @endif>{{ $departments->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Select Unit</label>
                        <select name="unit_id" class="form-control">
                            <option disabled="" selected="">Select Units</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @if($unit->id == $item->unit_id) selected @endif>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Service Type</label><br>
                        <input type="radio" name="service_type" value="Service" @if("Service" == $item->service_type) checked @endif> Service
                        <input type="radio" name="service_type" value="Supplier" @if("Supplier" == $item->service_type) checked @endif> Supplier
                        <input type="radio" name="service_type" value="Mixed" @if("Mixed" == $item->service_type) checked @endif> Mixed
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="5">{{ $item->description }}</textarea>
                    </div>
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection