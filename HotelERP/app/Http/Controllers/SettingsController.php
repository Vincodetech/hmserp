<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;


class SettingsController extends Controller
{
    public function sliderList()
    {
        $result = DB::table('sliders')->paginate(5);
        return view('settings.slider.sliderlist',['result' => $result]);
    }

    public function addSlider()
    {
        return view('settings.slider.addslider');
    }

    public function addPostSlider(Request $request)
    {
        $slider_image = $request->slider_image;
        $active = $request->active;
        
        $filename = "";

        if($request->hasFile('slider_image'))
        {
            $filename = $request->slider_image->getClientOriginalName();

            if($request->slider_image)
            {
                $request->slider_image->storeAs('images2',$filename,'public');
            }
            
           // $path->save();
           // $request->item_image->update(['item_image'=>$filename]);
           // session()->put('message','Image Uploaded...');
        }


        if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into sliders(slider_image,active) 
        values (?,?)', [$filename,$active]);

        if ($results != false) {
            return redirect('/addslider')->with('roleSccssMsg', 'Slider Image Added Successfully.');
        } else {
            return redirect('/addslider')->with('roleErrMsg', 'Slider Image add to failed!!');
        }
       return view('settings.slider.addslider');
    }

    public function updateSlider($id)
    {
        $singleimage = DB::table('sliders')->where('id', $id)->first();
        return view('settings.slider.updateslider',['singleimage' => $singleimage]);
    }   
    
    public function postUpdateSlider(Request $request, $id)
    {
        $slider_image = $request->slider_image;
        $active = $request->active;
        
        $filename = "";

        if($request->hasFile('slider_image'))
        {
            $filename = $request->slider_image->getClientOriginalName();

            if($request->slider_image)
            {
                $request->slider_image->storeAs('images2',$filename,'public');
            }
            
           // $path->save();
           // $request->item_image->update(['item_image'=>$filename]);
           // session()->put('message','Image Uploaded...');
        }    

        if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update sliders set slider_image = ?, active = ? where id = ?', [$filename, $active, $id]);

        if ($result != false) {
            return redirect('/sliderlist')->with('updateCategoryInMsg', 'Slider Image Updated Successfully');
        } else {
            return redirect('updateslider/'. $id)->with('errUpdateCategoryInMsg', 'Slider Image not Updated');
        }
    }

    public function deleteSlider($id)
    {
        $data = DB::delete('delete from sliders where id = ?', [$id]);

        if ($data != false) {
            return redirect('/sliderlist')->with('deleteCategoryInMsg', 'Slider Image Deleted Successfully');
        } else {
            return redirect('/sliderlist')->with('errDeleteCategoryInMsg', 'Slider Image not Deleted');
        }

    }
}
