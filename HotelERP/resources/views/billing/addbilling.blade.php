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
                                <form role="form" action="{{ url('postbilling') }}" method="post" onsubmit="pad();">
                                    @csrf
                                    <div class="form-group">
                                        <label>Bill No.</label>
                                        <input class="form-control" type="text" id="bill_no" name="bill_no" placeholder="Enter Bill No." autofocus required>
                                    </div>
                                    <script>
                                        function getBillNo() {
                                            $.ajax({
                                                url: "{{ url('getbillno') }}",
                                                type: "GET",
                                                datatype: "JSON",
                                                success: function(result) {
                                                    var billno = parseInt(result[0]['bill_no']);
                                                   // console.log(billno + 1);
                                                   billno += 1; 
                                                    $('#bill_no').val(billno);
                                                }
                                            });
                                        }
                                        getBillNo();
                                    </script>
                                    <div class="form-group">
                                        <label>Bill Date</label>
                                        <input class="form-control" type="date" name="bill_date" value="<?= date("Y-m-d"); ?>" placeholder="Enter Bill Date" autofocus required>
                                    </div>
                                    <div class="input-group col-lg-6">
                                    <label>Item Code: </label> &nbsp; &nbsp;
                                        <input class="form-control" type="text" name="item_code" value="" id="item_code" 
                                        placeholder="Enter Item Code" autofocus required> &nbsp; &nbsp;
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="item_code" click="">
                                          <i class="fa fa-search fa-sm"></i></button>
                                        </sapn>  
                                    </div>
                                    <script>
                                        $('#order_id').change(function() {
                                            var orderid = $(this).val();

                                            $.ajax({
                                                url: "{{ url('getorder') }}",
                                                type: "GET",
                                                data: {
                                                    'orderid': orderid
                                                },
                                            });
                                        });
                                    </script>
                                    <script>
                                        $('#orderid').change(function() {
                                            var orderid = $(this).val();

                                            $.ajax({
                                                url: "{{ url('getorder') }}",
                                                type: "GET",
                                                data: {
                                                    'orderid': orderid
                                                },
                                                success: function(result) {
                                                    result.forEach(myfunction);

                                                    function myfunction(item, index) {
                                                        //getItemName(item['item_id']);
                                                        getItemPrice(item['item_id']);
                                                        // getGST();
                                                        getCGST(item['item_id']);
                                                        getSGST(item['item_id']);
                                                        getQuantity(item['item_id']);
                                                        // console.log(item);   
                                                    }
                                                }
                                            });
                                        });


                                        function getItemName(item_id) {
                                            $.ajax({
                                                url: "{{ url('getitemname') }}",
                                                type: "GET",
                                                data: {
                                                    'item_id': item_id
                                                },
                                                success: function(result) {
                                                    var data = "";
                                                    // console.log(result);
                                                    for (item in result) {
                                                        // console.log(result[item]);
                                                        data += "<tr>";
                                                        data += `<td>${result[item].name}</td>`;
                                                        data += `<td>${result[item].price}</td>`;
                                                        data += `<td>${result[item].quantity}</td>`;
                                                        data += `<td>${result[item].amount}</td>`;
                                                        data += "</tr>";
                                                    }
                                                    // console.log(data);
                                                    $('#data').append(data);
                                                }

                                            });
                                        }

                                        function getItemPrice(item_id) {
                                            $.ajax({
                                                url: "{{ url('getitemprice') }}",
                                                type: "GET",
                                                data: {
                                                    'item_id': item_id
                                                },
                                                success: function(result) {
                                                    //  console.log(result);
                                                    $('#price').val(result);

                                                    getGST(result);

                                                }

                                            });
                                        }
                                    </script>

                                    <div class="form-group">
                                        <label>Order Data</label>
                                        <div>
                                            <table class="table table-striped" border="1" cellpadding="2">
                                                <thead>
                                                    <tr>
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
                                        <label>Quantity</label>
                                        <input class="form-control" type="text" id="quantity" name="quantity" readonly="readonly" placeholder="Enter Quantity" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label>Total Price(Rs.)</label>
                                        <input class="form-control" type="text" id="price" name="price" placeholder="Enter Price" readonly="readonly" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Discount(%)</label>
                                        <input class="form-control" type="text" id="discount" value="0" name="discount" placeholder="Enter Discount" onkeyup="calculate_discount(this)">
                                    </div>
                                    <script>
                                        function calculate_discount(discountVal) {
                                            var afterCalculateDiscount = 0;
                                            discount = parseFloat(discountVal.value.trim());
                                            if (discount) {
                                                subTotal = parseFloat($('#price').val());
                                                calculatedDicVal = (subTotal * discount) / 100;
                                                afterCalculateDiscount = subTotal - calculatedDicVal;
                                                $('#grand_total').val(Math.round(afterCalculateDiscount));
                                                $('#taxable_amount').val(Math.round(afterCalculateDiscount));
                                                // $('#discount').val(Math.round(calculatedDicVal));
                                                // document.getElementById('calculatedDicVal').innerHTML = Math.round(calculatedDicVal);
                                            }
                                        }

                                        function grand_total(amount) {
                                            $('#grand_total').val(Math.round(amount));
                                        }
                                    </script>
                                    <div class="form-group">
                                        <label>CGST(2.5%)</label>
                                        <input class="form-control" type="text" id="cgst" name="cgst" value="0.00" readonly="readonly" placeholder="Enter CGST" autofocus>
                                    </div>
                                    <script>
                                        function getGST(rate) {
                                            //  var rate = document.getElementById("price").value.trim();
                                            var rate = parseFloat(rate);
                                            // console.log(rate);
                                            if (rate != 0) {
                                                //    console.log(rate);
                                                var cgst = (rate * 2.5) / 100;
                                                var sgst = (rate * 2.5) / 100;
                                                var gst = cgst + sgst;
                                                var single_total = rate + gst;
                                                //console.log(single_total);
                                                $("#cgst").val(Math.round(cgst));
                                                $("#sgst").val(Math.round(sgst));
                                                $("#taxable_amount").val(Math.round(single_total));
                                                grand_total(single_total);

                                            } //else{
                                            //     $("#cgst").val(0);
                                            //     $("#sgst").val(0);
                                            //     $("#taxable_amount").val(0);
                                            //     grand_total();

                                            // }

                                        }

                                        function getCGST(item_id) {
                                            $.ajax({
                                                url: "{{ url('getcgst') }}",
                                                type: "GET",
                                                data: {
                                                    'item_id': item_id
                                                },
                                                success: function(result) {
                                                    //  console.log(result);
                                                    $('#cgst').val(result);

                                                }

                                            });
                                        }

                                        function getSGST(item_id) {
                                            $.ajax({
                                                url: "{{ url('getsgst') }}",
                                                type: "GET",
                                                data: {
                                                    'item_id': item_id
                                                },
                                                success: function(result) {
                                                    //  console.log(result);
                                                    $('#sgst').val(result);

                                                }

                                            });
                                        }
                                    </script>
                                    <div class="form-group">
                                        <label>SGST(2.5%)</label>
                                        <input class="form-control" type="text" id="sgst" name="sgst" value="0.00" readonly="readonly" placeholder="Enter SGST" autofocus>
                                    </div>
                                    <script>
                                        function getQuantity(item_id) {
                                            $.ajax({
                                                url: "{{ url('getquantity') }}",
                                                type: "GET",
                                                data: {
                                                    'item_id': item_id
                                                },
                                                success: function(result) {
                                                    //  console.log(result);
                                                    $('#quantity').val(result + " Item(s)");

                                                }

                                            });
                                        }
                                    </script>

                                    <div class="form-group">
                                        <label>Taxable Amount(Rs.)</label>
                                        <input class="form-control" type="text" id="taxable_amount" value="" name="taxable_amount" placeholder="Enter Taxable Amount" readonly="readonly" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label>Pay Amount(Rs.)</label>
                                        <input class="form-control" type="text" id="payable_amount" name="payable_amount" value="0.00" onkeyup="get_change_amount(this)" placeholder="Enter Pay Amount" autofocus>
                                        <div id="error_message">

                                        </div>
                                    </div>
                                    <script>
                                        function get_change_amount(changeVal) {
                                            var afterChange = 0;
                                            grand_total = parseFloat($('#grand_total').val());
                                            change = parseFloat(changeVal.value.trim());
                                            if (change != 0 && change > grand_total) {
                                                afterChange = change - grand_total;
                                                $('#change_amount').val(Math.round(afterChange));
                                            }

                                        }
                                    </script>
                                    <div class="form-group">
                                        <label>Change Amount(Rs.)</label>
                                        <input class="form-control" type="text" id="change_amount" name="change_amount" value="0.00" placeholder="Enter Change Amount" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label>Grand Total(Rs.)</label>
                                        <input class="form-control" type="text" id="grand_total" name="grand_total" placeholder="Enter Grand Total" value="0.00" readonly="readonly">
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