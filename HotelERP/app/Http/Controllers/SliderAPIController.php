<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderAPIController extends Controller
{
    public function displaySliderImage(Request $request)
    {
        $cat_image = $request->slider_image;
       

        $filename = "";

        if($request->hasFile('slider_image'))
        {
            $filename = $request->slider_image->getClientOriginalName();

            if($request->slider_image)
            {
                $file_path = $request->slider_image->storeAs('images2',$filename,'public');
            }
            
        }


        $results = DB::select("select server_url_image from sliders");
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
