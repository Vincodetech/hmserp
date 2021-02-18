@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Food Category Information
                </div>
                
                {{--{{Session::get('roleMsg')}}--}}
                @if (Session::get('roleSccssMsg'))
                    <div class="alert alert-success">
                        {{ Session::get('roleSccssMsg') }}
                    </div>
                @endif

                @if (Session::get('roleErrMsg'))
                    <div class="alert alert-danger">
                        {{ Session::get('roleErrMsg') }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <form role="form" action="{{ url('postcategory') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input class="form-control" type="text" name="cat_name" placeholder="Enter Category Name"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Category Type</label>
                                    <select class="form-control" name="name" required>
                                        <option value="" required>Select</option>
                                        <option value="" required>Restaurant</option>
                                        <option value="" required>Cafe</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Active</label>
                                    <input type="checkbox" name="active" value="1">
                                    
                                </div>

                                <button type="submit" class="btn btn-primary"> Add Category</button>
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