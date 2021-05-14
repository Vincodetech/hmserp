@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Create Bill Information
                   <a href="{{ url('billinglist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postbilling') }}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label>Bill No.</label>
                                    <input class="form-control" type="text" name="bill_no" placeholder="Enter Bill No."
                                           autofocus required>
                                </div>
                                <div class="form-group">
                                    <label>Bill Date</label>
                                    <input class="form-control" type="date" name="bill_date" placeholder="Enter Bill Date"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Order ID With Name</label>
                                    <select class="form-control" name="orderid" id="orderid">
                                    <option value="orderid">Select</option>
                                        @foreach($allbill as $data)
                                        <option value="{{ $data->order_id }}">{{ $data->orderid }}-{{ $data->user_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input class="form-control" type="text" id="name" name="name" 
                                    placeholder="Enter Item Name" disabled
                                           autofocus required>
                                </div>
                                <div class="form-group">
                                    <label>Order Type</label>
                                    <input class="form-control" type="text" name="order_type" placeholder="Enter Order Type"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control" type="text" name="price" placeholder="Enter Price"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input class="form-control" type="text" name="discount" placeholder="Enter Discount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>CGST</label>
                                    <input class="form-control" type="text" name="cgst" placeholder="Enter CGST"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>SGST</label>
                                    <input class="form-control" type="text" name="sgst" placeholder="Enter SGST"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control" type="text" name="quantity" placeholder="Enter Quantity"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Taxable Amount</label>
                                    <input class="form-control" type="text" name="taxable_amount" placeholder="Enter Taxable Amount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Payable Amount</label>
                                    <input class="form-control" type="text" name="payable_amount" placeholder="Enter Payable Amount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Change Amount</label>
                                    <input class="form-control" type="text" name="change_amount" placeholder="Enter Change Amount"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Grand Total</label>
                                    <input class="form-control" type="text" name="grand_total" placeholder="Enter Grand Total"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                
                                    <input type="checkbox" name="active" value="1">
                                </div>

                                <button type="submit" class="btn btn-primary"> Create Bill</button>
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