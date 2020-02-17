<?php //dd($details); die; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Real Programmer</title>
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
	    		<b>Dear <?php echo $details['vendor_data']->name; ?>,</b><br>
	        <p>We are glad to inform you that, your Quotation has been approved.</p> 
	      	<p>We request you to please accept our PO by <a href="{{ route('po_accepts',[$details['po_id'], $details['vendor_data']->id ] ) }}" target="blank">here</a> and we hope you deliver listed items in purchase order as soon as possible.</p>
	        <p>find attachment of items listing</p>
	        <strong>Thanks & Regards</strong><br>
	        <strong>Laxyo Energy Group</strong>
	    </div>
	</div>
</body>
</html>
