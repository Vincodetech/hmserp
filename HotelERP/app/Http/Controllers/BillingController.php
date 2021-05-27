<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use PDF;

class BillingController extends Controller
{
    public function billingList()
    {
        if (request()->ajax()) {
            $data = DB::table('billing')
                ->select(
                    'id',
                    'bill_no',
                    'bill_date',
                    'order_id',
                    'grand_total',
                    'active'
                )
                ->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('order_id', function ($data) {

                    $sql = DB::table('orders')->where('id', $data->order_id)->first();
                    return $sql->order_no;
                })
                ->addColumn('active', function ($data) {
                    if ($data->active == '1') {
                        $btn1 = '<span class="badge badge-success">Active</span>';
                    } else {
                        $btn1 = '<span class="badge badge-danger">InActive</span>';
                    }
                    return $btn1;
                })
                ->addColumn('Action', function ($data) {

                    $btn = '<a href="' . url('viewbilling/' . $data->id) . '">
                           <i class="fa fa-eye" aria-hidden="true"></i></a>
                           <a href="' . url('updatebilling/' . $data->id) . '">
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="' . url('deletebilling/' . $data->id) . '" class="delete">
                           <i class="fa fa-trash" aria-hidden="true"></i></a>';

                    return $btn;
                })
                ->rawColumns(['order_id', 'active', 'Action'])->make(true);
        }
        $bill = DB::table('billing')
            ->select('bill_no')
            ->groupBy('bill_no')
            ->orderBy('bill_no', 'ASC')
            ->get();

        $result = DB::table('billing')->select("*")->get();

        return view('billing.billinglist', compact('bill'), ['result' => $result]);
    }

    public function addBilling($id)
    {
        $singlebill = DB::table('orders')->where('id', $id)->first();
        $allbill = DB::table('order_detail')
            ->join('food_item', 'food_item.id', '=', 'order_detail.item_id')
            ->select('food_item.name', 'order_detail.quantity', 'food_item.price', 'order_detail.amount')
            ->get();
        // $allbill = DB::select('select * from billing');
        return view('billing.addbilling', ['singlebill' => $singlebill, 'allbill' => $allbill, 'oid' => $id]);
    }

    public function addPostBilling(Request $request, $id)
    {
        $bno = $request->bill_no;
        $bdate = $request->bill_date;
        //$oid = $request->order_id;
        $oid = $request->input('orderId');
        $discount = $request->discount;
        $dis_value = $request->discount_value;
        $cgst = $request->cgst;
        $sgst = $request->sgst;
        $tax_amount = $request->taxable_amount;
        $pay_amount = $request->payable_amount;
        $ch_amount = $request->change_amount;
        $total = $request->total;
        $gtotal = $request->grand_total;
        $active = $request->active;

        if ($active != '1') {
            $active = 0;
        } else {
            $active = 1;
        }
        $results = DB::insert('insert into billing(bill_no,bill_date,order_id,discount,discount_value,
        cgst,sgst,taxable_amount,payable_amount,change_amount,total,grand_total,active) 
        values (?,?,?,?,?,?,?,?,?,?,?,?,?)', [
            $bno, $bdate, $oid, $discount, $dis_value, $cgst, $sgst,
            $tax_amount, $pay_amount, $ch_amount, $total, $gtotal, $active
        ]);

        if ($pay_amount < $gtotal && $pay_amount > 0) {
            return redirect('addbilling/' . $id)->with('roleErrMsg', 'Pay Amount Must be Greater than Grand Total');
        } else {
            if ($results != false) {
                return redirect('addbilling/' . $id)->with('roleSccssMsg', 'Bill Added Successfully');
            } else {
                return redirect('addbilling/' . $id)->with('roleErrMsg', 'Bill add to failed!!');
            }
        }
        return view('billing.addbilling');
    }

    public function updateBilling($id)
    {
        $singlebill = DB::table('billing')->where('id', $id)->first();
        return view('billing.updatebilling', ['singlebill' => $singlebill, 'oid' => $id]);
    }

    public function postUpdateBilling(Request $request, $id)
    {
        $bno = $request->bill_no;
        $bdate = $request->bill_date;
        //$oid = $request->order_id;
        $oid = $request->input('orderId');
        $discount = $request->discount;
        $dis_value = $request->discount_value;
        $cgst = $request->cgst;
        $sgst = $request->sgst;
        $tax_amount = $request->taxable_amount;
        $pay_amount = $request->payable_amount;
        $ch_amount = $request->change_amount;
        $total = $request->total;
        $gtotal = $request->grand_total;
        $active = $request->active;


        if ($active != '1') {
            $active = 0;
        } else {
            $active = 1;
        }
        $result = DB::update('update billing set bill_no = ?, bill_date = ?, 
        order_id = ?, discount = ?, discount_value = ?, cgst = ?, sgst = ?, taxable_amount = ?, 
        payable_amount = ?, change_amount = ?, total = ?, grand_total = ?, active = ? where id = ?', [
            $bno, $bdate,
            $oid, $discount, $dis_value, $cgst, $sgst, $tax_amount, $pay_amount, $ch_amount, $total, $gtotal, $active, $id
        ]);

        if ($pay_amount < $gtotal && $pay_amount > 0) {
            return redirect('updatebilling/' . $id)->with('errUpdateCategoryInMsg', 'Pay Amount Must be Greater than Grand Total');
        } else {
            if ($result != false) {
                return redirect('updatebilling/' . $id)->with('updateCategoryInMsg', 'Bill Updated Successfully');
            } else {
                return redirect('updatebilling/' . $id)->with('errUpdateCategoryInMsg', 'Bill not Updated');
            }
        }
        return view('billing.updatebilling');
    }

    public function deleteBilling($id)
    {
        $data = DB::delete('delete from billing where id = ?', [$id]);

        if ($data != false) {
            return redirect('/billinglist')->with('deleteCategoryInMsg', 'Bill Deleted Successfully');
        } else {
            return redirect('/billinglist')->with('errDeleteCategoryInMsg', 'Bill not Deleted');
        }
        return view('billing.billinglist');
    }

    public function getOrderByOrderId(Request $request)
    {
        $orderid = $request->order_id;
        $orders = DB::table('orders')->where('order_id', $orderid)->get();
        return $orders;
    }
    public function getOrderId(Request $request)
    {
        $orderid = $request->id;
        $orders = DB::table('orders')->where('id', $orderid)->get();
        return $orders;
    }
    public function getItemId(Request $request)
    {
        $itemid = $request->id;
        $items = DB::table('food_item')->where('id', $itemid)->get();
        return $items;
    }

    public function getItemNameById(Request $request)
    {
        $item_code = $request->item_code;
        $items = DB::table('food_item')
            ->select('*')
            ->where(['item_code' => $item_code])
            ->get();

        return $items;
    }

    public function getItemPriceById(Request $request)
    {
        $item_id = $request->item_id;
        $items = DB::table('orders')
            ->join('food_item', 'food_item.id', '=', 'orders.item_id')
            ->sum('food_item.price');

        return $items;
    }

    public function getCGSTandSGST(Request $request)
    {
        $item_id = $request->item_id;
        $total = DB::table('orders')
            ->join('food_item', 'food_item.id', '=', 'orders.item_id')
            ->sum('food_item.price');
        $cgst = ($total * 2.5) / 100;
        $sgst = ($total * 2.5) / 100;
        $gst =  $cgst + $sgst;
        $total1 = $total + $gst;
        return $total1;
    }

    public function getCGST(Request $request)
    {
        $item_id = $request->item_id;
        $total = DB::table('orders')
            ->join('food_item', 'food_item.id', '=', 'orders.item_id')
            ->sum('food_item.price');
        $cgst = ($total * 2.5) / 100;

        return $cgst;
    }

    public function getSGST(Request $request)
    {
        $item_id = $request->item_id;
        $total = DB::table('orders')
            ->join('food_item', 'food_item.id', '=', 'orders.item_id')
            ->sum('food_item.price');

        $sgst = ($total * 2.5) / 100;

        return $sgst;
    }

    public function getDiscount(Request $request)
    {

        $total = DB::table('billing')
            ->join('orders', 'orders.id', '=', 'billing.order_id')
            ->join('food_item', 'food_item.id', '=', 'orders.item_id')
            ->sum('food_item.price');
        $discount = $request->discount;
        $cgst = ($total * 2.5) / 100;
        $sgst = ($total * 2.5) / 100;
        $gst =  $cgst + $sgst;
        $tax_amount = $total + $gst;
        $discount1 = ($discount / 100);
        $tax_amount1 = ($tax_amount - ($total * $discount1));
        // $total3 = $tax_amount - $total2;
        return $tax_amount1;
    }

    public function getQuantity(Request $request)
    {
        $item_id = $request->item_id;
        $items =  DB::table('orders')
            ->join('food_item', 'food_item.id', '=', 'orders.item_id')
            ->count();

        return $items;
    }

    public function getBillNo()
    {
        $bill_data = DB::table('billing')
            ->select('bill_no')->orderBy('id', 'DESC')->get();
        return $bill_data;
    }

    public function addAllItems(Request $request)
    {
        $i_id = $request->item_id;
        $oid = $request->order_id;
        $qty = $request->quantity;
        $amt = $request->amount;
        $active = $request->active;


        $results = DB::insert('insert into order_detail(item_id,order_id,quantity,amount,active) 
        values (?,?,?,?,?)', [
            $i_id, $oid, $qty, $amt, $active
        ]);

        if ($results != false) {
            return 1;
        } else {
            return 0;
        }
    }

    public function viewBilling($id)
    {
        $singlebill = DB::table('billing')->where('id', $id)->first();
        $order = DB::table('orders')->where('id', $singlebill->order_id)->first();
        $table = DB::table('tables')->where('id', $order->table_id)->first();
        $bill_data = DB::table('billing')
            ->join('orders', 'orders.id', '=', 'billing.order_id')
            ->join('order_detail', 'order_detail.order_id', '=', 'billing.order_id')
            ->join('food_item', 'food_item.id', '=', 'order_detail.item_id')
            ->join('tables', 'tables.id', '=', 'orders.table_id')
            ->select(
                'tables.name',
                'billing.bill_no',
                'billing.bill_date',
                'billing.discount',
                'billing.discount_value',
                'billing.cgst',
                'billing.sgst',
                'billing.grand_total',
                'billing.total',
                'food_item.name',
                'food_item.price',
                'order_detail.quantity',
                'order_detail.amount'
            )
            ->where(['billing.id' => $id])
            ->get();
        return view('billing.viewbilling', ['singlebill' => $singlebill, 'bill_data' => $bill_data, 'table' => $table]);
    }
}
