@extends('../layouts.sbadmin2')

@section('content')
<?php
	$user_id = request()->segment('2');
?>

<?php if($ready_to_dispatch == ''){ ?>
   
<div class="container-fluid">
  <a href="{{ '/user_request' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Select Items</h5>
  <div class="card shadow mt-3">
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('alert'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
            <div class="form-group col-md-6">
                <label>User Name</label>
                <input class="form-control" value="{{ $name }}" readonly="">
            </div>
            <div class="form-group col-md-6">
                <label>Email</label>
                <input class="form-control" value="{{ $email }}" readonly="">
            </div>

        	<div class="col-md-12 mt-2 mb-2">
        		<label>Select WareHouse</label>
        		@php 
        		$warehouse = App\Warehouse::all();
        		@endphp
	      		<select name="warehouse_id" class="form-control warehouseCLS" id="warehouse">
	      			<option value="0">Select</option>
	      			@foreach($warehouse as $wh)
		      			<option value="{{ $wh->id }}">{{ $wh->name }}</option>
		      		@endforeach
	      		</select>
	      	</div>
        </div>

	    <div class="row">
	      	<div class="col-md-12">
				<table class="table table-border" width="100%" id="userTable">
					<thead>
						<tr>
							<th>#</th>
                            <th>#Item Number</th>
							<th>#Name</th>
							<th>#R-Quantity</th>
                            <th>#S-Quantity</th>
							<th>#Description</th>
                            <th>#Availability</th>
                            <th>#Remove</th>
						</tr>
					</thead>
					<tbody id="purchBody">
                        <form action="{{ route('filter_dis_quo',$id)}}" method="post">
                             @csrf
						@php $i=1; @endphp
						@foreach($data as $res)
						<tr>
                        <td><input type="checkbox" name="chk[]" value="" class="form-control" readonly="" id="{{ "check".$i }}" ></td>
						 <td><input type="text" name="item_no[]" value="{{ $res->item_no }}" class="form-control item_no" readonly="" id="{{ "item_".$i }}"></td>
						 <td>{{ $res->item_name }}</td>
						 <td><input type="number" value="{{ $res->quantity }}" class="form-control" readonly=""></td>
                          <td><input type="number" name="squantity[]" value="{{ $res->quantity }}" class="form-control sqty" id="{{ "sqty".$i }}"></td>
						 <td>{{ $res->description }}</td>
             <?php if(strlen($res->item_no) != 8 ) { ?>
						 <td><input type="number" id="{{ "mgs".$i++ }}" class="form-control red" value="{{ App\Model\store_inventory\StoreItem::where('item_number','0'.$res->item_no)->get()->sum('quantity') }}" readonly=""></p></td>
             <?php }else{ ?>
                 <td><input type="number" id="{{ "mgs".$i++ }}" class="form-control red" value="{{ App\Model\store_inventory\StoreItem::where('item_number', $res->item_no)->get()->sum('quantity') }}" readonly=""></p></td>
             <?php } ?>
                          <td> <a class="btn btn-danger" href="{{ route('remove_reqitem',$res->id) }}" >Remove</a></td>
						</tr>
						 @endforeach
                         <input type="hidden" name="wahouse" value="" id="wahouse">
                        
					</tbody>
				</table>
			</div>
        </div>
        <div class="row">
            <div class="col-md-12">
              
                 <input class="btn btn-info" type="submit" value="Set Items" id="chkwar">
                        </form>

                
                  </form>
             
            </div>
        </div>
	  </div>
	</div>
</div>
<?php } else {
   echo "Ready for Dispatch Also unaviable item send for Purchase";

}
 ?> 


@endsection

<style type="text/css">
	.avail-item-msg{
		color: #ad3636;
    	margin-left: 10px;
    	font-size: 12px;
    	font-weight: bold;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
	$('document').ready(function(){
        $('#warehouse').on('change',function(){
            var wid = $(this).val();
            $(".sqty").val('');
            $("#wahouse").val(wid);
             var i = 0;
            $(".item_no").each( function(){
                var itemid = $(this).attr('id');
                itid = $('#'+itemid).val();
                count = itemid.split("_");
                mgs = "mgs"+count[1];
                //console.log(mgs);
            	$.ajax({
                 type: "GET",
                 url: "{{ route('up-rfi-le-one') }}",
                 data: {'itemid':itid,'mgs':mgs,'wid':wid},
                 success: function(res){
                    //console.log(res);
                    mm = res.split("||");
                    chk = mm[1].split('');
                    //console.log(chk[3]);
             $("#"+mm[1]).empty();
             $("#"+mm[1]).val(mm[0]);
             if(mm[0] == 0){
             $("#check"+chk[3]).hide();
               }else{
             $("#check"+chk[3]).show();
               }

                    }
                      });
            i++
            })

        });
        $(".sqty").on('blur',function(){
          var userreq = parseInt($(this).val());  
          var ssqty = $(this).attr('id');
           spl = ssqty.split('');
           wareqty =  parseInt($("#mgs"+spl[4]).val());
           // console.log(ssqty);
           // console.log(jQuery.type(userreq));
           if(wareqty >= userreq){
             true;
           }else{
            // alert("not-okk");
            $("#"+ssqty).val("");
           }

        });

        $('#approveit').on('click',function(){
          var pid = $('#impid').val();
          $.ajax({
                 type: "GET",
                 url: "{{ route('managr-apv') }}",
                 data: {'pid':pid},
                 success: function(res){
                   console.log(res);
                 }

             })


        });

        $('#chkwar').on('click',function(){
            var warid = $('#warehouse').val();
            //alert(warid);
            if( warid == "0" ){

               alert("Please select WareHouse before set item");
               return false;

            }else{

              return true;
            }
                 
        });

	})
</script>

