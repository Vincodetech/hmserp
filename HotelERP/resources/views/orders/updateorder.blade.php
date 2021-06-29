@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Update Order Information
                   <a href="{{ url('orderlist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postupdateorder/'.$singleorder->Id) }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label>Table Name</label>
                                    <select class="form-control" name="table_id">
                                        <!-- <option value="none">Select</option> -->
                                        @foreach($alltables as $data)
                                        @if($data->Id == $singleorder->table_id)
                                            <option value="{{ $data->Id }}" selected>{{ $data->name }}</option>
                                        @else
                                            <option value="{{ $data->Id }}">{{ $data->name }}</option>
                                        @endif
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
                                            <!-- <option value="">Select</option> -->
                                            <option {{ ($singleorder->order_type) == 'Delivery' ?
                                            'selected' : ''}} value="Delivery">Delivery Order</option>
                                            <option {{ ($singleorder->order_type) == 'Takeaway' ?
                                            'selected' : '' }} value="Takeaway">Takeaway Order</option>
                                            <option {{ ($singleorder->order_type) == 'Scan' ?
                                            'selected' : '' }} value="Scan">Scan Orde</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Order Status</label><br/>
                                    <input type="radio" id="draft" name="order_status" value="Draft" {{ ($singleorder->order_status) == 'Draft' ?
                                            'checked' : ''}}>
                                    <label for="Draft">Draft</label><br>
                                    <input type="radio" id="pending" name="order_status" value="Pending" {{ ($singleorder->order_status) == 'Pending' ?
                                            'checked' : ''}}>
                                    <label for="Pending">Pending</label><br>
                                    <input type="radio" id="complete" name="order_status" value="Complete" {{ ($singleorder->order_status) == 'Complete' ?
                                            'checked' : ''}}>
                                    <label for="Complete">Complete</label>
                                </div>
                                <div class="form-group">
                                    <label>Payment Status</label><br/>
                                    <input type="radio" id="cash" name="payment_status" value="Cash" {{ ($singleorder->payment_status) == 'Cash' ?
                                            'checked' : ''}}>
                                    <label for="Draft">Cash</label><br>
                                    <input type="radio" id="online" name="payment_status" value="Online" {{ ($singleorder->payment_status) == 'Online' ?
                                            'checked' : ''}}>
                                    <label for="Online">Online</label><br>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    @if($singleorder->active)
                                        <input type="checkbox" name="active" value="1" 
                                        checked>
                                    @else
                                        <input type="checkbox" name="active" value="1">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary"> Update Order</button>
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