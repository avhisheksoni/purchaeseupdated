@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Received Quotation</h5>
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
				    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><b>RFI Send Quotations</b></a>
				  </li>
				  <li class="nav-item" style="width: 50%">
				    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>RFI Received Quotations</b></a>
				  </li>
				</ul>

				<div class="tab-content" id="myTabContent">
				  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		          <thead>
		            <tr>
		              <th>S.No</th>
		              <th>Quotation Id</th>
		              <th>Vendor's Count</th>
		              <th>Items Counts</th>
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody>
		          		<?php //dd($vendor); ?>
		          		@if (!empty($rfq))
			              @foreach ($rfq as $row)
			              <tr>
			                <td>{{ ++$i }}</td>
			                <td>{{ $row->quotion_id }}</td>
			                <td>
			                	{{ count(json_decode($row->email)) }}
			                	{{-- <select class="form-control">
			                		@foreach($vendor as $vndr)
														<option>{{ $vndr[0]->firm_name }}</option>
			                		@endforeach
			                	</select> --}}
			                </td>
			                <td>{{ count(json_decode($row->item_list)) }}</td>
			                <td>
			                  <a class="btn btn-success" href="{{ route('rfq.show',$row->id) }}" title="Sent Quotation"> <i class="fa fa-mail-forward"></i></a>
			                </td>
			              </tr>
			              @endforeach
			            @endif
		          </tbody>
		        </table>
		        {!! $rfq->links() !!}						
				  </div>


				  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		          <thead>
		            <tr>
		              <th>S.No</th>
		              <th>Quotation Id</th>
		              <th>Vendor's Count</th>
		              <th>Items Counts</th>
		              <!-- <th>Manager</th>
		              <th>Level 1</th>
		              <th>Level 2</th> -->
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody>
		          		
		          			<?php 
		          				if (!empty($data)){
				              	$n = 1;
				              	$arr = array();
				              	foreach ($data as $rows){
			              ?>
			              <tr>
			                <td>{{ $n++ }}</td>
			                <td>{{ $rows->quotation_id }}</td>
			               {{--  <td>
			                	{{ count(json_decode($rows['vendors_mail_items']->email)) }}
			                </td> --}}
			                {{-- <td>{{ count(json_decode($rows['vendors_mail_items']->item_list)) }}</td> --}}
			                <!-- <td>
			                	@if($rows->manager_status == 0)
			                		<span style=" color:#ff9a00 ; font-weight: bold">Pending</span>
			                	@elseif($rows->manager_status == 1) 
			                		<span style=" color:green ; font-weight: bold">Approved</span>
			                	@endif
			                </td>
			                <td>
			                												@if($rows->level1_status == 0) 
			                		<span style=" color:#ff9a00 ; font-weight: bold">Pending</span>
			                	@elseif($rows->level1_status == 1)
			                		<span style=" color:green; font-weight: bold">Approved</span>
			                	@elseif($rows->level1_status == 2)
			                		<span style=" color:red; font-weight: bold">Discard</span>
			                	@endif
			                </td>
			                <td>
			                	@if($rows->level2_status == 0) 
			                		<span style=" color:#ff9a00 ; font-weight: bold">Pending</span>
			                	@elseif($rows->level2_status == 1)
			                		<span style=" color:green ; font-weight: bold">Approved</span>
			                	@elseif($rows->level2_status == 2)
			                		<span style=" color:red; font-weight: bold">Discard</span>
			                	@endif
			                </td> -->
			                <td>
			                  <a class="btn btn-success" href="{{ route('receivedQuotation',$rows->rfi_id) }}" title="Received Quotation"><i class="fa fa-mail-reply"></i> </a>
			                </td>
			              </tr>
			              <?php } } ?>
		          </tbody>
		        </table>
		        {!! $rfq->links() !!}
				  </div>
				</div>
			</div>
    </div>
  </div>
</div>
@endsection