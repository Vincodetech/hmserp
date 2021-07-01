<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getCartData(Request $request)
    {
        $name = $request->name;
        $qty = $request->quantity;
        $price = $request->price;
        $amt =  $request->amount;
        $i_id = $request->item_id;
        $active = $request->active;

        $results = DB::select("select name, quantity, price, amount, item_id, active
         from cart");
        if ($results) 
        {
            return response()->json($results, 200);
            
        } 
        else 
        {
            return response()->json($results, 400);
        }
    }

    public function addCartData(Request $request)
    {
        $name = $request->name;
        $qty = $request->quantity;
        $price = $request->price;
        $amt =  $request->amount;
        $i_id = $request->item_id;
        $active = $request->active;

        $results = DB::insert('insert into cart(name,quantity,price,amount,item_id,active)
        values (?,?,?,?,?,?)', [$name,$qty,$price,$amt,$i_id,$active]);

        if ($results) 
       {
            $response['name']=$name;
            $response['quantity']=$qty;
            $response['price']=$price;
            $response['amount']=$amt;
            $response['item_id']=$i_id;
            $response['active']=$active;
            $response['error']="000";
            $response['message']="Add Cart Data Successfully...!";
            return response()->json($response);
           
       } 
       else 
       {
            $response['error']="000";
            $response['message']="Not Add Successfully...!";
            return response()->json($response);
       }
    }

    public function updateCartData(Request $request, $id)
    {
        $name = $request->name;
        $qty = $request->quantity;
        $price = $request->price;
        $amt =  $request->amount;
        $i_id = $request->item_id;
        $active = $request->active;

        $results = DB::update('update cart set name = ?, quantity = ?, price = ?,
            amount = ?, item_id = ?, active = ?
            where id = ?', [$name, $qty, $price, $amt, $i_id, $active, $id]);
        
            if($results) 
            {
                
                $response['error']="204";
  	            $response['message']="Update Cart Data Successful!";
                return response()->json($response);
            } 
            else 
            {
                
                $response['error']="000";
  	            $response['message']="Update Cart Data Failed!";
                return response()->json($response);
            }
    }

    public function deleteCartData($id)
    {
        $result = DB::delete('delete from cart where id = ?', [$id]);

        if($result) 
            {
                $response['error']="000";
  	            $response['message']="Delete Cart Data Successful!";
                return response()->json($response);
            } 
            else 
            {
                $response['error']="000";
  	            $response['message']="Delete Cart Data Failed!";
                return response()->json($response);
            }
    }
}
