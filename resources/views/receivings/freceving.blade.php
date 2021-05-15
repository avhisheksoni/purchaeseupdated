@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Forced Item List</h5>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Item No.</th>
              <th>Item Name</th>
              <th>Category</th>
              <th>Sub-category</th>
              <th>Quantity</th>
            </tr>
          </thead>
          <tbody>
          	@php $s_no= 1; @endphp
          	@foreach($receitem as  $recq)
              <tr>
                <td>{{ $s_no }}</td>
                <td>{{ $recq->item->item_number }}</td>
                <td>{{ $recq->item->title }}</td>
                <td>{{ $recq->item->category->name }}</td>
                <td>{{ $recq->item->brand_name->name }}</td>
                <td>{{ $recq->qty." ".$recq->item->unit->name }}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection