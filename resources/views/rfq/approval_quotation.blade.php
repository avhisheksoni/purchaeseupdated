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
	                <td>{{ $row->quotion_id }}</td>
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
	                	@if($row->level2_status == 1) 
	                		<span style=" color:green ; font-weight: bold">Approved</span>
	                	@elseif($row->level2_status == 2)
	                		<span style=" color:#ff9a00; font-weight: bold">Discard</span>
	                	@endif
	                </td>
	                <td>
	                	{{-- @if(!empty($po_status)) --}}
	                	<?php 
	                		$po_status = App\PO_SendToVendors::where('approval_quotation_id',$row->id)->get();
	                		if(count($po_status) > 0){
	                		foreach($po_status as $po){
	                		$qid = $po['approval_quotation_id'];
	                		if($qid == $row->id){
	                	?>
										<p class="btn btn-dark disabled">PO Sent</p>
	                	<?php
	                		} else{
	                	?>		
	                	<a class="btn btn-success" href="{{ route('approvalQuotation_item',$row->id) }}"><i class="fa fa-mail-forward"></i> Send PO</a>
										<?php 
	                		} } } else{
	                	?>
	                  <a class="btn btn-success" href="{{ route('approvalQuotation_item',$row->id) }}"><i class="fa fa-mail-forward"></i> Send PO</a>
	                  <?php } ?>
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