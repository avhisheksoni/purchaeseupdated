<?php
		$po_id = request()->segment(2);
		$vendor_id = request()->segment(3);
		$PO_status = App\PO_SendToVendors::where('id', $po_id)->where('vendor_id', $vendor_id)->get();
		$status = $PO_status[0]->po_accept_status;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
		.hover_bkgr_fricc{
		    background:rgba(0,0,0,.4);
		    cursor:pointer;
		    height:100%;
		    position:fixed;
		    text-align:center;
		    top:0;
		    width:100%;
		    z-index:10000;
		}
		.hover_bkgr_fricc > div {
		    background-color: #fff;
		    box-shadow: 10px 10px 60px #555;
		    display: inline-block;
		    height: auto;
		    max-width: 551px;
		    min-height: 100px;
		    vertical-align: middle;
		    width: 60%;
		    position: relative;
		    border-radius: 8px;
		    padding: 15px 5%;
  			margin-top:35px; 
		}
    </style>
</head>
<body>
    <div class="hover_bkgr_fricc">
	    <div>
	    		@if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
	        @endif
	    		<p>If you are agree with our requirement, then we request you to accept our Purchase Order (P.O.)</p><br><br>
	    		
	    		<form action="{{ route('po_accepts_data', [$po_id, $vendor_id]) }}" method="post" style="margin-bottom: 50px">
         		@csrf
						<div class="row" style="margin-bottom: 20px">
                <label class="radio-inline">
						      <input type="radio" name="po_accept_status" value="1" @if($status == 1) checked @endif>Accept
						    </label>
						    <label class="radio-inline">
						      <input type="radio" name="po_accept_status" value="2" @if($status == 2) checked @endif>Decline
						    </label>
            </div>
            @if ($errors->any())
	            <div class="alert alert-danger">
	                @foreach ($errors->all() as $error)
	                  <p>Fields are required</p>
	                @endforeach
	            </div>
	          @endif
            <input type="hidden" name="po_id" value="{{ $po_id }}">
            <input type="hidden" name="vendor_id" value="{{ $vendor_id }}">
            @if(!$status)
            	<button type="submit" name="submit" class="btn btn-primary error-w3l-btn mt-sm-5 mt-3 px-4">Submit</button>
            @else
            	<h4 style="color: green; margin-top: 50px">Thank You for your responce</h4>
            @endif
          </form>
	        <strong>Thanks & Regards</strong><br>
	        <strong>Laxyo Energy Group</strong>
	    </div>
	</div>
</body>
</html>