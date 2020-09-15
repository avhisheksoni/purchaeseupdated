 <table class="table table-bordered tbl-hide-cls table-item" id="dataTables" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Item Number</th>
              <th>Title</th>
              <th>HSN Code</th>
              <th>Category</th>
              <th>Subcategory</th>
              <th>Department</th>
              <th>Unit</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="tbl-tbody">
            @if (!empty($items))
              @foreach ($items as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->item_number }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ ($row->hsn_code) ? $row->hsn_code : 'N/A' }}</td>
                <td>{{ $row->category->name }}</td>
                <td>{{ $row->brand_name->name }}</td>
                <td>{{ $row->department_name->name }}</td>
                <td>{{ $row->unit->name }}</td>               	
                <td>
                  <form action="{{ route('item.destroy',$row->id) }}" method="POST">
                    <a class="btn btn-success" href="{{ route('item.show',$row->id) }}" title="Show"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" href="{{ route('item.edit',$row->id) }}" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
 <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $.noConflict();
    var table = $('#dataTables').DataTable();
});
</script>