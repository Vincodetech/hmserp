<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    
    public function foodCategoryList()
    {
        if(request()->ajax())
        {
                $data = DB::table('food_category')
                        ->select('id','category_image', 'name', 'category_type', 'category_quantity', 'active')
                        ->get();
            
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('category_image', function ($data) { 
                $url= asset('/storage/'.$data->category_image);
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
     
                           $btn = '<a href="'.url('updatefoodcategory/'.$data->id).'"> 
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="'.url('deletefoodcategory/'.$data->id).'" class="delete">
                           <i class="fa fa-trash" aria-hidden="true"></i></a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['category_image','active','Action'])->make(true);
        }
        $category_name = DB::table('food_category')
                        ->select('name')
                        ->groupBy('name')
                        ->orderBy('name', 'ASC')
                        ->get();
        $result = DB::table('food_category')->select("*")->get();                
        return view('restaurent.foodcategorylist', compact('category_name'), ['result' => $result]);
    }

    public function addFoodCategory()
    {
        return view('restaurent.addfoodcategory');
    }

    public function addPostFoodCategory(Request $request)
    {
        $cat_name = $request->name;
        $category_type = $request->category_type;
        $cat_image = $request->category_image;
        $category_quantity = $request->category_quantity;
        $active = $request->active;

        $file_path = "";
        $server_url = "";

        if($request->hasFile('category_image'))
        {
            $filename = $request->category_image->getClientOriginalName();

            if($request->category_image)
            {
                $file_path = $request->category_image->storeAs('images1',$filename,'public');
                $server_url = "http://192.168.42.235:8000/storage/" . $file_path;
            }
            
        }

       
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into food_category(name,category_type,category_image,
        server_url_image,category_quantity,active) 
        values (?,?,?,?,?,?)', [$cat_name,$category_type,$file_path,$server_url,$category_quantity,$active]);

        if ($results == 1) {
            return redirect('/addfoodcategory')->with('roleSccssMsg', 'Food Category Added Successfully.');
        } else {
            return redirect('/addfoodcategory')->with('roleErrMsg', 'Food Category add to failed!!');
        }
       return view('restaurent.addfoodcategory');
    }

    public function updateFoodCategory($id)
    {
        $singlefoodcategory = DB::table('food_category')->where('id', $id)->first();
        return view('restaurent.updatefoodcategory',['singlefoodcategory' => $singlefoodcategory]);
    }   
    
    public function updatePostFoodCategory(Request $request, $id)
    {
        $data = DB::table('food_category')->where('id', $id)->first();
        $cat_name = $request->name;
        $category_type = $request->category_type;
        $cat_image = $request->category_image;
        $category_quantity = $request->category_quantity;
        $active = $request->active;

        $server_url = $data->server_url_image;
        $file_path = $data->category_image;

        if($request->hasFile('category_image'))
        {
            $filename = $request->category_image->getClientOriginalName();

            if($request->category_image)
            {
                $file_path = $request->category_image->storeAs('images1',$filename,'public');
                $server_url = "http://192.168.42.235:8000/storage/" . $file_path;
            }
            
        }

      
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update food_category set name = ?, category_type = ?, category_image = ?, 
        server_url_image = ?, category_quantity = ?, active = ? where id = ?', [$cat_name, $category_type, $file_path, 
        $server_url, $category_quantity, $active, $id]);
       
        if ($result == 1) {
            return redirect('updatefoodcategory/'. $id)->with('updateCategoryInMsg', 'Food Category Updated Successfully');
        } else {
            return redirect('updatefoodcategory/'. $id)->with('errUpdateCategoryInMsg', 'Food Category not Updated');
        }
        return view('restaurent.updatefoodcategory');
    }

    public function deleteFoodCategory($id)
    {
        $data = DB::delete('delete from food_category where id = ?', [$id]);

        if ($data == 1) {
            return redirect('/foodcategory')->with('deleteCategoryInMsg', 'Food Category Deleted Successfully');
        } else {
            return redirect('/foodcategory')->with('errDeleteCategoryInMsg', 'Food Category not Deleted');
        }
        return view('restaurent.foodcategorylist');
    }
}
