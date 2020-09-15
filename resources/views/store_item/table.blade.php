<div id="All" class="tabcontent1"> 
 <table class="table table-bordered tbl-hide-cls table-item" id="dataTables" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Item Number</th>
      <th>Title</th>
      <th>HSN Code</th>
      <th>Category</th>
      <th>Subcategory</th>
      <th>Quantity</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="tbl-tbody">
    @if(!empty($items))
      @foreach ($items as $row)
      <?php
          $sum_qty = array();
          $count_qty = array();
          if(!empty($row->items_qty->quantity)){ 
            $qty = json_decode($row->items_qty->quantity);
            $count_qty = json_decode($row->items_qty->quantity);
            $sum_qty = array_sum($qty);
          }else{
            $qty = array();
          }
          $count = count($count_qty);
          if(!empty($row->items_qty->warehouse_id)){
            $warehouses = json_decode($row->items_qty->warehouse_id);
            $count_warehouses = json_decode($row->items_qty->warehouse_id);
          }
      ?>
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->item_number }}</td>
        <td>{{ $row->title }}</td>
        <td>{{ ($row->hsn_code) ? $row->hsn_code : 'N/A' }}</td>
        <td>{{ $row->category->name }}</td>
        <td>{{ $row->brand_name->name }}</td>
        <td>{{ (!empty($row->items_qty->quantity)) ? $sum_qty : "0" }}</td>
        <td>
          <a class="btn btn-success" href="#" title="Show" data-toggle="modal" data-target="#view_items{{$row->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
          @if($role_name == 'store_admin')
            <a class="btn btn-primary" href="#" title="Edit" data-toggle="modal" data-target="#update_qty{{$row->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
          @endif
        </td>
      </tr>

      <!-- Modal -->
        <div class="modal fade" id="view_items{{$row->id}}" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><span style="font-weight: bold; color: red">{{ $row->item_number }}</span><span style="font-weight: bold; color: #000"> - {{ $row->title }} {{ (!empty($row->items_qty->store_warehouse->name)) ? '('.$row->items_qty->store_warehouse->name.')' : "" }}</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form action="" method="">
                  <div class="row">
                      <div class="form-group col-md-6">
                          <label>HSN Code</label>
                          <input type="text" class="form-control" value="{{ $row->hsn_code }}" readonly="">
                      </div>
                      <div class="form-group col-md-6">
                          <label>Department</label>
                          <input type="text" class="form-control" value="{{ $row->department_name->name }}" readonly="">
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-md-6">
                          <label>Category</label>
                          <input type="text" class="form-control" value="{{ $row->category->name }}" readonly="">
                      </div>
                      <div class="form-group col-md-6">
                          <label>Subcategory</label>
                          <input type="text" class="form-control" value="{{ $row->brand_name->name }}" readonly="">
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-md-12">
                          <label>Unit</label>
                          <input type="text" class="form-control" value="{{ $row->unit->name }}" readonly="">
                      </div>
                      <!-- <div class="form-group col-md-6">
                          <label>Available Quantity</label>
                          <input type="text" class="form-control" value='{{ (!empty($row->items_qty->quantity)) ? $row->items_qty->quantity : "0" }}' readonly="">
                      </div> -->
                  </div>
                  <div class="row">
                      <div class="form-group col-md-12">
                        <label>Available Quantity</label>
                        <div class="col-md-12">
                          <div class="col-md-6 float-left" style="font-weight: bold">Warehouse</div>
                          <div class="col-md-6 float-right" style="font-weight: bold">Quantity</div>
                          @foreach($warehouse as $wh)
                            <?php 
                              for($i = 0; $i < $count; $i++){
                                if($wh->id == $warehouses[$i]){
                            ?>
                              <div class="col-md-6 float-left">{{ $wh->name }}</div>
                              <div class="col-md-6 float-right">{{ (!empty($qty)) ? $qty[$i] : "0" }}</div>
                            <?php } } ?>
                          @endforeach
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-md-12">
                          <label>Descriptions</label>
                          <textarea readonly="" class="form-control" rows="2">{{ $row->description }}</textarea>
                      </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <!-- Modal -->

      <!-- Modal -->
        <div class="modal fade" id="update_qty{{$row->id}}" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><span style="font-weight: bold; color: red">{{ $row->item_number }}</span><span style="font-weight: bold; color: #000"> - {{ $row->title }}</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form action="" method="" id="addForm{{$row->id}}">
                  @csrf   
                  <div class="row">
                      <div class="form-group col-md-12">
                        <label>Select Warehouse</label><br>
                        @foreach($warehouse as $wh)
                          <?php 
                            if($count !== 0){
                              for($i = 0; $i < $count; $i++){
                                if($wh->id == $warehouses[$i]){
                          ?>
                          <div class="row mt-3">
                            <div class="col-md-12">
                              <div class="col-md-6 float-left">
                                <input class="hidden" type="checkbox" name="warehouse_id[]" id="warehouse{{ $row->id }}{{ $wh->id }}" value="{{ $wh->id }}" checked="">{{ $wh->name }}
                              </div>
                              <div class="col-md-6 float-right">
                                <input type="text" class="form-control" name="quantity[]" id="quantity{{ $row->id }}{{ $wh->id }}" value='{{ (!empty($qty)) ? $qty[$i] : "0" }}' placeholder="{{ $wh->name }} warehouse qty">
                              </div>
                            </div>
                          </div>
                          <?php } } }else{ ?>
                          <div class="row mt-3">
                            <div class="col-md-12">
                              <div class="col-md-6 float-left">
                                <input class="hidden" type="checkbox" name="warehouse_id[]" id="warehouse{{ $row->id }}{{ $wh->id }}" value="{{ $wh->id }}" checked="">{{ $wh->name }}
                              </div>
                              <div class="col-md-6 float-right">
                                <input type="text" class="form-control" name="quantity[]" id="quantity{{ $row->id }}{{ $wh->id }}" placeholder="{{ $wh->name }} warehouse qty">
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                        @endforeach
                        <div class="alertMsg1" style="color:red"></div>
                        <input type="hidden" class="form-control" name="item_id" value="{{ $row->id }}">
                          <input type="hidden" class="form-control" name="item_number" value="{{ $row->item_number }}">
                      </div>
                  </div>
                  <button class="btn btn-primary float-right">Update</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <!-- Modal -->

      @endforeach
    @endif
  </tbody>
</table>
</div>


@include('store_item.table1')



<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $.noConflict();
    var table = $('#dataTables').DataTable();
    @foreach($warehouse as $wh)
      var table = $('#dataTables{{ $wh->id }}').DataTable();
    @endforeach
});
</script>