@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Update User Information
                   <a href="{{ url('userslist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
                </div>
                @if (Session::get('updateCategoryInMsg'))
                    <div class="alert alert-success">
                        {{ Session::get('updateCategoryInMsg') }}
                    </div>
                @endif

                @if (Session::get('errUpdateCategoryInMsg'))
                    <div class="alert alert-danger">
                        {{ Session::get('errUpdateCategoryInMsg') }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-lg-offset-3">
                            <form role="form" action="{{ url('postupdateuserslist/'.$singlefooditem->id) }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" type="text" name="user_name" value="{{ $singlefooditem->user_name }}" placeholder="Enter Name"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="text" name="email" value="{{ $singlefooditem->email }}" placeholder="Enter Email"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Phone No.</label>
                                    <input class="form-control" type="text" name="phone"
                                     value="{{ $singlefooditem->phone }}" 
                                     placeholder="Enter Phone No."
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>User Role</label>
                                    <select class="form-control" name="user_role">
                                        <!-- <option value="none">Select</option> -->
                                        @foreach($allcategory as $data)
                                        @if($data->id == $singlefooditem->user_role)
                                            <option value="{{ $data->id }}" selected>{{ $data->role }}</option>
                                        @else
                                            <option value="{{ $data->id }}">{{ $data->role }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    @if($singlefooditem->active)
                                        <input type="checkbox" name="active" value="1" 
                                        checked>
                                    @else
                                        <input type="checkbox" name="active" value="1">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary"> Update User</button>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        
        <!-- /.col-lg-12 -->
        
    </div>
       
</div>
@include('admin.footer')    