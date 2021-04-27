@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Update User Role Information
                   <a href="{{ url('userrolelist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postupdateuserrolelist/'.$singlefooditem->id) }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <input class="form-control" type="text" name="role" value="{{ $singlefooditem->role }}" placeholder="Enter Role Name"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    @if($singlefooditem->active == '1')
                                        <input type="checkbox" name="active" value="{{ $singlefooditem->active }}" 
                                        checked>
                                    @else
                                        <input type="checkbox" name="active" value="{{ $singlefooditem->active }}">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary"> Update User Role</button>
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