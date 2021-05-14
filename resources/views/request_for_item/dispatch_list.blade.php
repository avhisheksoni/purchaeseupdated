@extends('../layouts.sbadmin2')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Dipatch Item To User</h5>
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
              <th>Item Requirement</th>
              <th>Items</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php 
              $i = 0;
            @endphp
            @foreach($prch_item as $dis)

              <tr>
                <td>{{ ++$i }}</td>
                <td>User Item Is Ready for Dispatch</td>
                <td>{{ dispacthcount($dis->prch_rfi_users_id) }}</td>
                <td>
                    <a class="btn btn-primary disbtn" href="{{ route('showdisitem',$dis->prch_rfi_users_id ) }}"><i class="fa fa-truck"></i></a>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
         {!! $prch_item->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection