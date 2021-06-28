<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderAPIController extends Controller
{
    public function addOrder(Request $request)
    {
        $order_no = $request->order_no;
        $active = $request->active;
        $uid = $request->user_id;

        $results = DB::insert('insert into orders(order_no,active,user_id) values
        (?,?,?)', [$order_no,$active,$uid]);

        if ($results) 
       {
            $response['order_no']=$order_no;
            $response['active']=$active;
            $response['error']="000";
            $response['message']="Add Order Successfully...!";
            return response()->json($response);
           
       } 
       else 
       {
            $response['error']="000";
            $response['message']="Not Add Successfully...!";
            return response()->json($response);
       }
    
    }

    public function getOrderId()
    {
        $results= DB::table('orders')
            ->select('Id','order_no')
            ->orderBy('Id','desc')->first();

        if ($results) 
        {
            return response()->json($results, 200);
            
        } 
        else 
        {
            return response()->json($results, 400);
        }
    }

    public function updateOrderId(Request $request, $id)
    {
        $otype = $request->order_type;
        $ostatus = $request->order_status;

        $results = DB::update('update orders set order_type = ?, order_status = ?
            where id = ?', [$otype, $ostatus, $id]);
        
            if($results) 
            {
                $response['id']=$id;
                $response['error']="204";
  	            $response['message']="Update Order Successful!";
                return response()->json($response);
            } 
            else 
            {
                $response['id']=$id;
                $response['error']="000";
  	            $response['message']="Update Order Failed!";
                return response()->json($response);
            }

    }

    public function updateStatus(Request $request, $id)
    {
        $ostatus = $request->order_status;
        $pstatus = $request->payment_status;

        $results = DB::update('update orders set order_status = ?,  payment_status = ?
            where id = ?', [$ostatus, $pstatus, $id]);
        
            if($results) 
            {
                $response['id']=$id;
                $response['error']="204";
  	            $response['message']="Update Order Successful!";
                return response()->json($response);
            } 
            else 
            {
                $response['id']=$id;
                $response['error']="000";
  	            $response['message']="Update Order Failed!";
                return response()->json($response);
            }
    }

    public function getOrder()
    {
        $results= DB::table('orders')
            ->select('Id','order_no','order_type')
            ->orderBy('Id','desc')->first();

        if ($results) 
        {
            return response()->json($results, 200);
            
        } 
        else 
        {
            return response()->json($results, 400);
        }
    }

    public function addOrderDetail(Request $request)
    {
        $i_id = $request->item_id;
        $o_id = $request->order_id;
        $qty = $request->quantity;
        $amt = $request->amount;
        $active = $request->active;

        $results = DB::insert('insert into order_detail(item_id,order_id,quantity,
        amount,active) values
        (?,?,?,?,?)', [$i_id,$o_id,$qty,$amt,$active]);

        if ($results) 
       {
            $response['item_id']=$i_id;
            $response['order_id']=$o_id;
            $response['quantity']=$qty;
            $response['amount']=$amt;
            $response['active']=$active;
            $response['error']="000";
            $response['message']="Add Order Detail Successfully...!";
            return response()->json($response);
           
       } 
       else 
       {
            $response['error']="000";
            $response['message']="Not Add Successfully...!";
            return response()->json($response);
       }
    }

    public function addBillDetail(Request $request)
    {
        $b_no = $request->bill_no;
        $b_date = $request->bill_date;
        $o_id = $request->order_id;
        $g_total = $request->grand_total;
        $active = $request->active;
    
        $results = DB::insert('insert into billing(bill_no,bill_date,order_id,grand_total,
        active) values
        (?,?,?,?,?)', [$b_no,$b_date,$o_id,$g_total,$active]);

        if ($results) 
       {
            $response['bill_no']=$b_no;
            $response['bill_date']=$b_date;
            $response['order_id']=$o_id;
            $response['grand_total']=$g_total;
            $response['active']=$active;
            $response['error']="000";
            $response['message']="Add Bill Detail Successfully...!";
            return response()->json($response);
           
       } 
       else 
       {
            $response['error']="000";
            $response['message']="Not Add Successfully...!";
            return response()->json($response);
       }
    }

    public function getBillNo()
    {
        $results = DB::table('billing')->select('bill_no')->orderBy('id','desc')->first();

        if ($results) 
        {
            return response()->json($results, 200);
            
        } 
        else 
        {
            return response()->json($results, 400);
        }
    }
}
