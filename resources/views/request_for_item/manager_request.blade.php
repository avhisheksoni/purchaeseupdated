@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Users RFI Listing</h5>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 mb-3">
          <a class="btn btn-danger float-right" href="{{ route('request_for_item.create') }}">+ ADD</a>
        </div>
      </div>
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <?php //dd($MailStatus[0]->id); die; ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        	<thead>
            <tr>
              <th>S.No</th>
              <th>Item Requirement</th>
              <th>Items</th>
              <th>Level 1 Status</th>
              <th>Level 2 Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          	@if (!empty($request_for_items))
            	@foreach($request_for_items as $row)
            	<tr id="bgclr{{$row->id}}">
                <td>{{ ++$i }}</td>
                <td>Users are generated new items request</td>
                <td>{{ count(json_decode($row->requested_data)) }}</td>
                <td>
									<center>
										<span style="@if($row->level1_status == 0) color:#ff9a00 @elseif($row->level1_status == 1) color:green @elseif($row->level1_status == 2) color:#ff0000 @endif; font-weight: bold">
											@if($row->level1_status == 0) Pending @elseif($row->level1_status == 1) Approve @elseif($row->level1_status == 2) Discard @endif
										</span>
									</center>
                </td>
                <td>
									<center>
										<span style="@if($row->level2_status == 0) color:#ff9a00 @elseif($row->level2_status == 1) color:green @elseif($row->level2_status == 2) color:#ff0000 @endif; font-weight: bold">
											@if($row->level2_status == 0) Pending @elseif($row->level2_status == 1) Approve @elseif($row->level2_status == 2) Discard @endif
										</span>
									</center>
                </td>
                <td>
                  <a class="btn btn-primary disbtn{{$row->id}}" href="{{ route('user_req_status', $row->id) }}"><i class="fa fa-eye"></i></a>
                  <!-- <a class="btn btn-primary disbtn{{$row->id}}" href="{{ route('check_rfi', $row->id) }}"><i class="fa fa-eye"></i></a> -->
                  @permission('purchase_manager_approval') 
                    @if($row->level2_status == 1)
                    <a class="btn btn-success disbtn{{$row->id}}" href="{{ route('applyforquotation', $row->id) }}" title="Apply for Quotation">Apply</a>
                    @endif
                  @endpermission
                </td>
              </tr>
              	<?php
	              	foreach($MailStatus as $key){
	              		if($key->quotion_sent_id == $row->id){
	              ?>
            		<style>
              		#bgclr{{$row->id}}{
              			background-color: #dcdab2;
              			opacity: 0.4;
              		}
              		.disbtn{{$row->id}}{
              			pointer-events:none;
              		}
								</style>
								<?php
								    }
								  }
							  ?>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $request_for_items->links()  !!}
      </div>
    </div>
  </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
