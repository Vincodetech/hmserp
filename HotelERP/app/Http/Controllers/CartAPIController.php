<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartAPIController extends Controller
{
    public function addCartItem(Request $request)
    {
        $i_id = $request->item_id;
        $o_id = $request->order_id;
        $qty = $request->quantity;
        $amt = $request->amount;

        $results = DB::insert('insert into order_detail(item_id,order_id,quantity,amount)
        values (?,?,?,?)', [$i_id,$o_id,$qty,$amt]);

        if ($results) 
       {
            $response['item_id']=$i_id;
            $response['order_id']=$o_id;
            $response['quantity']=$qty;
            $response['amount']=$amt;
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
}
