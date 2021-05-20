<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    public function billingList()
    {
        if(request()->ajax())
        {
            $data = DB::table('billing')
                    ->join('orders', 'orders.id', '=', 'billing.orderid')
                    ->join('users','users.id', '=', 'orders.user_id')
                    ->join('food_item','food_item.id', '=', 'orders.item_id')
                    ->select('billing.id','billing.bill_no', 'billing.bill_date','users.user_name',
                    'users.phone','food_item.name','food_item.price', 'billing.grand_total','billing.active')
                    ->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('active', function($data){
                if($data->active == '1')
                {
                    $btn1 = '<span class="badge badge-success">Active</span>';
                }
                else
                {
                    $btn1 = '<span class="badge badge-danger">InActive</span>';
                }
                 return $btn1;
            })
        ->addColumn('Action', function($data){
     
                           $btn = '<a href="'.url('viewbilling/'.$data->id).'">
                           <i class="fa fa-eye" aria-hidden="true"></i></a>
                           <a href="'.url('updatebilling/'.$data->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="'.url('deletebilling/'.$data->id).'" class="delete">
                           <i class="fa fa-trash" aria-hidden="true"></i></a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['active','Action'])->make(true);
        }
        $bill = DB::table('billing')
                        ->select('bill_no')
                        ->groupBy('bill_no')
                        ->orderBy('bill_no', 'ASC')
                        ->get();
                        
        $result = DB::table('billing')->select("*")->get(); 
                       
        return view('billing.billinglist', compact('bill'), ['result' => $result]);

    }

    public function addBilling()
    {
        $allbill = DB::table('billing')
                    ->join('orders', 'orders.id', '=', 'billing.orderid')
                    ->join('users','users.id', '=', 'orders.user_id')
                    ->join('food_item','food_item.id', '=', 'orders.item_id')
                    ->select('billing.*','orders.orderid','users.user_name','food_item.name','orders.order_type','food_item.price','orders.id')
                    ->get();
        // $allbill = DB::select('select * from billing');
        return view('billing.addbilling',['allbill' => $allbill]);
    }

    public function addPostBilling(Request $request)
    {
        $bno = $request->bill_no;
        $bdate = $request->bill_date;
        $oid = $request->orderid;
        $discount = $request->discount;
        $quantity = $request->quantity;
        $cgst = $request->cgst;
        $sgst = $request->sgst;
        $tax_amount = $request->taxable_amount;
        $pay_amount = $request->payable_amount;
        $ch_amount = $request->change_amount;
        $gtotal = $request->grand_total;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into billing(bill_no,bill_date,orderid,discount,quantity,
        cgst,sgst,taxable_amount,payable_amount,change_amount,grand_total,active) 
        values (?,?,?,?,?,?,?,?,?,?,?,?)', [$bno,$bdate,$oid,$discount,$quantity,$cgst,$sgst,
        $tax_amount,$pay_amount,$ch_amount,$gtotal,$active]);

        if ($pay_amount < $gtotal && $pay_amount > 0) {
            return redirect('/addbilling')->with('roleErrMsg', 'Pay Amount Must be Greater than Grand Total');
        } else {
            if($results != false)
            {
                return redirect('/addbilling')->with('roleSccssMsg', 'Bill Added Successfully');
            }
            else
            {
                return redirect('/addbilling')->with('roleErrMsg', 'Bill add to failed!!');
            }
            
        }
       return view('billing.addbilling');
    }

    public function updateBilling($id)
    {
        $singlebill = DB::table('billing')->where('id', $id)->first();
        return view('billing.updatebilling',['singlebill' => $singlebill]);
    }   
    
    public function postUpdateBilling(Request $request, $id)
    {
        $bno = $request->bill_no;
        $bdate = $request->bill_date;
        $oid = $request->order_id;
        $gtotal = $request->grand_total;
        $active = $request->active;
        
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update users set bill_no = ?, bill_date = ?, 
        order_id = ?, grand_total = ?, active = ? where id = ?', [$bno, $bdate, $oid, $gtotal, $active, $id]);

        if ($result != false) {
            return redirect('updatebilling/'. $id)->with('updateCategoryInMsg', 'Bill Updated Successfully');
        } else {
            return redirect('updatebilling/'. $id)->with('errUpdateCategoryInMsg', 'Bill not Updated');
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
        $orderid = $request->orderid;
        $orders = DB::table('orders')->where('orderid', $orderid)->get();    
        return $orders;            
    }

    public function getItemNameById(Request $request)
    {
        $item_id = $request->item_id;
        $items = DB::table('orders')
                ->join('food_item', 'food_item.id', '=', 'orders.item_id')
                ->select('food_item.name','food_item.price', 'orders.order_type')
                ->where(['item_id'=>$item_id])
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
        $cgst = ($total*2.5)/100;
        $sgst = ($total*2.5)/100;
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
        $cgst = ($total*2.5)/100;
        
        return $cgst;            
    }

    public function getSGST(Request $request)
    {
        $item_id = $request->item_id;
        $total = DB::table('orders')
                ->join('food_item', 'food_item.id', '=', 'orders.item_id')
                ->sum('food_item.price');
        
        $sgst = ($total*2.5)/100;
       
        return $sgst;            
    }

    public function getDiscount(Request $request)
    {
        
        $total = DB::table('billing')
                ->join('orders', 'orders.id', '=', 'billing.order_id')
                ->join('food_item', 'food_item.id', '=', 'orders.item_id')
                ->sum('food_item.price');
        $discount = $request->discount;        
        $cgst = ($total*2.5)/100;
        $sgst = ($total*2.5)/100;
        $gst =  $cgst + $sgst;
        $tax_amount = $total + $gst;
        $discount1 = ($discount/100);
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
    
}
