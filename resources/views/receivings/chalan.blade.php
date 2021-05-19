<!DOCTYPE html>
<html lang="en">
<head>
  <title>YOLAX INFRAENERGY</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="col-md-1 pull-left">
		  <a href="{{ route('back') }}" ><div class="btn btn-info btn-sm"><span class="glyphicon glyphicon-print">&nbsp;</span>Back</div></a>
		  <!-- <a href="#" ><div class="btn btn-info btn-sm" id="show_list_button"><span class="glyphicon glyphicon-print">&nbsp;</span>Show Item List</div></a> -->
		</div>&nbsp;
		</div>
		<div class="col-md-3">
		    <select class="pull-right">
			    <option value=""></option>
			    <option value="">ACCOUNTS COPY</option>
			    <option value="">PDI(Security) COPY</option>
			    <option value="">STORE COPY</option>
			    <option value="">DRIVER COPY</option>
		    </select>
		</div>
		<div class="col-md-1">
		  <a href="javascript:void(0);" onclick="window.print()"><div class="btn btn-info btn-sm" ,="" id="show_print_button"><span class="glyphicon glyphicon-print">&nbsp;</span>Print</div></a>
		  <!-- <a href="#" ><div class="btn btn-info btn-sm" id="show_list_button"><span class="glyphicon glyphicon-print">&nbsp;</span>Show Item List</div></a> -->
		</div>&nbsp;
		
	</div>
	<div class="row">
		<div class="container">
			
			<div class="row">
			    <span class="col-md-4">
			      <!-- <img id="image" src="http://localhost/live_pos/public/images/laxyo.png" alt="company_logo" width="160" height="60"> -->
			    </span>
			    <span class="col-md-8 pull-right">
			      {{-- <p>Laxyo House, Plot No. 2, County park, MR-5, Mahalaxmi Nagar, Indore-10 (MP)</p> --}}
			      <p>{{$rec_chalan->warehouse->description}}</p>
			      <p>Phone: +91-731-4043798, Mobile: 8815218210</p>
			    </span>
			</div>
		  	<div class="row">
			    <div class="col-md-12" style="font-size:1.5em; text-align:center">
			      <p>CHALLAN &nbsp;(NOT FOR SALE)</p>
			      <p>LAXYO ENERGY LTD. - GSTIN - 23AABCL3031E1Z9</p>
			    </div>
		  
			    <div class="col-md-12">
			      <table class="table table-bordered table-condensed small">
			        <thead>
			          <tr>
			            <th>CHALLAN NO.</th>
			            <th>STOCK TRANSFER ORDER NO.</th>
			            <th>CONSIGNOR (from)</th>
			            <th>CONSIGNEE (to)</th>
			            <th>PICKED BY</th>
			            <th>DISPATCH THROUGH</th>
			            <th>DATE</th>
			          </tr>
			        </thead>
			        <tbody>
			          <tr>
			            <td>{{$rec_chalan->id}}</td>
			            <td></td>
			            <td>{{$rec_chalan['warehouse']->name}}</td>
			            <td>{{$rec_chalan['site']->job_describe}}</td>
			            <td><input style="border:none;" value="" type="text"></td>
			            <td><input style="border:none;" value="MP.43.C.1596" type="text"></td>
			            <td>{{$rec_chalan->date}}</td>
			          </tr>
			        </tbody>
			      </table>  

			      <table class="table table-bordered table-condensed small">
			        <thead>
			          <tr>
			            <th>Sn.</th>
			            <th>Barcode</th>
			            <th colspan="2">Name of goods</th>
			            <th colspan="2">Quantity</th>
			            <th>Unit</th>
			          </tr>
			        </thead>
			        <tbody>
			        	@php $count =1; @endphp
			           @foreach($chalan_item as $value)
			           
			            <tr>
			              	<td>{{$count++}}</td>
			              	<td>{{$value['item']->item_number}}</td>
			              	<td colspan="2">{{$value->item->title}}</td>
			              	<td colspan="2">{{$value->qty}}</td>
			              	<td>{{$value->unit}}</td>
			            </tr>
			            @endforeach
			            <tr>
			              <td><b>Total Quantity</b></td>
			              <td colspan="4"></td>
			              <td>{{$rec_chalan->total_quantity}}</td>
			              <td></td>
			            </tr>
			            <tr>
			              <td><b>Comment</b></td>
			              <td colspan="6">{{$rec_chalan->remark}}</td>
			            </tr>
			            <tr>
			              <td colspan="7"><br></td>
			            </tr>
			            
			        </tbody>
			      </table>

			      <table class="table table-bordered">
			        <thead>
			          <tr class="text-center">
			            <th>PREPARED BY- ACCOUNTS</th>
			            <th>CHECKED BY- PDI(Security)</th>
			            <th>VERIFIED BY- STORE</th>
			            <th>TRANSPORTED BY- DRIVER</th>
			          </tr>
			        </thead>
			        <tbody>
			          <tr>
			            <td><br><!-- <img id="image" style="position:absolute; bottom:-10px; transform: rotate(-18deg)" src="http://localhost/live_pos/public/images/lel_stamp.png" alt="company_stamp" width="90" height="90"> --></td>
			            <td></td>
			            <td></td>
			            <td></td>
			          </tr>
			        </tbody>
			      </table>
			    </div>

			    <div class="col-md-12">
			      <p class="text-center small">(BEING THE GOODS TRANSFER FROM WAREHOUSE TO SHOP/SHOP TO WAREHOUSE HENCE NO COMMERCIAL VALUE)</p><br><br> 
			    </div>
		  	</div>
	</div>
</div>
</div>
</body>
</html>


<!-- <script>
	$(document).on('click','#show_list_button',function(){
		$.ajax({
			method:'post',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url:'',
			success:function(data){
				$('#item_table').html(data)
				$('#itemrack').modal('show');

			}
		})
	})


</script>
 -->

