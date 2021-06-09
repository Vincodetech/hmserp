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
                $url= asset('/storage/'.$data->slider_image);
                return '<img src="'.$url.'" border="0" width="50" class="img-rounded" align="center" />';
            })
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
     
                           $btn = '<a href="'.url('updateslider/'.$data->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="'.url('deleteslider/'.$data->id).'" class="delete">
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
               $file_path = $request->slider_image->storeAs('images2',$filename,'public');
            }
            
        }

        $server_url = "http://192.168.42.249:8000/storage/" . $file_path;

        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into sliders(slider_image,server_url_image,active) 
        values (?,?,?)', [$file_path,$server_url,$active]);

        if ($results == 1) {
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
        $data = DB::table('sliders')->where('id', $id)->first();
        $slider_image = $request->slider_image;
        $active = $request->active;
        
        $filename = $data->slider_image;

        if($request->hasFile('slider_image'))
        {
            $filename = $request->slider_image->getClientOriginalName();

            if($request->slider_image)
            {
                $file_path = $request->slider_image->storeAs('images2',$filename,'public');
            }
            
        }   
        
        $server_url = "http://192.168.42.249:8000/storage/" . $file_path;

        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update sliders set slider_image = ?, server_url_image = ?,
         active = ? where id = ?', [$file_path, $server_url, $active, $id]);

        if ($result == 1) {
            return redirect('updateslider/'. $id)->with('updateCategoryInMsg', 'Slider Image Updated Successfully');
        } else {
            return redirect('updateslider/'. $id)->with('errUpdateCategoryInMsg', 'Slider Image not Updated');
        }
        return view('settings.slider.updateslider');
    }

    public function deleteSlider($id)
    {
        $data = DB::delete('delete from sliders where id = ?', [$id]);

        if ($data == 1) {
            return redirect('/sliderlist')->with('deleteCategoryInMsg', 'Slider Image Deleted Successfully');
        } else {
            return redirect('/sliderlist')->with('errDeleteCategoryInMsg', 'Slider Image not Deleted');
        }
        return view('settings.slider.sliderlist');
    }
}
