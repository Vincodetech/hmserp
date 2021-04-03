@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Add Table Information
                   <a href="{{ url('tables') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('posttables') }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" type="text" name="name" placeholder="Enter Title"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Table Type</label>
                                    <select class="form-control" name="table_type">
                                        <option value="">Select</option>
                                        <option value="restaurant">Restaurant</option>
                                        <option value="cafe">Cafe</option>
                                    </select>
                                </div>
                                <?php $length = 10;
                                        $randomString = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
                                ?>  
                                <div class="form-group">
                                    <label>Unique Key</label>
                                    <input class="form-control" type="text" name="unique_key" placeholder="Enter Unique Key"
                                    readonly="readonly" value="<?php echo $randomString;?>">
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                
                                    <input type="checkbox" name="active" value="1">
                                </div>

                                <button type="submit" class="btn btn-primary"> Add Table</button>
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