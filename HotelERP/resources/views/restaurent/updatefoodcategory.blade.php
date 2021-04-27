@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Update Food Category Information
                   <a href="{{ url('foodcategory') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postupdatefoodcategory/'.$singlefoodcategory->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input class="form-control" type="text" name="name" value="{{ $singlefoodcategory->name }}" placeholder="Enter Category Name"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Category Image</label>
                                    <input type="file" name="category_image" 
                                    value="{{ $singlefoodcategory->category_image }}">
                                </div>
                                <div class="form-group">
                                    <label>Category Type</label>
                                    <select class="form-control" name="category_type">
                                        <!-- <option value="">Select</option> -->
                                        <option {{ ($singlefoodcategory->category_type) == 'Restaurant' ? 'selected' : ''}} value="Restaurant">Restaurant</option>
                                        <option {{ ($singlefoodcategory->category_type) == 'Cafe' ? 'selected' : '' }} value="Cafe">Cafe</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Category Quantity</label>
                                    <input class="form-control" type="text" name="category_quantity"
                                     value="{{ $singlefoodcategory->category_quantity }}" 
                                     placeholder="Enter Category Quantity"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    @if($singlefoodcategory->active == '1')
                                        <input type="checkbox" name="active" value="{{ $singlefoodcategory->active }}" 
                                        checked>
                                    @else
                                        <input type="checkbox" name="active" value="{{ $singlefoodcategory->active }}">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary"> Update Category</button>
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