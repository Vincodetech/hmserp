<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Storage;
use File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
    

    public function foodItemList(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->filter_food_category))
            {
                $data = DB::table('food_item')
                        ->select('id','item_image', 'name', 'category_id', 'item_type', 'active')
                        ->where('category_id', $request->filter_food_category)
                        ->where('item_type', $request->filter_item_type)
                        ->get();
            }
            else
            {
                $data = DB::table('food_item')
                        ->select('id','item_image', 'name', 'category_id', 'item_type', 'active')
                        ->get();
            }
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('item_image', function ($data) { 
                $url= asset('/storage/images/'.$data->item_image);
                return '<img src="'.$url.'" border="0" width="50" class="img-rounded" align="center" />';
            })
            ->addColumn('category_id', function ($data) { 
            
                    $sql = DB::table('food_category')->where('id',$data->category_id)->first();
                    return $sql->name;
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
                
                    $btn = '<a href="'.url('updatefooditem/'.$data->id).'">
                           <i class="fa fa-edit"></i></a>
                           <a href="'.url('deletefooditem/'.$data->id).'" class="delete">
                            <i class="fa fa-trash"></i></a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['item_image','category_id','active','Action'])->make(true);
        }
        $item_name = DB::table('food_item')
                        ->select('name')
                        ->groupBy('name')
                        ->orderBy('name', 'ASC')
                        ->get();
        $result = DB::table('food_item')->select("*")->get();                
        $allcategory = DB::select('select * from food_category');                
        return view('restaurent.fooditemlist', compact('item_name'), ['allcategory' => $allcategory], ['result' => $result]);
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
        
       $filename = "";
       // if($request->hasFile('item_image'))
       //  {
       //      $file = $request->file('item_image');
       //      $extension = $file->getClientOriginalExtension();
       //      $filename = time() . '.' . $extension;
       //      $file->move('/storage/images/', $filename);
       //      $request->item_image = $filename;
       //      $file->store($filename);
       // // $path->save(); 
       //  }

        // $data = DB::table('food_item');  
        // if($files=$request->file('item_image'))
        // {  
        //     $name=$files->getClientOriginalName();  
        //     $files->move('images',$name);  
        //     $data->item_image=$name;  
        // }  
        // $data->DB::table('food_item')->save();  
        if($request->hasFile('item_image'))
        {
            $filename = $request->item_image->getClientOriginalName();

            if($request->item_image)
            {
                $request->item_image->storeAs('images',$filename,'public');
            }
            
           // $path->save();
           // $request->item_image->update(['item_image'=>$filename]);
           // session()->put('message','Image Uploaded...');
        }
    //    if( $request->hasFile( 'item_image' ) ) 
    //     {
    //         $destinationPath = storage_path( 'app/public/images' );
    //         $file = $request->item_image;
    //         $fileName = time() . '.'.$file->clientExtension();
    //         $file->move( $destinationPath, $fileName );
    //     }

        // $request->validate([
        //     'item_image' => 'required|item_image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        // ]);
    
        // $imageName = time().'.'.$request->item_image->extension();
     
        // $request->item_image->move(public_path('images'), $imageName);
  
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into food_item(name,slug,item_image,category_id,description,
        unit,price,quantity,item_type,active) 
        values (?,?,?,?,?,?,?,?,?,?)', [$item_name,$slug,$filename,$food_category,
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
        $singlefooditem = DB::table('food_item')->where('id', $id)->first();
        $allcategory = DB::select('select * from food_category');
        return view('restaurent.updatefooditem',['singlefooditem' => $singlefooditem,
         'allcategory' => $allcategory]);
    }   
    
    public function updatePostFoodItem(Request $request, $id)
    {
        $data = DB::table('food_item')->where('id', $id)->first();
        $item_name = $request->name;
        $slug = $request->slug;
        $item_image = $request->item_image;
        $food_category = $request->category_id;
        $description = $request->description;
        $unit = $request->unit;
        $price = $request->price;
        $quantity = $request->quantity;
        $item_type = $request->item_type;
        $active = $request->active == '1' ? '1' : '0';
 
        $filename = $data->item_image;

        if($request->hasFile('item_image'))
        {
            $filename = $request->item_image->getClientOriginalName();

            if($request->item_image)
            {
                $request->item_image->storeAs('images',$filename,'public');
            }
            
           // $path->save();
           // $request->item_image->update(['item_image'=>$filename]);
           // session()->put('message','Image Uploaded...');
        }

        // if($active != '1')
        // {
        //     $active = 0;
        // }
        // else
        // {
        //     $active = 1;
        // }
        $result = DB::update('update food_item set name = ?, slug = ?, item_image = ?,
        category_id = ?, description = ?, unit = ?, price = ?, quantity = ?,
        item_type = ?, active = ? where id = ?', [$item_name, $slug, $filename, $food_category,
         $description, $unit, $price, $quantity, $item_type, $active, $id]);

        if ($result != false) {
            return redirect('updatefooditem/'. $id)->with('updateItemInMsg', 'Food Item Updated Successfully');
        } else {
            return redirect('updatefooditem/'. $id)->with('errUpdateItemInMsg', 'Food Item not Updated');
        }
        return view('restaurent.updatefooditem');
    }

    public function deleteFoodItem($id)
    {
        $data = DB::delete('delete from food_item where id = ?', [$id]);

        if ($data != false) {
            return redirect('/fooditem')->with('deleteItemInMsg', 'Food Item Deleted Successfully');
        } else {
            return redirect('/fooditem')->with('errDeleteItemInMsg', 'Food Item not Deleted');
        }
        return view('restaurent.fooditemlist');
    }

   
        
}
