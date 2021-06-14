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

        $results = DB::insert('insert into orders(order_no,active) values
        (?,?)', [$order_no,$active]);

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
            ->select('Id','active')
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
}
