@extends('layouts.sbadmin2')

@section('content')

<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Members Listing</h5>
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
              <th>No</th>
	            <th>Employee Name</th>
	            <th>Email</th>
	            <th>Phone No.</th>
	            <th>Role</th>
	            <th>Status</th>
	            <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($member))
              @foreach ($member as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->emp_name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->contact }}</td>
                <td><center><span style="background:#018401; color:#fff; border-radius:8px; padding: 0px 12px;">{{-- {{ $row->assign_role->display_name }} --}}</span></center></td>
                <td>
                	<center><span style="{{ ($row->status == 0)?'color:#ff9a00':'color:#ff0000' }}; font-weight: bold">{{ ($row->status == 0)?'Active':'Unactive' }}</span></center>
                </td>
                <td>
                  <a class="btn btn-primary" data-toggle="modal" data-id="{{ $row->id }}" data-target="#myModal{{ $row->id }}" style="color: #fff" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                  {{-- <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?') == true) { getElementById('delete-form-{{ $row->id }}').submit(); }" class="btn btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>

                  <form id="delete-form-{{ $row->id }}" action="{{ route('members.destroy', $row->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                  </form> --}}
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $member->links() !!}
      </div>
    </div>
  </div>
</div>

<!--Add Units Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    	<div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">Add Members</h4>
	        </div>
	        <div class="modal-body">
	          	<form action="" method="" id="addForm">
			            @csrf
			            <div class="row">
							        <div class="form-group col-md-6">
						              <strong>First Name:</strong>
						              <input type="text" name="first_name" class="form-control" placeholder="First Name">
						              <span id="first_name"></span>
						          </div>
						          <div class="form-group col-md-6">
						              <strong>Last Name:</strong>
						              <input type="text" name="last_name" class="form-control" placeholder="Last Name">
						              <span id="last_name"></span>
						          </div>
							    </div>
							    <div class="row">
							        <div class="col-xs-12 col-sm-12 col-md-12">
							            <div class="form-group">
							                <strong>Email:</strong>
							                <input type="text" name="email" class="form-control" placeholder="Email">
							                <span id="email"></span>
							            </div>
							        </div>
							    </div>
							    <div class="row">
							        <div class="col-xs-12 col-sm-12 col-md-12">
							            <div class="form-group">
							                <strong>Role Assign:</strong>
							                <select name="role_id" class="form-control">
							                	<option selected="" disabled="">Select Role</option>
							                	@foreach($role as $roles)
							                		<option value="{{ $roles->id }}">{{ $roles->name }}</option>
							                	@endforeach
							                </select>
							                <span id="role_id"></span>
							            </div>
							        </div>
							    </div>
							    <div class="row">
							        <div class="col-md-6">
							            <div class="form-group">
							                <strong>Phone No.:</strong>
							                <input type="text" name="phone" class="form-control" placeholder="Phone No.">
							                <span id="phone"></span>
							            </div>
							        </div>
							        <div class="col-md-6">
							            <div class="form-group">
							                <strong>Password:</strong>
							                <input type="password" name="password" class="form-control" placeholder="Password">
							                <span id="password"></span>
							            </div>
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
@foreach ($member as $row)
<div class="modal fade" id="myModal{{ $row->id }}" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Members</h4>
        </div>
        <div class="modal-body">
          <form id="updateForm{{ $row->id }}">
            @csrf
            @method('PUT')
            <div class="row">
				        <div class="form-group col-md-6">
			              <strong>First Name:</strong>
			              <input type="text" name="first_name" class="form-control" value="{{ $row->first_name }}">
			              <span id="update_first_name"></span>
			          </div>
			          <div class="form-group col-md-6">
			              <strong>Last Name:</strong>
			              <input type="text" name="last_name" class="form-control" value="{{ $row->last_name }}">
			              <span id="update_last_name"></span>
			          </div>
				    </div>
				    <div class="row">
				        <div class="col-xs-12 col-sm-12 col-md-12">
				            <div class="form-group">
				                <strong>Email:</strong>
				                <input type="text" name="email" class="form-control" value="{{ $row->email }}">
				                <span id="update_email"></span>
				            </div>
				        </div>
				    </div>
				    <div class="row">
				        <div class="col-xs-12 col-sm-12 col-md-12">
				            <div class="form-group">
				                <strong>Role Assign:</strong>
				                <select name="role_id" class="form-control">
				                	@foreach($role as $roles)
				                		<option value="{{ $roles->id }}" @if($row->role_id == $roles->id) {{ 'selected' }} @endif >{{ $roles->name }}</option>
				                	@endforeach
				                </select>
				                <span id="update_role_id"></span>
				            </div>
				        </div>
				    </div>
				    <div class="row">
				        <div class="col-md-6">
				            <div class="form-group">
				                <strong>Phone No.:</strong>
				                <input type="text" name="phone" class="form-control" value="{{ $row->phone }}">
				                <span id="update_phone"></span>
				            </div>
				        </div>
				        <div class="col-md-6">
				            <div class="form-group">
				                <strong>Status:</strong>
				                <select name="status" class="form-control">
				                	<option value="0" @if($row->status == 0) {{ 'selected' }} @endif >Active</option>
				                	<option value="1" @if($row->status == 1) {{ 'selected' }} @endif >Unactive</option>
				                </select>
				            </div>
				        </div>
				    </div>
				    <input type="hidden" name="user_id" value="{{ $row->user_id }}">
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
      $('#update_first_name').html('');
			$('#update_last_name').html('');
			$('#update_email').html('');
			$('#update_role_id').html('');
			$('#update_phone').html('');
      var id = '{{ $row->id }}';
      $.ajax({
          type: 'post',
          url: "members/"+id,
          data: $('#updateForm{{ $row->id }}').serialize(),
          success: function(data) {
          	if(data == 'success') {
	        		alert('Member details updated successfully');
	            location.reload();
	        	}else{
	        		var json = JSON.parse(data);
	        		$.each(json, function (key, val) {
	        				alert(val);
	        				$('#update_'+key).html('<span style="color:red">'+val+'</span>');
							});
	        	}
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
   		$('#first_name').html('');
			$('#last_name').html('');
			$('#email').html('');
			$('#role_id').html('');
			$('#phone').html('');
			$('#password').html('');
 		$.ajax({
	        type: 'post',
	        url: '/members',
	        data: $('#addForm').serialize(),
	        success: function(data) {
	        	if(data == 'success') {
	        		alert('Member Added successfully');
	            location.reload();
	        	}else{
	        		var json = JSON.parse(data);
	        		$.each(json, function (key, val) {
	        				$('#'+key).html('<span style="color:red">'+val+'</span>');
							});
	        	}
	        },
	    });
	});
});
</script>


@endsection