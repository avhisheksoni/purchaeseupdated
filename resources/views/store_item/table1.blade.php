@foreach($warehouse as $wh)
<?php
  if($wh->name == 'Indore'){
    $wareh_id = $wh->id;
    $wareh_name = $wh->name;
  }else{
    $wareh_id = $wh->id;
    $wareh_name = $wh->name;
  }
?>
<div id="{{ $wh->id }}" class="tabcontent">
  <table class="table table-bordered tbl-hide-cls table-item" id="dataTables{{ $wh->id }}" width="100%" cellspacing="0">
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
          $avail_qty = "";
          if(!empty($row->items_qty->quantity)){ 
            $qtys = json_decode($row->items_qty->quantity);
          }

          if(!empty($row->items_qty->warehouse_id)){
            $warehousess = json_decode($row->items_qty->warehouse_id);
            $count_warehouses = count($warehousess);
            for($i = 0; $i < $count_warehouses; $i++){
              if($wareh_id == $warehousess[$i]){
                $avail_qty = $qtys[$i];
        ?>
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $row->item_number }}</td>
          <td>{{ $row->title }}</td>
          <td>{{ ($row->hsn_code) ? $row->hsn_code : 'N/A' }}</td>
          <td>{{ $row->category->name }}</td>
          <td>{{ $row->brand_name->name }}</td>
          <td>{{ $avail_qty }}</td>
          <td>
            <a class="btn btn-success" href="#" title="Show" data-toggle="modal" data-target="#view_items00{{$row->id}}{{ $wareh_id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
            <!-- <a class="btn btn-primary" href="#" title="Edit" data-toggle="modal" data-target="#update_qty{{$row->id}}{{ $wareh_id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
          </td>
        </tr>
        <?php } } } ?>
        <!-- Modal -->
          <div class="modal fade" id="view_items00{{$row->id}}{{ $wareh_id }}" role="dialog">
            <div class="modal-dialog modal-lg">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><span style="font-weight: bold; color: red">{{ $row->item_number }}</span><span style="font-weight: bold; color: #000"> - {{ $row->title }} {{ (!empty($wareh_name)) ? '('.$wareh_name.')' : "" }}</span></h4>
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
                        <div class="form-group col-md-6">
                            <label>Unit</label>
                            <input type="text" class="form-control" value="{{ $row->unit->name }}" readonly="">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Available Quantity</label>
                            <input type="text" class="form-control" value='{{ $avail_qty }}' readonly="">
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

        <?php /*
        <!-- Modal -->
          <div class="modal fade" id="update_qty{{$row->id}}{{ $wareh_id }}" role="dialog">
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
                            <label>Select Warehouse</label>
                            <select name="warehouse_id" id="warehouse{{ $row->id }}" class="form-control">
                              <option disabled="" selected="">Select Warehouse</option>
                              @foreach($warehouse as $wh)
                                <option value="{{ $wh->id }}" @if(!empty($row->items_qty->store_warehouse->id)) @if($row->items_qty->store_warehouse->id == $wh->id) Selected @endif @endif>{{ $wh->name }}</option>
                              @endforeach
                            </select>
                            <div class="alertMsg1" style="color:red"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Enter Quantity</label>
                            <input type="text" class="form-control" name="quantity" id="quantity{{ $row->id }}" placeholder="Type Quantity..." value='{{ (!empty($row->items_qty->quantity)) ? $row->items_qty->quantity : "" }}'>
                            <div class="alertMsg" style="color:red"></div>
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
        <!-- Modal --> */ ?>

        @endforeach
      @endif
    </tbody>
  </table>
</div>
@endforeach