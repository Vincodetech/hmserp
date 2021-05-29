<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodCategoryAPIController extends Controller
{
    public function displayFoodCategory(Request $request)
    {
        $cat_image = $request->category_image;
        $cat_name =  $request->name;
        $cat_type =  $request->category_type;

        $filename = "";

        if($request->hasFile('category_image'))
        {
            $filename = $request->category_image->getClientOriginalName();

            if($request->category_image)
            {
                $file_path = $request->category_image->storeAs('images1',$filename,'public');
            }
            
        }


        $results = DB::select("select server_url_image, name from food_category where 
        category_type = '$cat_type'");
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
