@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <!-- <a href="{{ '/request_for_item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a> -->
    <h5 class="main-title-w3layouts mb-2">Create RFI</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                </div>
            @endif
						
            <form action="{{ route('upwareqty') }}" method="post">
                @csrf
								<table id="invoice-item-table" class="table">
			            <tr>
			              <th>Item Name</th>
			              <th>Quantity Add</th>
			              <th></th>
			            </tr>
			            <tr>
			              <td>
			              	<input type="text" name="item_name" id="item_name1" value="{{ $itemname }}" class="form-control input-sm" />
                      <input type="hidden" name="item_number" id="itemno" value="{{ $getno }}" class="form-control input-sm" />
                      <input type="hidden" name="ids" id="itemno" value="{{ $ids }}" class="form-control input-sm" />
			              </td>
			              <td>
                      <div class="row">
                        <div class="col-md-8">
    			              	<input type="text" name="sum" value="{{ $qtyofitem }}" id="quantity"  class="form-control input-sm" readonly="" />
                          <input type="hidden" name="quantity" value="{{ $sum }}" id="itemsum"  class="form-control input-sm" />
                        </div>

                        <div class="col-md-4">
                        	@php 
                        	$ware = App\Warehouse::all();
                        	@endphp 
                          <select name="warehouse_id" {{-- <?php if($sum == '') { echo '';  } else { echo "id= 'wareid'" ;} ?> --}} id= "wareid" data-srno="1" class="form-control input-sm unit" >
                          	<option value="">Choose</option>
                          @foreach($ware as $wah)
                          	<option value="{{ $wah->id }}">{{ $wah->name }}</option>
                          	@endforeach()
                          </select>
                        </div>
                      </div>
			              </td>
			             <div id="mgs"></div>
			              <td></td>
			            </tr>
			          </table>
                @php $itemstore = App\Model\store_inventory\StoreItem::where('item_number',$getno)->get(); @endphp
               @if(count($itemstore) == 0)
                <button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4" onclick="return confirm('Are you sure you want to submit this from?');">Submit</button>
                @else
                <button type="submit" name="submit" class="btn btn-primary error-w3l-btn px-4" disabled="">Stored in Store</button>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

<style type="text/css">
  .items-dropdown{
    height: 250px !important;
    overflow-x: hidden !important;
    background: #dadada !important;
    width: 100% !important;
  }
  .items-dropdown > li{
    padding: 5px !important;
    border-bottom: 1px solid #8c4949 !important;
  }
</style>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $("#wareid").on('change',function(){
     var warid = $(this).val();
    // alert("ereye");
     var itno = $('#itemno').val();
     var qty = $('#quantity').val();

      $.ajax({
                  url: "{{  route('get-ware-details')}}",
                type: 'GET',
                data: {'ware_id':warid,'it_no':itno,'qty':qty},
                 success: function(res){
                   console.log(res);
                   $("#itemsum").empty();
                   $("#itemsum").val(res.add);
                   $("#mgs").html(res.mgs);
                   $("#mgs").css({"color": "Red","font-size": "100%"});
                    }
                      });
  });
});
</script>
