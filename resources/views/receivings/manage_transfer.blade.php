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
				  <li class="nav-item" style="width: 20%">
				    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><b>Stock In</b></a>
				  </li>
				  <li class="nav-item" style="width: 40%">
				    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>Transfer Log</b></a>
				  </li>
				   <li class="nav-item" style="width: 40%">
				    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#newsf" role="tab" aria-controls="profile" aria-selected="false"><b>Receiving Request Log</b></a>
				  </li>
				</ul>

				<div class="tab-content" id="myTabContent">
				  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		          <thead>
		            <tr>
		              <th>S.No</th>
		              <th>Item</th>
		              <th>quantity</th>
		              <th>price</th>
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody>
			              <tr>
			                <td>ret</td>
			                <td>ree</td>
			                <td>
			                	44
			                </td>
			                <td>stock</td>
			                <td>
			                  <a class="btn btn-success" href="" title="Sent Quotation"> <i class="fa fa-mail-forward"></i></a>
			                </td>
			              </tr>
		          </tbody>
		        </table>				
				  </div>


				  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		          <thead>
		            <tr>
		              <th>S.No</th>
		              <th>item</th>
		              <th>quantity</th>
		              <th>out</th>
		              <!-- <th>Manager</th>
		              <th>Level 1</th>
		              <th>Level 2</th> -->
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody>
		          		
		          			
			            <tr>
			                <td>ret</td>
			                <td>ree</td>
			                <td>
			                	452
			                </td>
			                <td>Tenasfer Log</td>
			                <td>
			                  <a class="btn btn-success" href="" title="Sent Quotation"> <i class="fa fa-mail-forward"></i></a>
			                </td>
			              </tr>
			             
		          </tbody>
		        </table>
		     
				  </div>

				  <div class="tab-pane fade" id="newsf" role="tabpanel" aria-labelledby="profile-tab">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		          <thead>
		            <tr>
		              <th>S.No</th>
		              <th>From</th>
		              <th>To</th>
		              <th>Date</th>
		              <th>View</th>
		              <th>Action</th>
		              <th>Status</th>
		            </tr>
		          </thead>
		          <tbody>
		          		@php $i=1; @endphp
		          			@foreach($recreq as $rec)
			             <tr>
			                <td>{{ $i++ }}</td>
			                <td>{{ $rec->sitename->job_describe }}</td>
			                <td>{{ $rec->warename->name }}</td>
			                <td>{{ $rec->created_at }}</td>
			                <td> <a href="{{ route('site_item_req',[$rec->id]) }}"><button class="btn btn-warning btn-sm"><i class="fa fa-lg fa-eye"></i></button></a></td>
			                <td>
			                	<button type="button" class="btn btn-success btn-sm generateDC" id="generateBtn_{{ $rec->id }}" data-id="{{ $rec->id }}"> Generate DC </button>
			                	
			                	<button class="btn btn-danger btn-sm">Decline</button>
			                </td>
			                <td>Receiving Log</td>
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

              //window.location.href = "receivings";
              
              
            }
          });
      });
});

</script>


@endsection