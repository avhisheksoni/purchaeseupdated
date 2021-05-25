@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Manage Transfer</h5>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

				<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item" style="width: 50%">
				    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><b>Requested by Sites</b></a>
				  </li>
				  <li class="nav-item" style="width: 50%">
				    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>All Transfer Log</b></a>
				  </li>
				</ul>

				<div class="tab-content" id="myTabContent">
				  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			          <thead>
			            <tr>
			              <th>S.No</th>
			              <th>From</th>
			              <th>To</th>
			              <th>Date</th>
			              <th>View</th>
			              <th>Admin</th>
			              <th>Super Admin</th>
			            </tr>
			          </thead>
			          <tbody>
			            @php $i=1; @endphp
		          		@foreach($receivings as $rec)
			             <tr>
			                <td>{{ $i++ }}</td>
			                <td>{{ $rec->site->job_describe }}</td>
			                <td>{{ $rec->warehouse->name }}</td>
			                <td>{{ $rec->date }}</td>
			                <td>
			                	<a href="{{ route('see_chalan',[$rec->id]) }}" class="glyphicon glyphicon glyphicon-barcode" title="Click to see Challan"><i class="fa fa-lg fa-barcode"></i></a>
			                	
			                	 &nbsp;&nbsp;&nbsp;
			                	 <a href="{{ route('site_item_req',[$rec->receiving_req_id]) }}"><i class="fa fa-lg fa-eye"></i></a>
			                </td>
			                <td>
			                	@if($rec->admin == '0' && $rec->complete == '0')
				                	<a href="{{ route('admin_approve',[$rec->id]) }}" class="btn btn-success btn-sm ">Approve</a>
				                	&nbsp;&nbsp;
				                	<a href="{{ route('decline_by_admins',[$rec->id]) }}" class="btn btn-danger btn-sm ">Decline</a>
			                	@elseif($rec->admin == '1')
			                		<h5 style="color: green">Approved</h5>
			                	@elseif($rec->admin == '0' && $rec->complete == '2')
			                		<h5 style="color: red">Declined</h5>
			                	@endif
			                </td>
			               {{--  @role(['purchase_superadmin']) --}}
			                <td>
			                	@if($rec->admin == '0')
				                	<a href="#"><button type="button" class="btn btn-success btn-sm" disabled="" style="color: white">Approve</button></a>
				                	&nbsp;&nbsp;
				                	<a href="#"><button type="button" class="btn btn-danger btn-sm" disabled="" style="color: white">Decline</button></a>
				                @else
				                	@if($rec->super_admin == '1' && $rec->complete == '1')
				                		<h5 style="color: green">Approved</h5>
				                	@elseif($rec->super_admin == '0' && $rec->complete == '2')
				                		<h5 style="color: red">Declined</h5>
				                	@else
					                	<a href="{{ route('super_admin_approve',[$rec->id]) }}"><button type="button" class="btn btn-success btn-sm" style="color: white">Approve</button></a>
					                	&nbsp;&nbsp;
					                	<a href="{{ route('decline_by_admins',[$rec->id]) }}"><button type="button" class="btn btn-danger btn-sm" style="color: white">Decline</button></a>
			                		@endif
			                	@endif
			                </td>
			              {{--   @endrole --}}
			             </tr>
			            @endforeach
			          </tbody>
			        </table>				
				  </div>


				  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			          <thead>
			            <tr>
			              <th>S.No</th>
			              <th>From</th>
			              <th>To</th>
			              <th>Date</th>
			              <th>View</th>
			              <th>Status</th>
			            </tr>
			          </thead>
			          <tbody>
			            @php $i=1; @endphp
		          		@foreach($all_rec as $allRec)
			             <tr>
			                <td>{{ $i++ }}</td>
			                <td>{{ $allRec->warehouse->name }}</td>
			                <td>{{ $allRec->site->job_describe }}</td>
			                <td>{{ $allRec->date }}</td>
			                <td>
			                	<a href="{{ route('see_chalan',[$allRec->id]) }}" class="glyphicon glyphicon glyphicon-barcode" title="Click to see Challan"><i class="fa fa-lg fa-barcode"></i></a>
			                	
			                	 &nbsp;&nbsp;&nbsp;
			                	 <!-- <a href="{{ route('site_item_req',[$rec->receiving_req_id]) }}"><i class="fa fa-lg fa-eye"></i></a> -->
			                </td>
			                <td>
			                	@if($allRec->complete == 0)
			                		<h5 style="color: yellow">Pending</h5>
			                	@elseif($allRec->complete == 1 && $allRec->super_admin == 0)
			                		<h5 style="color: cyan">Processing</h5>
			                	@elseif($allRec->complete == 1 && $allRec->super_admin == 1)
			                		<h5 style="color: green">Completed</h5>
			                	@else
			                		<h5 style="color: red">Declined</h5>
			                	@endif
			                </td>
			             </tr>
			            @endforeach
			          </tbody>
	        		</table>
				  </div>

				</div>
			</div>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$(document).on('click', '.generateDC', function(){
        //alert()
        var request_id = $(this).data('id')
        $.ajax({
            type: 'get',
            url: 'generate_dc',
            data: {'request_id': request_id},
            beforeSend: function() { 
                   $("#generateBtn_"+request_id).text(' Loading ...');
                   $("#generateBtn_"+request_id).attr('disabled',true);
                  // $("#generateOthersBtn_"+request_id).attr('disabled',true);
                   //$("#generateOthersBtn_"+request_id).attr('disabled',true);
                 },
            success: function(res){

              window.location.href = "receiving";
              
              
            }
          });
      });
});

</script>


@endsection