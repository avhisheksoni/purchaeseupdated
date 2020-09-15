@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Vendors Listing</h5>
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
              <th>Firm Name</th>
              <th>Email</th>
              <th>Mobile No.</th>
              <th>Reg. vendor No.</th>
              <th>GST No.</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($vendors))
              @foreach ($vendors as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->firm_name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->mobile }}</td>
                <td>{{ $row->register_number }}</td>
                <td>@if($row->na_gst == 0){{ $row->gst_number }}@else {{ 'N/A' }} @endif</td>
                <td>
                  <form action="{{ route('vendor.destroy',$row->id) }}" method="POST">
                    <a class="btn btn-success" href="{{ route('vendor.show',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" href="{{ route('vendor.edit',$row->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $vendors->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection