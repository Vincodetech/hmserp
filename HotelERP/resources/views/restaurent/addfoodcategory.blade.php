@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Add Food Category Information
                   <a href="{{ url('foodcategory') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                        <div class="col-lg-12 col-lg-offset-3">
                            <form role="form" action="{{ url('postfoodcategory') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Enter Category Name"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Category Image</label>
                                    <input type="file" name="category_image">
                                </div>
                                <div class="form-group">
                                    <label>Category Type</label>
                                    <select class="form-control" name="category_type">
                                        <option value="">Select</option>
                                        <option value="Restaurant">Restaurant</option>
                                        <option value="Cafe">Cafe</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Category Quantity</label>
                                    <input class="form-control" type="text" name="category_quantity" placeholder="Enter Category Quantity"
                                           autofocus>
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