<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodItemAPIController extends Controller
{
    public function getFoodItems(Request $request)
    {
        $item_name =  $request->name;
        $item_image = $request->item_image;
        $desc = $request->description;
        $price = $request->price;
        $cat_type =  $request->category_id;

        $filename = "";

        if($request->hasFile('item_image'))
        {
            $filename = $request->item_image->getClientOriginalName();

            if($request->item_image)
            {
                $file_path = $request->item_image->storeAs('images1',$filename,'public');
            }
            
        }


        $results = DB::select("select id, name, description, price, server_url_image
         from food_item where category_id = '$cat_type'");
        if ($results) 
        {
            return response()->json($results, 200);
            
        } 
        else 
        {
            return response()->json($results, 400);
        }

    }

    public function getCafeItems(Request $request)
    {
        
            $item_name =  $request->name;
            $item_image = $request->item_image;
            $desc = $request->description;
            $price = $request->price;
            $cat_type =  $request->category_id;
    
            $filename = "";
    
            if($request->hasFile('item_image'))
            {
                $filename = $request->item_image->getClientOriginalName();
    
                if($request->item_image)
                {
                    $file_path = $request->item_image->storeAs('images1',$filename,'public');
                }
                
            }
    
    
            $results = DB::select("select name, description, price, server_url_image
             from food_item where category_id = '$cat_type'");
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
