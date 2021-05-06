<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function isAuthenticate(Request $request)
    {
        $email = $request->user_name;
        $pass =  $request->password;

        $results = DB::table('users')
            ->where('user_name', $email)
            ->where('password', $pass)
            ->first();
        if ($results) {
           // Session::put('admin_name', $results->user_name);
            //Session::put('admin_id', $results->id);
            $request->session()->put('admin_name', $results->user_name);
            $request->session()->put('admin_id', $results->id);
            return redirect('/dashboard');
        } else {
            $request->session()->put('message', 'Email or Password Invalid');
            return redirect('/admin');
        }

    }

    public function usersList()
    {
        if(request()->ajax())
        {
                $data = DB::table('users')
                        ->select('id','user_name', 'email', 'phone', 'user_role', 'active')
                        ->get();
            
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('user_role', function ($data) { 
                $sql = DB::table('users_roles')->where('id',$data->user_role)->first();
                echo $sql->role;

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
     
                           $btn = '<a href="'.url('updateuserslist/'.$data->id).'" class="edit btn btn-primary btn-sm">Edit</a>
                           <a href="'.url('deleteuserslist/'.$data->id).'" class="delete btn btn-danger btn-sm">Delete</a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['user_role','active','Action'])->make(true);
        }
        $item_name = DB::table('users')
                        ->select('user_name')
                        ->groupBy('user_name')
                        ->orderBy('user_name', 'ASC')
                        ->get();
        $result = DB::table('users')->select("*")->get();                
        return view('users.userslist', compact('item_name'), ['result' => $result]);

    }

    public function addUsersList()
    {
        $allcategory = DB::select('select * from users_roles');
        return view('users.addusers',['allcategory' => $allcategory]);
    }

    public function addPostUsersList(Request $request)
    {
        $uname = $request->user_name;
        $uemail = $request->email;
        $uphone = $request->phone;
        $userrole = $request->user_role;
        $active = $request->active;
        
        if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into users(user_name,email,phone,user_role,active) 
        values (?,?,?,?,?)', [$uname,$uemail,$uphone,$userrole,$active]);

        if ($results != false) {
            return redirect('/adduserslist')->with('roleSccssMsg', 'User Added Successfully.');
        } else {
            return redirect('/adduserslist')->with('roleErrMsg', 'User add to failed!!');
        }
       return view('users.addusers');
    }

    public function updateUsersList($id)
    {
        $singlefooditem = DB::table('users')->where('id', $id)->first();
        $allcategory = DB::select('select * from users_roles');
        return view('users.updateusers',['singlefooditem' => $singlefooditem,
         'allcategory' => $allcategory]);
    }   
    
    public function postUpdateUsersList(Request $request, $id)
    {
        $uname = $request->user_name;
        $uemail = $request->email;
        $uphone = $request->phone;
        $userrole = $request->user_role;
        $active = $request->active;
        
        if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update users set user_name = ?, email = ?, 
        phone = ?, user_role = ?, active = ? where id = ?', [$uname, $uemail, $uphone, $userrole, $active, $id]);

        if ($result != false) {
            return redirect('userslist')->with('updateCategoryInMsg', 'User Updated Successfully');
        } else {
            return redirect('updateuserslist/'. $id)->with('errUpdateCategoryInMsg', 'User not Updated');
        }
        return view('users.updateusers');
    }

    public function deleteUsersList($id)
    {
        $data = DB::delete('delete from users where id = ?', [$id]);

        if ($data != false) {
            return redirect('/userslist')->with('deleteCategoryInMsg', 'User Deleted Successfully');
        } else {
            return redirect('/userslist')->with('errDeleteCategoryInMsg', 'User not Deleted');
        }
        return view('users.userslist');
    }
}
