@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                Add Order Information
                <a href="{{ url('orderlist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postaddorder') }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label>Table Name</label>
                                    <select class="form-control" name="table_id">
                                        <option value="none">Select</option>
                                        @foreach($alltables as $data)
                                        <option value="{{ $data->Id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <?php $length = 10;
                                        $randomString = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
                                ?>
                                <div class="form-group">
                                    <label>Order No.</label>
                                    <input class="form-control" type="text" name="order_no"
                                     placeholder="Enter Order No." readonly="readonly" value="<?php echo $randomString;?>">
                                </div>
                                <div class="form-group">
                                    <label>Order Type</label>
                                    <select class="form-control" name="order_type">
                                        <option value="">Select</option>
                                        <option value="Delivery">Delivery Order</option>
                                        <option value="Takeaway">Takeaway Order</option>
                                        <option value="Scan">Scan Order</option>
                                    </select>
                                </div>    
                                <div class="form-group">
                                    <label>Order Status</label><br/>
                                    <input type="radio" id="draft" name="order_status" value="Draft" checked>
                                    <label for="Draft">Draft</label><br>
                                    <input type="radio" id="pending" name="order_status" value="Pending">
                                    <label for="Pending">Pending</label><br>
                                    <input type="radio" id="complete" name="order_status" value="Complete">
                                    <label for="Complete">Complete</label>
                                </div>
                                <div class="form-group">
                                    <label>Payment Status</label><br/>
                                    <input type="radio" id="cash" name="payment_status" value="Cash" checked>
                                    <label for="Cash">Cash</label><br>
                                    <input type="radio" id="online" name="payment_status" value="Online">
                                    <label for="Online">Online</label><br>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    <input type="checkbox" name="active" value="1" checked>
                                </div>
                                <button type="submit" class="btn btn-primary"> Add Order</button>
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