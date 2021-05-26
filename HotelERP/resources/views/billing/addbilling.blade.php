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
                                        <input class="form-control" type="text" id="bill_no" name="bill_no" 
                                        placeholder="Enter Bill No." readonly="readonly">
                                        <input type="hidden" id="orderId" name="orderId" value="{{$oid}}">
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
                                        <input class="form-control" type="date" name="bill_date" 
                                        value="<?= date("Y-m-d"); ?>" placeholder="Enter Bill Date" autofocus required>
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
                                    <script>
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
                                                        data += '<td><input type="checkbox" id="chk_' + (i) + '" name="chk" value="" data-toggle="tooltip" title="Save Entry" onclick="myFunction(' + (i) + ')"></td>';
                                                        data += `<td><input type="hidden" id="itemId_${i}" name="itemId" value="${result[item].id}">${result[item].name}</td>`;
                                                        data += '<td><input type="text" value="' + result[item].price + '" id="rate_' + (i) + '" disabled /></td>';
                                                        data += '<td><input type="text" value="1" id="quantity_' + (i) + '" onkeyup="totalAmount(' + (i) + ')" /></td>';
                                                        data += '<td><input type="text" value="' + result[item].price + '" id="amount_' + (i) + '" disabled/><span id="text_'+(i)+'" style="display:none" class="badge badge-success">Entry Saved</span></td>';
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

                                                            var total = Number(document.getElementById("price").value.trim());
                                                            var cgst = (total * 2.5) / 100;
                                                            var sgst = (total * 2.5) / 100;
                                                            var gst = cgst + sgst;
                                                            $("#cgst").val(Math.round(cgst));
                                                            $("#sgst").val(Math.round(sgst));
                                                            taxable_amount = total + gst;
                                                            grandTotal = taxable_amount;
                                                            $('#taxable_amount').val(Math.round(taxable_amount));
                                                            $('#grand_total').val(Math.round(grandTotal));

                                                        } else {
                                                            document.getElementById("price").value = result[item].price;
                                                            $('#taxable_amount').val(taxable_amount);
                                                            grandTotal = result[item].price;
                                                            $('#grand_total').val(grandTotal);
                                                            var total = Number(document.getElementById("price").value.trim());
                                                            //console.log("total : " + total);
                                                            var cgst = (total * 2.5) / 100;
                                                            console.log("cgst : " + cgst);
                                                            var sgst = (total * 2.5) / 100;
                                                            console.log("sgst : " + sgst);
                                                            var gst = cgst + sgst;
                                                            console.log("gst : " + gst);
                                                            $("#cgst").val(Math.round(cgst));
                                                            $("#sgst").val(Math.round(sgst));
                                                            taxable_amount = total + gst;
                                                            grandTotal = taxable_amount;
                                                            $('#taxable_amount').val(Math.round(taxable_amount));
                                                            $('#grand_total').val(Math.round(grandTotal));
                                                        }
                                                    }
                                                    $('#data').append(data);
                                                }

                                            });
                                        }

                                        function totalAmount(c) {
                                            var totalAmount = 0;
                                            var quantity = parseInt(document.getElementById("quantity_" + c).value.trim());
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
                                                $('#taxable_amount').val(Math.round(taxable_amount));
                                                grandTotal = nnTotal;
                                                $('#grand_total').val(Math.round(grandTotal));
                                            } else {
                                                alert("Quantity must be greater than 0");
                                                qty.autofocus = true;
                                                qty.value = 1;
                                            }
                                        }
                                    </script>
                                    <script type="text/javascript">
                                        function myFunction(c) {
                                            // Get the checkbox
                                            var checkBox = document.getElementById("chk_" + c);
                                            // Get the output text
                                            var text = document.getElementById("text_"+ c);

                                            // If the checkbox is checked, display the output text
                                            if (checkBox.checked == true) {
                                                // 
                                                var order_id = document.getElementById("orderId").value.trim();
                                                var item_id = document.getElementById("itemId_" + c).value.trim();
                                                var quantity = document.getElementById("quantity_" + c).value.trim();
                                                var amount = document.getElementById("amount_" + c).value.trim();

                                                $.ajax({
                                                    url: "{{ url('addallitems') }}",
                                                    type: "POST",
                                                    data: {
                                                        '_token':"{{ csrf_token() }}",
                                                        'item_id': item_id,
                                                        'order_id' :order_id,
                                                        'quantity' :quantity,
                                                        'amount' :amount,
                                                        'active' :1
                                                    },
                                                    success: function(result) {
                                                        if(result == 1){
                                                            text.style.display = "block";
                                                            var qty = document.getElementById("quantity_" + c);
                                                            qty.disabled = true;
                                                            checkBox.setAttribute('class', 'd-none');
                                                        }
                                                    }
                                                });
                                            } else {
                                                text.style.display = "none";
                                            }
                                        }
                                    </script>
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
                                        placeholder="Enter Price" value="" readonly="readonly">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>CGST(2.5%)</label>
                                                <input class="form-control" type="text" id="cgst" name="cgst" value="0.00" 
                                                readonly="readonly" placeholder="Enter CGST">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>SGST(2.5%)</label>
                                                <input class="form-control" type="text" id="sgst" name="sgst" value="0.00"
                                                 readonly="readonly" placeholder="Enter SGST">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Taxable Amount(Rs.)</label>
                                                <input class="form-control" type="text" id="taxable_amount" 
                                                value="" name="taxable_amount" placeholder="Enter Taxable Amount"
                                                 readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Discount(%)</label>
                                                <input class="form-control" type="text" id="discount" value="0" 
                                                name="discount" placeholder="Enter Discount" onkeyup="calculate_discount(this)">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Discount(Rs.)</label>
                                                <input type="text" class="form-control" name="discount_value" 
                                                id="discVal" value="0" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function calculate_discount(discountVal) {
                                            var ngTotal = 0;
                                            discount = parseFloat(discountVal.value.trim());
                                            if (discount > 0) {
                                                var taxAmt = parseFloat($('#taxable_amount').val());
                                                calculatedDicVal = (taxAmt * discount) / 100;
                                                ngTotal = taxAmt - calculatedDicVal;
                                                $('#discVal').val(Math.round(calculatedDicVal));
                                                $('#grand_total').val(Math.round(ngTotal));
                                            } else {
                                                var taxAmt = parseFloat($('#taxable_amount').val());
                                                calculatedDicVal = 0;
                                                ngTotal = taxAmt - calculatedDicVal;
                                                $('#discVal').val(Math.round(calculatedDicVal));
                                                $('#grand_total').val(Math.round(ngTotal));
                                            }
                                        }
                                    </script>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Pay Amount(Rs.)</label>
                                                <input class="form-control" type="text" id="payable_amount" 
                                                name="payable_amount" value="0.00" onkeyup="get_change_amount(this)" 
                                                placeholder="Enter Pay Amount">
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
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Change Amount(Rs.)</label>
                                                <input class="form-control" type="text" id="change_amount" name="change_amount"
                                                 value="0.00" placeholder="Enter Change Amount" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Grand Total(Rs.)</label>
                                        <input class="form-control" type="text" id="grand_total" name="grand_total" placeholder="Enter Grand Total" value="0.00" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label>Active</label>

                                        <input type="checkbox" name="active" value="1" checked>
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