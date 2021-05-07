<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;


class SettingsController extends Controller
{
    public function sliderList()
    {
        if(request()->ajax())
        {
            $data = DB::table('sliders')
                    ->select('id','slider_image','active')
                    ->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('slider_image', function ($data) { 
                $url= asset('/storage/images2/'.$data->slider_image);
                return '<img src="'.$url.'" border="0" width="50" class="img-rounded" align="center" />';
            })
            ->addColumn('active', function($row){
                if($row == true)
                {
                    $btn1 = '<span class="badge badge-success">Active</span>';
                }
                else
                {
                    $btn1 = '<span class="badge badge-danger">DeActive</span>';
                }
                 return $btn1;
            })
        ->addColumn('Action', function($data){
     
                           $btn = '<a href="'.url('updateslider/'.$data->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="'.url('deleteslider/'.$data->id).'"
                           onclick="if (!confirm("Are you sure to delete this item?"))
                                  { return false }">
                           <i class="fa fa-trash" aria-hidden="true"></i></a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['slider_image','active','Action'])->make(true);
        }
        $image = DB::table('sliders')
                        ->select('slider_image')
                        ->groupBy('slider_image')
                        ->orderBy('slider_image', 'ASC')
                        ->get();
                        
        $result = DB::table('sliders')->select("*")->get(); 
                       
        return view('settings.slider.sliderlist', compact('image'), ['result' => $result]);

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
        return view('settings.slider.updateslider');
    }

    public function deleteSlider($id)
    {
        $data = DB::delete('delete from sliders where id = ?', [$id]);

        if ($data != false) {
            return redirect('/sliderlist')->with('deleteCategoryInMsg', 'Slider Image Deleted Successfully');
        } else {
            return redirect('/sliderlist')->with('errDeleteCategoryInMsg', 'Slider Image not Deleted');
        }
        return view('settings.slider.sliderlist');
    }
}
