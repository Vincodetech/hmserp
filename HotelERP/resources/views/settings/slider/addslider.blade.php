@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Add Slider Image
                   <a href="{{ url('sliderlist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postslider') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                    <label>Slider Image</label>
                                    <input type="file" name="slider_image"> <br/>
                                    <span class="badge badge-danger">Image File Size Must be Less than 200kb</span>
                                    <span class="badge badge-danger">Image File Must be Extension with .jpeg, .jpg, .png</span>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                
                                    <input type="checkbox" name="active" value="1" checked>
                                </div>

                                <button type="submit" class="btn btn-primary"> Add Slider Image</button>
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