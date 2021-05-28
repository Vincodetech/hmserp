<!DOCTYPE html>
<html>

<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
   }
  </style> -->
</head>

<body>
    <br />
    <div class="container">


        <div class="row">
            <div class="col-md-7" align="right">

            </div>
            <div class="col-md-5" align="right">
                <a href="#" class="btn btn-success" onclick="this.style.display='none'; javascript:window.print();">Print</a>
            </div>
        </div>
        <br />
        <div>

            <table border="1" height="auto" width="1000px" align="center">
                <thead>
                    <tr align="center">
                        <th>
                            <h3><b>Hotel The Grand Piano</b></h3>
                            <h6><b>Vanita Avenue, Sankhari Turning,</b></h6>
                            <h6><b>Chanasma Highway Road, Patan</b></h6>
                            <h6><b>Gujarat-384265</b></h6>
                            <h6><b>Mobile: +91 7046062440 || 9316009307</b></h6>
                        </th>
                    </tr>
                    <tr style="height: 30px;">
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <table width="100%" border="1">
                                <tr class="text-center">
                                    <td>
                                        PURE VEG.
                                    </td>
                                    <td>
                                        TAX INVOICE
                                    </td>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <table width="100%">
                                <tr>
                                    <td class="float-left">
                                        Bill No. {{ $singlebill->bill_no }}
                                    </td>
                                    <td class="text-center">
                                        {{$table->name}}
                                    </td>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    <tr>
                        <th class="float-left">
                            Date: {{ $singlebill->bill_date }}
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <table width="100%" border="1">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Qty
                                        </th>
                                        <th>
                                            Rate
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bill_data as $bill)
                                    <tr class="text-center">
                                        <td>
                                            {{$bill->name}}
                                        </td>
                                        <td>
                                            {{$bill->quantity}}
                                        </td>
                                        <td>
                                            {{$bill->price}}
                                        </td>
                                        <td>
                                            {{$bill->amount}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <td colspan="3">
                                            Total:
                                        </td>
                                        <td>
                                            Rs. {{ $singlebill->total }}
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="3">
                                            CGST(2.5%):
                                        </td>
                                        <td>
                                            Rs. {{ $singlebill->cgst }}
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="3">
                                            SGST(2.5%):
                                        </td>
                                        <td>
                                            Rs. {{ $singlebill->sgst }}
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="3">
                                            Discount:
                                        </td>
                                        <td>
                                            Rs. {{ $singlebill->discount_value }}
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <th colspan="3">
                                            Grand Total:
                                        </th>
                                        <td>
                                            Rs. {{ $singlebill->grand_total }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </th>
                    </tr>
                    <tr class="text-center">
                        <th>
                            ...Thanks for Visit...
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</body>

</html>