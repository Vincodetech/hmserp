<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Illuminate\Http\Request;
use App\Models\User;

class CategoryController extends Controller
{
    
    // public function index()
    // {
    //     return view('restaurent.foodcategorylist', [
    //         'food_category' => DB::table('food_category')->paginate(5)
    //     ]);
    // }

    public function foodCategoryList()
    {
        $result = DB::table('food_category')->paginate(5);
        return view('restaurent.foodcategorylist',['result' => $result]);
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

        $filename = "";

        if($request->hasFile('category_image'))
        {
            $filename = $request->category_image->getClientOriginalName();

            if($request->category_image)
            {
                $request->category_image->storeAs('images1',$filename,'public');
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
        $results = DB::insert('insert into food_category(name,category_type,category_image,category_quantity,active) 
        values (?,?,?,?,?)', [$cat_name,$category_type,$filename,$category_quantity,$active]);

        if ($results != false) {
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
        $cat_name = $request->name;
        $category_type = $request->category_type;
        $cat_image = $request->category_image;
        $category_quantity = $request->category_quantity;
        $active = $request->active;

        $filename = "";

        if($request->hasFile('category_image'))
        {
            $filename = $request->item_image->getClientOriginalName();

            if($request->item_image)
            {
                $request->item_image->storeAs('images1',$filename,'public');
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
        $result = DB::update('update food_category set name = ?, category_type = ?, category_image = ?, 
        category_quantity = ?, active = ? where id = ?', [$cat_name, $category_type, $filename, $category_quantity, $active, $id]);

        if ($result != false) {
            return redirect('foodcategory')->with('updateCategoryInMsg', 'Food Category Updated Successfully');
        } else {
            return redirect('updatefoodcategory/'. $id)->with('errUpdateCategoryInMsg', 'Food Category not Updated');
        }
    }

    public function deleteFoodCategory($id)
    {
        $data = DB::delete('delete from food_category where id = ?', [$id]);

        if ($data != false) {
            return redirect('/foodcategory')->with('deleteCategoryInMsg', 'Food Category Deleted Successfully');
        } else {
            return redirect('/foodcategory')->with('errDeleteCategoryInMsg', 'Food Category not Deleted');
        }

    }
}
