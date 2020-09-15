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
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Quotation Id</th>
              <th>Vendor's Firm Name</th>
              <th>Items Counts</th>
              <th>Manager</th>
              <th>Level 1</th>
              <th>Level 2</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          		@if (!empty($data))
	              @foreach($data as $row)
	              <tr>
	                <td>{{ ++$i }}</td>
	                <td>{{ $row->quotation_id }}</td>
	                <td>{{ $row->firm_name }}</td>
	                <td>{{ count(json_decode($row->item_list)) }}</td>
	                <td>
	                	@if($row->manager_status == 1) 
	                		<span style=" color:green ; font-weight: bold">Approved</span>
	                	@endif
	                </td>
	                <td>
										@if($row->level1_status == 1) 
	                		<span style=" color:green ; font-weight: bold">Approved</span>
	                	@endif
	                </td>
	                <td>
	                	@if($row->level2_status == 0) 
	                		<span style=" color:#ff9a00 ; font-weight: bold">Pending</span>
	                	@elseif($row->level2_status == 1) 
	                		<span style=" color:green ; font-weight: bold">Approved</span>
	                	@elseif($row->level2_status == 2)
	                		<span style=" color:red; font-weight: bold">Discard</span>
	                	@endif
	                </td>
	                <td>
	                  <a class="btn btn-success" href="{{ route('qa_level_two',$row->rfi_id) }}"><i class="fa fa-mail-reply"></i> Received</a>
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