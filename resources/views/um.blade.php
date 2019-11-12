@extends('layouts.sbadmin2')

@section('content')

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Units</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($um))
              @foreach ($um as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->quantity }}</td>
                <td>
                  <a class="btn btn-primary" data-toggle="modal" data-id="{{ $row->id }}" data-target="#myModal{{ $row->id }}">Edit</a>

                  <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?') == true) { getElementById('delete-form-{{ $row->id }}').submit(); }" class="btn btn-danger">Delete</a>

                  <form id="delete-form-{{ $row->id }}" action="{{ route('um.destroy', $row->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                    
                  </form>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $um->links() !!}
      </div>
    </div>
  </div>
</div>

<!--Add Units Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    	<div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">Add Units</h4>
	        </div>
	        <div class="modal-body">
	          	<form action="" method="" id="addForm">
		            @csrf
		            <div class="row">
		                <div class="form-group col-md-12">
		                    <label>Units</label>
		                    <input type="name" class="form-control" placeholder="units" id="unit" name="unit">
		                </div>
		            </div>
		            <button type="submit" name="submit" id="addUnit" class="btn btn-primary float-right">Submit</button>
		        </form>
	        </div>
      	</div>
    </div>
</div>
<!--Add Units Modal -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--Update Units Modal -->
@foreach ($um as $row)
<div class="modal fade" id="myModal{{ $row->id }}" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Units</h4>
        </div>
        <div class="modal-body">
          <form id="updateForm{{ $row->id }}">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="form-group col-md-12">
                <label>Units</label>
                <input type="text" class="form-control" value="{{ $row->quantity }}" id="unit" name="unit">
                <input type="hidden" class="form-control" value="{{ $row->id }}" id="id" name="id">
              </div>
            </div>
            <button type="submit" name="submit" id="updateUnit" class="btn btn-primary float-right">Update</button>
          </form>
        </div>
      </div>
  </div>
</div>
<script>
$(document).ready(function() {
   $("#updateForm{{ $row->id }}").on('submit', function(e) {
      e.preventDefault();
      var id = '{{ $row->id }}';
      $.ajax({
          type: 'post',
          url: "um/"+id,
          data: $('#updateForm{{ $row->id }}').serialize(),
          success: function(data) {
              alert('Units Updated');
              location.reload();
          },
      });
  });
});
</script>
@endforeach
<!--Update Units Modal -->
<script>
$(document).ready(function() {
   $("#addForm").on('submit', function(e) {
   		e.preventDefault();
 		$.ajax({
	        type: 'post',
	        url: '/um',
	        data: $('#addForm').serialize(),
	        success: function(data) {
            	alert('Units added');
            	location.reload();
	        },
	    });
	});
});
</script>


@endsection