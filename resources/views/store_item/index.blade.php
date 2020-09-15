@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
div .help-inline{
  color:red;
}
input[type=checkbox].hidden{
  opacity: 0 ;
}
body {font-family: Arial;}
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}
/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}
/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}
/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}
/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.tabcontent1 {
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style> 
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <?php 
      $role_name = auth()->user()->hasRole('store_admin');
  ?>
  <h5 class="main-title-w3layouts mb-2">
    @if($role_name)
      Item Listing
    @else
      Warehouse items and quantity
    @endif
  </h5>
  <div class="card shadow mt-3">
    <div class="card-body">




      <div class="tab">
        <button class="tablinks active" onclick="openCity(event, 'All')">All</button>
        @if(!empty($warehouse))
          @foreach ($warehouse as $wh)
            <button class="tablinks" onclick="openCity(event, '{{ $wh->id }}')">{{ $wh->name }}</button>
          @endforeach
        @endif
      </div>




      <div class="table-responsive">
       	<div id="item-table">
       		@include('store_item.table')
       	</div>
		</div>
  </div>
</div>

<!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script> -->

<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  if(cityName !== "All"){
      document.getElementById("All").style.display = "none";
  }
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

<script>
@if(!empty($items))
  @foreach ($items as $row)

    /*@if(!empty($warehouse))
      @foreach ($warehouse as $wh)  
        $(document).ready(function () {
            var ckbox = $('#warehouse{{ $row->id }}{{ $wh->id }}');

            $('#warehouse{{ $row->id }}{{ $wh->id }}').on('click',function () {
                if (ckbox.is(':checked')) {
                    $('#quantity{{ $row->id }}{{ $wh->id }}').css("display", "block");
                } else {
                    $('#quantity{{ $row->id }}{{ $wh->id }}').css("display", "none");
                }
            });
        });
      @endforeach
    @endif*/

    $("#addForm{{ $row->id }}").validate({
      errorElement: 'div',
      errorClass: 'help-inline',
        
      rules: {
        warehouse_id:{
          required: true
        },
        quantity:{
          required:true
        }
      },
      
      messages: {
      },
      submitHandler: function(form) {
        //alert($('#addForm{{ $row->id }}').serialize());
        $.ajax({
          type: 'post',
          url: 'update_qty',
          data: $('#addForm{{ $row->id }}').serialize(),
          success: function(data) {
            // alert(data);
            alert("quantity Updated Successfully");
            location.reload();
          },
        });
      }
    });

  @endforeach
@endif
</script>
@endsection