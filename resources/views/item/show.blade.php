@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Show Item</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Item Number</label>
                        <input type="name" class="form-control" value="{{ $item->item_number }}" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input type="text" class="form-control" value="{{ $item->title }}" readonly="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Category</label>
                        @foreach ($category as $categorys)
                            @if($item->category_id == $categorys->id)
                                <input type="text" class="form-control" value="{{ $categorys->category_name }}" readonly="">
                            @endif
                        @endforeach
                    </div>
                    <div class="form-group col-md-6">
                        <label>Unit</label>
                        @foreach ($units as $unit)
                            @if($item->unit_id == $unit->id)
                                <input type="text" class="form-control" value="{{ $unit->quantity }}" readonly="">
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Descriptions</label>
                        <textarea readonly="" class="form-control" rows="5">{{ $item->description }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection