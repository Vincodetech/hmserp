<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Storage;
use File;
class ItemController extends Controller
{
    // public function upload(Request $request)
    // {
    //     if($request->hasFile('item_image'))
    //     {
    //         $filename = $request->item_image->getClientOriginalName();
    //         if($filename1->item_image)
    //         {
    //             \Storage::delete('/public/img/'.$filename1->item_image);
    //         }
    //         $request->item_image->storeAs('img',$filename,'public');
    //         $filename1->update(['item_image'=>$filename]);
    //         session()->put('message','Image Uploaded...');
    //     }
    //     return redirect()->back();
    // }
    
    public function foodItemList()
    {
        $result = DB::table('food_item')->paginate(5);
        return view('restaurent.fooditemlist',['result' => $result]);
    }

    public function addFoodItem()
    {
        $allcategory = DB::select('select * from food_category');
        return view('restaurent.addfooditem',['allcategory' => $allcategory]);
    }

    public function addPostFoodItem(Request $request)
    {
        $item_name = $request->name;
        $slug = $request->slug;
        $item_image = $request->item_image;
        $food_category = $request->category_id;
        $description = $request->description;
        $unit = $request->unit;
        $price = $request->price;
        $quantity = $request->quantity;
        $item_type = $request->item_type;
        $active = $request->active;
        
        if($request->hasFile('item_image'))
        {
            $filename = $request->item_image->getClientOriginalName();
            if(DB::table('food_item')->item_image)
            {
                \Storage::delete('/public/images/'.DB::table('food_item')->item_image);
            }
            $request->item_image->storeAs('images',$filename,'public');
            DB::table('food_item')->update(['item_image'=>$filename]);
            session()->put('message','Image Uploaded...');
        }
        

        if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into food_item(name,slug,item_image,category_id,description,
        unit,price,quantity,item_type,active) 
        values (?,?,?,?,?,?,?,?,?,?)', [$item_name,$slug,$item_image,$food_category,
        $description,$unit,$price,$quantity,$item_type,$active]);

        if ($results != false) {
            return redirect('/addfooditem')->with('roleSccssMsg', 'Food Item Added Successfully.');
        } else {
            return redirect('/addfooditem')->with('roleErrMsg', 'Food Item add to failed!!');
        }
       return view('restaurent.addfooditem');
    }

    public function updateFoodItem($id)
    {
        $singlefoodcategory = DB::table('food_category')->where('id', $id)->first();
        return view('restaurent.updatefoodcategory',['singlefoodcategory' => $singlefoodcategory]);
    }   
    
    public function updatePostFoodItem(Request $request, $id)
    {
        $cat_name = $request->name;
        $category_type = $request->category_type;
        $category_quantity = $request->category_quantity;
        $active = $request->active;
        
        if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update food_category set name = ?, category_type = ?, 
        category_quantity = ?, active = ? where id = ?', [$cat_name, $category_type, $category_quantity, $active, $id]);

        if ($result != false) {
            return redirect('foodcategory')->with('updateStockInMsg', 'Food Category Updated Successfully');
        } else {
            return redirect('updatefoodcategory/'. $id)->with('errUpdateStockInMsg', 'Food Category not Updated');
        }
    }

    public function deleteFoodItem($id)
    {
        $data = DB::delete('delete from food_category where id = ?', [$id]);

        if ($data != false) {
            return redirect('/foodcategory')->with('deleteStockInMsg', 'Food Category Deleted Successfully');
        } else {
            return redirect('/foodcategory')->with('errDeleteStockInMsg', 'Food Category not Deleted');
        }

    }
}
