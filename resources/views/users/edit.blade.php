@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Edit Site wise User</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
			<div class="row">
			 <div class="col-md-12" style="border-right: 1px solid">
            <form action="{{ route('ac_siteuser_update',$edit->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Site</label>
                        @php 
                         $sitename= App\sites::whereNotIn('id',$site)->get();
                         // dd(count($sitename));
                         @endphp
                       <select name="site_id" class="form-control">
                       	@foreach($sitename as $usr)
                       	 <option @if($usr->id == $edit->site_id) selected  @endif value="{{ $usr->id }}"
                >{{ $usr->job_code }}</option>
                        @endforeach
                       </select>
                         @error('hsn_code')
                    <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Site User</label>
                         @php 
                         $user= App\Users::whereNotIn('id',$user)->get();
                         @endphp
                       <select name="user_id" class="form-control">
                       @foreach($user as $usr)
                       	<option @if($usr->id == $edit->user_id) selected  @endif value="{{ $usr->id }}"
                >{{ $usr->name }}</option>
                        @endforeach
                       </select>
                 @error('user_id')
                    <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                    </div>
                </div>
                <div class="row">
                	<div class="form-group col-md-5">
                        <label>Short Name</label>
                        <input type="text" class="form-control" placeholder="Add HSN Code" name="short_name" value="{{ $edit->short_name }}" >
                 @error('short_name')
                    <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                    </div>
                    <div class="form-group col-md-7">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control" rows="5" placeholder="Add comment">{{ $edit->comment }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          	</div>
          </div>
        </div>
    </div>
</div>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
	$('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
</script> --}}
@endsection

{{-- {{ route('excel_import') }} --}}