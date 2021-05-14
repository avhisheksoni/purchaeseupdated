@extends('../layouts.sbadmin2')
@section('content')
<!-- Begin Page Content -->

<div class="container-fluid">
    <div class="row col-md-12">
        <div class="col-md-8" style="background-color: white">
             <div id="register_wrapper" style="margin-top: 20px">
                <input type="hidden" name="employee_id" value="" id="employee_id">
                
                <a href="{{ route('manage_transfer') }}" id="transfer_manager" class="btn btn-sm btn-info pull-right" target="_blank" title="Transfer Manager">
                    Manage Transfer</a>
                    
            <br><br>

            <div class="panel-body form-group">
                
                @if(session()->has('receiving_session'))
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('receivings-session.destroy') }}" id="destroy_receivings"><span class="label label-primary" title="Click to Close Request"> {{ strtoupper(session()->get('receiving_request')['requested_to']->name) }} &nbsp; <i class="fa fa-1x fa-long-arrow-right" aria-hidden="true"></i>&nbsp; {{ strtoupper(session()->get('receiving_request')['requested_by']->name) }} &nbsp; <span style="color: white"><i class="fa fa-window-close" aria-hidden="true"></i></span></span></a>
                    </div>
                </div>
                @endif
            </div>
                                
            <div class="panel-body form-group">
              <form  id="mode_form" class="form-horizontal panel panel-default" accept-charset="utf-8">
                <div class="row col-md-12">
                  <div class="col-md-9">
                        <input type="text" name="barcode" value="" placeholder="Start typing Item Name or scan Barcode..." id="item" class="form-control input-sm ui-autocomplete-input" size="50" tabindex="1" autocomplete="off">

                        <input type="hidden" name="status" value="1">
                         <span class="ui-helper-hidden-accessible" role="status"></span>
                            <div id="itemList"></div>
                  </div>
                  <div class="col-md-3">
                        <p class="pull-left" style="font-weight:bold; font-size:1.2em">
                            Tot_Qty: <label class="total_qty" value=""></label>
                            <input type="hidden" name="total_qty" id="total_qty" value="total_qty">
                        </p>
                  </div>
                </div>
              </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="sales_table_100" id="register" style="background-color: #f2f2f2; width: 100%">
                        <thead>
                            <tr align="center">
                                <th style="width:10%;">Action</th>
                                <th style="width:20%;">Barcode</th>
                                <th style="width:45%;">Item Name</th>
                                <th style="width:15%;">Qty.</th>
                                <th style="width:10%;">Unit.</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td id="itemBody">
                                @include('receivings.itmes-display')
                              </td>
                           </tr>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
            <div id="overall_sale" class="panel panel-default" style="margin-top: 20px">
            	<div class="row">
                     <div class="col-md-12">
                     <label class="control-label">Destination Location</label>
                        <select name="destination" id="destination" class="form-control" >
                        @foreach($sites as $site)
                          @if(session()->has('receiving_session'))
                           <option value="{{$site->id}}" >{{$site->job_describe.' || '.$site->job_code}}</option>
                          @else
                          	<option value="{{$site->id}}">{{$site->job_describe.' || '.$site->job_code}}</option>
                          @endif
                       @endforeach
                        </select>
                     </div>
                </div>
            <div class="panel-body">
                <div id="finish_sale">
                    <form action="http://localhost/live_pos/public/receivings/requisition_complete" id="finish_receiving_form" class="form-horizontal" method="post" accept-charset="utf-8">
                        <div class="form-group form-group-sm">
                            <label id="comment_label" for="comment">Comments</label>
                            <textarea name="comment" cols="40" rows="6" id="comment" class="form-control input-sm"></textarea>
                            <br>
                            <a href="{{route('session_distroy')}}" class="btn btn-sm btn-danger pull-left" id="cancel_receiving_button"><span class="glyphicon glyphicon-remove">&nbsp;</span>Cancel</a>
                            
                            <input type="hidden" name="location_owner" value="7">

                            <div class="btn btn-sm btn-success pull-right" id="finish_receiving_button"><span class="glyphicon glyphicon-ok">&nbsp;</span>Finish</div>
                        </div>
                    </form>                         
                </div>
            </div>
        </div>
        </div>
       &nbsp;&nbsp;&nbsp;
        
    </div>
      <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
            <div class="modal-body" style="margin-left: 100px; margin-right: 50px;">
              <label>WEBKEY</label>
              <input type="text" name="modal_webkey" id="modal_webkey" value="">
                <input type="hidden" name="match_key" id="match_key" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" id="model_data">submit</button>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

  $(document).on('submit','#mode_form',function(event){
        event.preventDefault()
    })

  $(document).ready(function(){
    //alert(6546)

/*-----------------------------Quantity inc. dec. ----------------------------------*/
    var item_qty = 0;
    $('.qty_item').each(function() {
        item_qty = item_qty + parseInt(($(this).val()));

    });

    $('.total_qty').text(item_qty);

/*------------------------------Item search ----------------------------------------*/

    $('#item').on('keyup', function(e) {
        var query = $(this).val();
        if (e.keyCode == 13 || e.keyCode == 8 && query !='') {
        if (query != '') {
          var _token = $('input[name="_token"]').val();
            $.ajax({
              type: 'post',
              url: 'get_receiving_item',
              data: {'query':query, '_token':_token},
               
                success: function(data) {
                 //alert(query);

                    $('#itemList').fadeIn();
                    $('#itemList').html(data);
                }
            });
        } else {
            $('#itemList').fadeOut();
        }
     }
    });

/*--------------------------------- Select Item after Search---------------------------------------*/

    $(document).on('click', '#selectLI', function(e) {
        e.preventDefault()
        $('#item').val($(this).text());
        $('#itemList').fadeOut();
        var value   = $('#item').val();
        var res     = value.split("|");
        var item_number   = res[1];
        var _token = $('input[name="_token"]').val();
        if (item_number != '') {

            $.ajax({
                url: "receivings_item_save",
                method: "post",
                data:{'item_number':item_number,_token:_token,flag:'item_list_update'}  ,              
                success: function(data) {
                     // console.log(data)
                    // $('#itemBody').empty().html(data);
                   window.location.reload();
                }
            });
          
        }
    });

/*-------------------------------Delete Selected Items -------------------------------------*/

    $('.deleteItem').on('click', function(e) {
        var item_id   = $(this).val();
        var _token = $('input[name="_token"]').val();
        alert(item_id);
        $.ajax({
          url: "remove_entry_session",
          method: "post",
          data:{'item_id':item_id,_token:_token}  ,              
          success: function(data) {
             window.location.reload();
          }
      });
    });

/*-------------------------------Selected Item Qty Inc. Dec. --------------------------------------*/

    $(document).on('keyup','.qty_item',function(e){
        var item_id = $(this).data('id');
        var qty = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "receivings_item_save",
            method: "post",
            data:{item_id:item_id,qty:qty,_token:_token,flag:'item_quntity_update'},              
            success: function(data) {
               window.location.reload();
            }
        });
    })

/*-------------------------------Finish Transfer---------------------------------------*/
  
   $('#finish_receiving_button').on('click',function(){

            if(window.confirm("Are you sure?")) {
            var comment         = $('#comment').val();
            var destination_id  = $('select[name="destination"]').val();
            var total_qty       = item_qty;
            //alert(total_qty);
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "save_receiving_items",
                method: "POST",
                data: {
                    comment: comment,
                    destination_id: destination_id,
                    total_qty: total_qty,
                    _token: _token
                },
                beforeSend: function() { 
                   $("#finish_receiving_button").text(' Loading ...');
                   $("#finish_receiving_button").attr('disabled',true);
                 },
                success: function(data) {
                	console.log(data);
                	var lastId = data;
                   	window.location.href = "/receiving_chalan/"+lastId;
                	/*$.ajax({
		                url: "receiving_chalan",
		                method: "post",
		                data: {
		                    lastId: lastId
		                },
		                success: function(data) {
		                }
		            });*/
                }
            });

            }
    });

/*-------------------------------------------------------------------------------------------*/
  
  });
</script>

 <!-- <script>
      $(document).ready(function(){
       
       alert("re4te4");

      })
      
  </script> -->
@endsection