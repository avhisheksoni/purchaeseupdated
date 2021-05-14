@extends('../layouts.sbadmin2')
@section('content')
<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Item Listing</h5>
  <div class="card shadow mt-3">
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <form id="addForm">
          @csrf
	        <div class="row">
	          <div class="form-group col-md-2"></div>
	          <div class="form-group col-md-3">
	              <select class="form-control" name="category" id="category">
	                <option selected="" disabled="" value="0">Filter By Category</option>
	                @foreach($category as $cat)
	                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
	                @endforeach
	              </select>    
	          </div>
	          <div class="form-group col-md-3">
	              <select class="form-control" name="department" id="department">
	                <option selected="" disabled="" value="0">Filter By Department</option>
	                @foreach($department as $dept)
	                  <option value="{{ $dept->id }}">{{ $dept->name }}</option>
	                @endforeach
	              </select>    
	          </div>
	          <div class="form-group col-md-4">
	            <button type="submit" name="submit" id="addUnit" class="btn btn-primary">Filter</button>
	            <button type="button" name="reset" id="reset" class="btn btn-dark">Reset</button>
	            <a class="float-right" href="{{ route('export_pdf') }}" title="PDF Download"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 22px"></i></a>
	            <a class="float-right" href="{{ route('excel_export') }}" title="Excel Download"><i class="fa fa-file-excel-o" aria-hidden="true" style="font-size: 22px; margin-right: 12px"></i></a>	           
	          </div>
	        </div>
        </form>
        <br>
       	<div id="item-table">
       		@include('item.table')
       	</div>
		</div>
  </div>
</div>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
	$("#addForm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      type: 'post',
      url: '{{ route("filter") }}',
      data: $('#addForm').serialize(),
      success: function(data) {
      	$('#item-table').empty().html(data);
      	$('.table-item').DataTable();
      },
    });
  });
});

$(document).ready(function(){
  $("#reset").click(function(){
    location.reload(true);
  });
});
</script>
@endsection