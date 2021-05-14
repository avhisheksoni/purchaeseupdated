<?php
		$vendor_id = request()->segment(3);
		$data = \App\vendor::find($vendor_id);
		$itemsList = request()->segment(2);
		$list = \App\VendorsMailSend::find($itemsList);
		$RFQ_id = $list->quotion_sent_id;
		$items = json_decode($list->item_list);

		$QId = '#RFQ'.str_pad($RFQ_id, 4, '0', STR_PAD_LEFT);
		$status = \App\QuotationReceived::where('quotion_id',$QId)->where('quotion_sends_id',$itemsList)->where('vender_id',$vendor_id)->get();
		//dd($status); 
		if(count($status)>0){			
				echo "<script src='/themes/sb-admin2/vendor/jquery/jquery.min.js'></script>
				<script> 
						$(window).on('load',function(){
				        $('#myModal').modal({backdrop: 'static', keyboard: false});
				    });
		    </script>";
		}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin 2 - Dashboard</title>
  <!-- Custom fonts for this template-->
  <link href="/themes/sb-admin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <!-- Custom styles for this template-->
  <link href="/themes/sb-admin2/css/sb-admin-2.min.css" rel="stylesheet">
  <style type="text/css">
  	#myTable, #invoice-item-table{
  		color: #000 !important;
  	}
  </style>
</head>

<body id="page-top">

<div id="myModal" class="modal hide fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body text-center" style="color:#000">
        <h3>Thank You</h3>
        <p>for your quotation,<br> we will get back to you soon</p>
      </div>
    </div>
  </div>
</div>


  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <div class="container-fluid">
        	<div class="card shadow mb-4">
        		<div class="card-body">
							<div class="table-responsive">
								@if ($errors->any())
						        <div class="alert alert-danger">
						            <strong>Warning!</strong> Please check your input code<br><br>
						            <ul>
						                @foreach ($errors->all() as $error)
						                    <li>{{ $error }}</li>
						                @endforeach
						            </ul>
						        </div>
						    @endif
								<form action="{{ route('vendorformstore',[$itemsList, $vendor_id]) }}" method="post" enctype="multipart/form-data">
						    @csrf
							  <table class="table table-bordered" id="myTable">
							    <tr>
							      <td colspan="2" align="center"><h2 style="margin-top:10.5px">Add Quotation</h2></td>
							    </tr>
							    <tr>
							        <td colspan="2">
							        	<table width="100%" cellpadding="5">
										      <tr>
										        <td width="65%">
										         From,<br />
										         <b>{{ $data->firm_name }}</b><br />
										         Name : {{ $data->name }}<br /> 
										         Email Address : {{ $data->email }}<br />
										         Contact No. : {{ $data->mobile }} {{ (!empty($data->alt_number)) ? ', '.$data->alt_number : '' }}  <br />
										        </td>
										        <td width="35%">
										         Register No. : {{ $data->register_number }} <br />
										         GST No. : {{ $data->gst_number }}<br />
										         Quotation Date : {{ date('Y-m-d h:i:s') }}<br />
										        </td>
										      </tr>
										    </table>
							          <br />
							          <table id="invoice-item-table" class="table table-bordered">
							            <tr>
							              <th width="4%">S.No</th>
							              <th width="20%">Item Name</th>
							              <th width="10%">Quantity</th>
							              <th width="10%">Price</th>
							              <th width="10%">Actual Amt.(Rs)</th>
							              <th width="22.5%" colspan="2">Tax</th>
							              <th width="12.5%" rowspan="2">Total (Rs)</th>
							            </tr>
							            <tr>
							              <th></th>
							              <th></th>
							              <th></th>
							              <th></th>
							              <th></th>
							              <th>Rate (%)</th>
							              <th>Amt.(Rs)</th>
							            </tr>

							            <?php 

								            $m = 0; 
                            $itemnew =  App\prch_itemwise_requs::where('prch_rfi_users_id',$pidnew)->where('ready_to_dispatch','<>',1)->get();
                              //dd($itemnew);
								            foreach($itemnew as $row){
								            	$m = $m + 1;
							            ?>
							            <tr>
							              <td><span id="sr_no">{{$m}}</span></td>
							              <td><input type="text" name="item_name[]" id="item_name{{$m}}" value="{{ $row->item_name }}" readonly="" class="form-control input-sm" /></td>
							              <td><input type="number" name="item_quantity[]" id="order_item_quantity{{$m}}" data-srno="{{$m}}" class="form-control input-sm order_item_quantity" value="{{ $row->quantity }}" readonly="" /></td>
							              <td><input type="text" name="item_price[]" id="order_item_price{{$m}}" data-srno="{{$m}}" class="form-control input-sm number_only order_item_price" /></td>
							              <td><input type="text" name="item_actual_amount[]" id="order_item_actual_amount{{$m}}" data-srno="{{$m}}" class="form-control input-sm order_item_actual_amount" readonly /></td>
							              <td><input type="text" name="item_tax1_rate[]" id="order_item_tax1_rate{{$m}}" data-srno="{{$m}}" class="form-control input-sm number_only order_item_tax1_rate" /></td>
							              <td><input type="text" name="item_tax1_amount[]" id="order_item_tax1_amount{{$m}}" data-srno="{{$m}}" readonly class="form-control input-sm order_item_tax1_amount" /></td>
							              <td><input type="text" name="item_total_amount[]" id="order_item_final_amount{{$m}}" data-srno="{{$m}}" readonly class="form-control input-sm order_item_final_amount" /></td>
                              <td><input type="hidden" name="item_no[]" id="item_no{{$m}}" data-srno="{{$m}}" value="{{ $row->item_no }}" readonly class="form-control input-sm item_no" /></td>
							            </tr>
							            <?php } ?>
							          </table>
							        </td>
							      </tr>
							      <tr>
							        <td align="right"><b>Total</b></td>
							        <td align="right">
							        	<b>Rs. <span id="final_total_amt">0</span></b>
							        	<input type="hidden" name="item_final_amount" id="item_final_amount" />
							      	</td>
							      </tr>
							      <tr>
							        <td colspan="2"></td>
							      </tr>
							      <tr>
							        <td colspan="2">
							        	<textarea id="editor" name="terms" class="form-control input-sm"></textarea>
							        </td>
							      </tr>
							      <tr>
							        <td colspan="2" align="center">
							          <input type="hidden" name="quotion_id" id="quotion_id" value="{{ $QId }}" />
							          <input type="hidden" name="rfi_id" id="quotion_id" value="{{ $RFQ_id }}" />
							          <input type="hidden" name="quotion_sends_id" id="quotion_sends_id" value="{{ $list->id }}" />
							          <input type="hidden" name="vender_id" id="vender_id" value="{{ $vendor_id }}" />
							          <button type="submit" name="submit" id="create_invoice" class="btn btn-info">Submit Quotation</button>
							        </td>
							      </tr>
							  </table>
							  </form>
							</div>
						</div>
					</div>
			</div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      @include('includes._sbadmin2.footer')

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="/themes/sb-admin2/vendor/jquery/jquery.min.js"></script>
  <script src="/themes/sb-admin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/themes/sb-admin2/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/themes/sb-admin2/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="/themes/sb-admin2/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="/themes/sb-admin2/js/demo/chart-area-demo.js"></script>
  <script src="/themes/sb-admin2/js/demo/chart-pie-demo.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>

{{-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script> --}}
<script>
    ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
        console.error( error );
    } );
</script>
<script>
$(document).ready(function(){
  var final_total_amt = $('#final_total_amt').text();
  var count = "<?php echo $m; ?>";

  function cal_final_total(count)
  {
    var final_item_total = 0;
    for(j=1; j<=count; j++)
    {
      var quantity = 0;
      var price = 0;
      var actual_amount = 0;
      var tax1_rate = 0;
      var tax1_amount = 0;
      var tax2_rate = 0;
      var tax2_amount = 0;
      var tax3_rate = 0;
      var tax3_amount = 0;
      var item_total = 0;
      quantity = $('#order_item_quantity'+j).val();
      if(quantity > 0)
      {
        price = $('#order_item_price'+j).val();
        if(price > 0)
        {
          actual_amount = parseFloat(quantity) * parseFloat(price);
          $('#order_item_actual_amount'+j).val(actual_amount);
          tax1_rate = $('#order_item_tax1_rate'+j).val();
          if(tax1_rate > 0)
          {
            tax1_amount = parseFloat(actual_amount)*parseFloat(tax1_rate)/100;
            $('#order_item_tax1_amount'+j).val(tax1_amount);
          }
          tax2_rate = $('#order_item_tax2_rate'+j).val();
          if(tax2_rate > 0)
          {
            tax2_amount = parseFloat(actual_amount)*parseFloat(tax2_rate)/100;
            $('#order_item_tax2_amount'+j).val(tax2_amount);
          }
          tax3_rate = $('#order_item_tax3_rate'+j).val();
          if(tax3_rate > 0)
          {
            tax3_amount = parseFloat(actual_amount)*parseFloat(tax3_rate)/100;
            $('#order_item_tax3_amount'+j).val(tax3_amount);
          }
          item_total = parseFloat(actual_amount) + parseFloat(tax1_amount) + parseFloat(tax2_amount) + parseFloat(tax3_amount);
          final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
          $('#order_item_final_amount'+j).val(item_total);
        }
      }
    }
    $('#final_total_amt').text(final_item_total);
    $('#item_final_amount').val(final_item_total);
  }

  $(document).on('blur', '.order_item_price', function(){
    cal_final_total(count);
  });

  $(document).on('blur', '.order_item_tax1_rate', function(){
    cal_final_total(count);
  });

  $(document).on('blur', '.order_item_tax2_rate', function(){
    cal_final_total(count);
  });

  $(document).on('blur', '.order_item_tax3_rate', function(){
    cal_final_total(count);
  });

});
</script>

</body>

</html>