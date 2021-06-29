<!DOCTYPE html>
<html>

<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <style>
        @media print{
            html, body {
                width: 80mm;
                height:100%;
                position: absolute;
            }
        }
    </style>
   
</head>

<body style="margin-top:0mm;">

    <div>
        
        <table border="1" height="297mm" width="80mm" align="center" style="font-size:30px;">
            <thead>
                <tr align="center">
                    <th>
                        <h3 style="font-size:30px; font-family: Arial Black"><b>Hotel The Grand Piano</b></h3>
                        <h6 style="font-size:30px; font-family: Arial Black"><b>Vanita Avenue, Sankhari Turning,</b></h6>
                        <h6 style="font-size:30px; font-family: Arial Black"><b>Chanasma Highway Road, Patan</b></h6>
                        <h6 style="font-size:30px; font-family: Arial Black"><b>Gujarat-384265</b></h6>
                        <h6 style="font-size:30px; font-family: Arial Black"><b>Mobile: +91 7046062440 || 9316009307</b></h6>
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
                        <table width="100%" border="1">
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
                                        {{ $singlebill->total }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="3">
                                        CGST(2.5%):
                                    </td>
                                    <td>
                                        {{ $singlebill->cgst }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="3">
                                        SGST(2.5%):
                                    </td>
                                    <td>
                                        {{ $singlebill->sgst }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="3">
                                        Discount:
                                    </td>
                                    <td>
                                        {{ $singlebill->discount_value }}
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="3">
                                        Grand Total(Rs.)
                                    </th>
                                    <td>
                                        {{ $singlebill->grand_total }}
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
        <a href="#" class="btn btn-success" onclick="this.style.display='none'; javascript:window.print();">Print</a>
    </div>
</body>

</html>