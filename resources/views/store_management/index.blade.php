@extends('../layouts.sbadmin2')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Approved Quotation</h5>
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
              <th>P.O. ID</th>
              <th>Vendor's Firm Name</th>
              <th>Vendor's Name</th>
              <th>Vendor's Mob No.</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @if (!empty($data))
                @foreach($data as $row)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td>{{ $row->po_id }}</td>
                  <td>{{ $row->firm_name }}</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->mobile }}</td>
                  <td>
                    <a class="btn btn-success" href="{{ route("view_accepted_po",$row->approval_quotation_id) }}"> View Items </a>
                  </td>
                </tr>
                @endforeach
              @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection