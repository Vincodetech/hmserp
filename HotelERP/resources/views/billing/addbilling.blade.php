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
                                        <input class="form-control" type="text" name="item_code" value="" id="item_code" placeholder="Enter Item Code" autofocus required> &nbsp; &nbsp;
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="item_code" onclick="getItemsForOrder()">
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
                                        // $.ajax({
                                        //     url: "{{ url('getorder') }}",
                                        //     type: "GET",
                                        //     data: {
                                        //         'orderid': orderid
                                        //     },
                                        //     success: function(result) {
                                        //         result.forEach(myfunction);

                                        //         function myfunction(item, index) {
                                        //             //getItemName(item['item_id']);
                                        //             getItemPrice(item['item_id']);
                                        //             // getGST();
                                        //             getCGST(item['item_id']);
                                        //             getSGST(item['item_id']);
                                        //             getQuantity(item['item_id']);
                                        //             // console.log(item);   
                                        //         }
                                        //     }
                                        // });

                                        let i = 0;
                                        let oldTotalAmt = 0;
                                        let amt = 0;
                                        let sum = 0;
                                        let taxable_amount = 0;
                                        let grandTotal = 0;

                                        function getItemsForOrder() {
                                            i++;
                                            var item_code = document.getElementById("item_code").value.trim();
                                            $.ajax({
                                                url: "{{ url('getitemname') }}",
                                                type: "GET",
                                                data: {
                                                    'item_code': item_code
                                                },
                                                success: function(result) {
                                                    var data = "";


                                                    for (item in result) {
                                                        data += "<tr>";
                                                        data += `<td>${result[item].name}</td>`;
                                                        data += '<td><input type="text" value="' + result[item].price + '" id="rate_' + (i) + '" /></td>';
                                                        data += '<td><input type="text" value="1" id="quantity" onkeyup="totalAmount(this, ' + (i) + ')" /></td>';
                                                        data += '<td><input type="text" value="' + result[item].price + '" id="amount_' + (i) + '"/></td>';
                                                        data += "</tr>";
                                                        // amt = parseInt(document.getElementById("price").value.trim()) * result[item].price;
                                                        oldTotalAmt = Number(document.getElementById("price").value.trim());
                                                        amt = result[item].price;
                                                        console.log("oldTotalAmt: " + oldTotalAmt);
                                                        console.log(amt);

                                                        if (oldTotalAmt > 0) {
                                                            sum = oldTotalAmt + amt;
                                                            console.log(sum)
                                                            document.getElementById("price").value = sum;
                                                            // document.getElementById("taxable_amount").value = taxable_amount;
                                                            $('#taxable_amount').val(taxable_amount);
                                                            grandTotal = sum;
                                                            console.log("grandTotal : " + grandTotal);
                                                            // document.getElementById("grand_total").value = grandTotal;
                                                            $('#grand_total').val(grandTotal);

                                                            var total = Number(document.getElementById("price"));
                                                            var cgst = (total * 2.5) / 100;
                                                            console.log("cgst : " + cgst);
                                                            var sgst = (total * 2.5) / 100;
                                                            console.log("sgst : " + sgst);
                                                            var gst = cgst + sgst;
                                                            console.log("gst : " + gst);
                                                            $("#cgst").val(cgst);
                                                            $("#sgst").val(sgst);
                                                            taxable_amount = total + gst;
                                                            grandTotal = taxable_amount;
                                                            $('#taxable_amount').val(taxable_amount);
                                                            $('#grand_total').val(grandTotal);

                                                        } else {
                                                            document.getElementById("price").value = result[item].price;
                                                            $('#taxable_amount').val(taxable_amount);
                                                            grandTotal = result[item].price;
                                                            $('#grand_total').val(grandTotal);
                                                            var total = Number(document.getElementById("price"));
                                                            var cgst = (total * 2.5) / 100;
                                                            console.log("cgst : " + cgst);
                                                            var sgst = (total * 2.5) / 100;
                                                            console.log("sgst : " + sgst);
                                                            var gst = cgst + sgst;
                                                            console.log("gst : " + gst);
                                                            $("#cgst").val(cgst);
                                                            $("#sgst").val(sgst);
                                                            taxable_amount = total + gst;
                                                            grandTotal = taxable_amount;
                                                            $('#taxable_amount').val(taxable_amount);
                                                            $('#grand_total').val(grandTotal);
                                                        }
                                                    }
                                                    $('#data').append(data);
                                                }

                                            });
                                        }

                                        function totalAmount(qty, c) {
                                            var totalAmount = 0;
                                            var quantity = parseInt(qty.value.trim());
                                            var rate = parseInt(document.getElementById("rate_" + c).value.trim());
                                            if (quantity != 0) {
                                                var oldAmt = Number(document.getElementById("amount_" + c).value.trim());
                                                var oldTotal = Number(document.getElementById("price").value.trim());
                                                var nTotal = oldTotal - oldAmt;

                                                totalAmount = rate * quantity;

                                                var nnTotal = nTotal + totalAmount;
                                                // sum = sum + totalAmount
                                                document.getElementById("amount_" + c).value = totalAmount;
                                                document.getElementById("price").value = nnTotal;
                                                $('#taxable_amount').val(taxable_amount);
                                                grandTotal = nnTotal;
                                                $('#grand_total').val(grandTotal);
                                            } else {
                                                alert("Quantity must be greater than 0");
                                                qty.autofocus = true;
                                                qty.value = 1;
                                            }
                                        }

                                        // function totalSumAmount(cnt)
                                        // {

                                        // }
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
                                        <label>Total Price(Rs.)</label>
                                        <input class="form-control" type="text" id="price" name="price" placeholder="Enter Price" value="">
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
                                        <input class="form-control" type="text" id="taxable_amount" value="" name="taxable_amount" placeholder="Enter Taxable Amount" disabled autofocus>
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
                                        <input class="form-control" type="text" id="grand_total" name="grand_total" placeholder="Enter Grand Total" value="0.00" disabled>
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