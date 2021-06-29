@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Update Table Information
                   <a href="{{ url('tables') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postupdatetables/'.$singletable->Id) }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" type="text" name="name" value="{{ $singletable->name }}" placeholder="Enter Title"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Table Type</label>
                                    <select class="form-control" name="table_type">
                                        <!-- <option value="">Select</option> -->
                                        <option {{ ($singletable->table_type) == 'Restaurant' ? 'selected' : ''}} value="Restaurant">Restaurant</option>
                                        <option {{ ($singletable->table_type) == 'Cafe' ? 'selected' : '' }} value="Cafe">Cafe</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Unique Key</label>
                                    <input class="form-control" type="text" name="unique_key"
                                     value="{{ $singletable->unique_key }}" 
                                     placeholder="Enter Unique Key" readonly="readonly"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    @if($singletable->active)
                                        <input type="checkbox" name="active" value="1" 
                                        checked>
                                    @else
                                        <input type="checkbox" name="active" value="1">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary"> Update Table</button>
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