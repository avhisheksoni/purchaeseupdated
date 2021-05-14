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
              <th>Item name</th>
              <th>qunatity</th>
              <th>Received On</th>
              <th>Returned On</th>
              <th>Return</th>
            </tr>
          </thead>
          <tbody>
            @php 
              $i = 1;
            @endphp
            @foreach($uhi as $rfi)
            <form method="post" action="{{ route('back-to-store',$rfi->id) }}">
              @csrf
              <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $rfi->item_name }}</td>
                <td><input type="number" name="squantityuser" value="{{ $rfi->squantity }}" class="form-control usitem"></td>
                <td>{{ $rfi->dispatch_date }}</td>
                <td>{{ $rfi->received_date }}</td>
                <td>
                    <button class="btn btn-primary disbtn" type="submit"><i class="fas fa-hand-point-left"></i></button>
                </td>
              </tr>
            </form>
              @endforeach
          </tbody>
        </table>
         {!! $uhi->links() !!}
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  .disabled-button{
      opacity: 0.5;
      pointer-events: none;
 }
</style>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  <script>
  $( document ).ready(function() {
  $(".usitem").on('blur',function(){
     alert('usitem');

  });
});    

</script>
@endsection