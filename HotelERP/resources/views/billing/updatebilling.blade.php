@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Update Bill Information
                   <a href="{{ url('billinglist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-arrow-circle-left fa-sm text-white-50"></i> Go Back </a>
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
                            <form role="form" action="{{ url('postupdatebilling/'.$singlebill->id) }}" method="post">
                            @csrf
                                <div class="form-group">
                                        <label>Bill No.</label>
                                        <input class="form-control" type="text" id="bill_no" name="bill_no" 
                                        placeholder="Enter Bill No." value="{{ $singlebill->bill_no }}" readonly="readonly">
                                        <input type="hidden" id="orderId" name="orderId" value="{{$oid}}">
                                </div>
                                <div class="form-group">
                                        <label>Bill Date</label>
                                        <input class="form-control" type="date" name="bill_date" 
                                        value="{{ $singlebill->bill_date }}" placeholder="Enter Bill Date" 
                                        readonly="readonly" autofocus required>
                                </div>
                                <div class="input-group col-lg-6">
                                        <label>Item Code: </label> &nbsp; &nbsp;
                                        <input class="form-control" type="text" name="item_code" value="" 
                                        id="item_code" placeholder="Enter Item Code" autofocus required> &nbsp; &nbsp;
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="item_code" 
                                            onclick="getItemsForOrder()">
                                                <i class="fa fa-search fa-sm"></i></button>
                                            </sapn>
                                </div>   
                                <div class="form-group">
                                    <label>Order Data</label>
                                        <div>
                                            <table class="table table-striped" border="1" cellpadding="2">
                                                <thead>
                                                    <tr>
                                                        <th><b>#</b></th>
                                                        <th><b>Item Name</b></th>
                                                        <th><b>Item Price</b></th>
                                                        <th><b>Quantity</b></th>
                                                        <th><b>Amount</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data">

                                                </tbody>
                                            </table>
                                        </div>
                                </div> 
                                <div class="form-group">
                                        <label>Total Price(Rs.)</label>
                                        <input class="form-control" type="text" id="price" name="price" 
                                        placeholder="Enter Price" value="0" readonly="readonly">
                                </div>
                                <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>CGST(2.5%)</label>
                                                <input class="form-control" type="text" id="cgst" name="cgst" 
                                                value="{{ $singlebill->cgst }}" 
                                                readonly="readonly" placeholder="Enter CGST">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>SGST(2.5%)</label>
                                                <input class="form-control" type="text" id="sgst" name="sgst"
                                                 value="{{ $singlebill->sgst }}"
                                                 readonly="readonly" placeholder="Enter SGST">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Taxable Amount(Rs.)</label>
                                                <input class="form-control" type="text" id="taxable_amount" 
                                                value="{{ $singlebill->taxable_amount }}" name="taxable_amount" placeholder="Enter Taxable Amount"
                                                 readonly="readonly">
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Discount(%)</label>
                                                <input class="form-control" type="text" id="discount"
                                                 value="{{ $singlebill->discount }}" 
                                                name="discount" placeholder="Enter Discount" onkeyup="calculate_discount(this)">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Discount(Rs.)</label>
                                                <input type="text" class="form-control" name="discount_value" 
                                                id="discVal" value="{{ $singlebill->discount_value }}" readonly="readonly">
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pay Amount(Rs.)</label>
                                            <input class="form-control" type="text" id="payable_amount" 
                                            name="payable_amount" value="{{ $singlebill->payable_amount }}" onkeyup="get_change_amount(this)" 
                                            placeholder="Enter Pay Amount">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Change Amount(Rs.)</label>
                                            <input class="form-control" type="text" id="change_amount" name="change_amount"
                                            value="{{ $singlebill->change_amount }}" placeholder="Enter Change Amount" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label>Grand Total(Rs.)</label>
                                        <input class="form-control" type="text" id="grand_total" 
                                        name="grand_total" placeholder="Enter Grand Total" value="{{ $singlebill->grand_total }}" 
                                        readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    @if($singlebill->active)
                                        <input type="checkbox" name="active" 
                                        value="1" checked>
                                    @else
                                        <input type="checkbox" name="active" 
                                        value="1">    
                                    @endif    
                                </div>
                                <button type="submit" class="btn btn-primary"> Update Bill</button>
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