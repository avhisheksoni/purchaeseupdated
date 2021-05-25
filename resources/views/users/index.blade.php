@extends('../layouts.sbadmin2')
@section('content')
<!-- Begin Page Content -->

<div class="container-fluid">
    <div class="row col-md-12">
      <div class="col-md-12">
        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">
         Allote site wise user
        </button>
      </div>&nbsp;&nbsp;&nbsp;
       @if($message = Session::get('message'))
      <div class="alert alert-success">  {{$message}}
      </div>
      @endif 
      <div class="col-md-12">
        <table class="sales_table_100 border" id="customers" style="background-color: #e6e6e6; width: 100%;">
          <thead>
            <tr>
              <th style="width:20%;">Acc. User Name</th>
              <th style="width:20%;">Allotted Site </th>
              <th style="width:20%;"> Site short name </th>
              <th style="width:20%;">Comment</th>
              <th style="width:20%;">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($acc_user as $acc_usr)
           <tr style="text-align: center;">
            <td> {{App\Users::find($acc_usr->user_id)->name }}{{-- {{ $acc_usr->user_name->name }} --}} </td>
            <td> {{ App\sites::find($acc_usr->site_id)->job_code }} </td>
            <td> {{ $acc_usr->short_name }} </td>
            <td> {{ $acc_usr->comment }} </td>
            <td><a href="{{ route('edit_acco_user',$acc_usr->id)}}"><button class="btn btn-primary mr-2"><i class="fa fa-lg fa-edit"></i></button></a><a href="{{ route('delete_acco_user',$acc_usr->id)}}" onclick="return confirm('Are you sure want to remove ?')" ><button class="btn btn-danger"><i class="fa fa-lg fa-trash"></i></button></a></td>
           </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
      
    <!-- Button trigger modal -->
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Allote site to users</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="{{ route('user_add') }}">
              @csrf
              <div class="row col-md-12">
                <div class="col-md-12">
                  <title class="form-control"> Select site here </title>
                    <select class="form-control" width="100" required="" name="site">
                      <option selected=""> -- select -- </option>
                      @foreach($sites as $site)
                        <option value="{{$site->id}}">{{$site->job_describe.' || '.$site->job_code}}</option>
                      @endforeach
                    </select>
                </div>&nbsp;
                <div class="col-md-12">
                  <title class="form-control"> Select user </title>
                    <select class="form-control" required="" name="user">
                      <option selected=""> -- select -- </option>
                      @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                </div>&nbsp;
                <div class="col-md-12">
                  <title class="form-control"> Site short name </title>
                  <input type="text" name="short_name" class="form-control" required="">
                </div>&nbsp;
                <div class="col-md-12">
                  <title class="form-control" > comment </title>
                  <textarea name="comment" class="form-control"></textarea>
                </div>&nbsp;
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>  
          </div>
          
        </div>
      </div>
    </div>

    <!--  -->
</div>
<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #00cccc;
  text-align: center;
  color: white;
}
</style>
@endsection