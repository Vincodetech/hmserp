<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;


class UserRoleController extends Controller
{
    public function userRoleList()
    {
        if(request()->ajax())
        {
            $data = DB::table('users_roles')
                    ->select('id','role','active')
                    ->get();
            return datatables()->of($data)
            ->addIndexColumn()
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
     
                           $btn = '<a href="'.url('updateuserrolelist/'.$data->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i></a>
                           <a href="'.url('deleteuserrolelist/'.$data->id).'" class="delete">
                           <i class="fa fa-trash" aria-hidden="true"></i></a>';
                           
                            return $btn;
                           
                    })
            ->rawColumns(['active','Action'])->make(true);
        }
        $name = DB::table('users_roles')
                        ->select('role')
                        ->groupBy('role')
                        ->orderBy('role', 'ASC')
                        ->get();
                        
        $result = DB::table('users_roles')->select("*")->get(); 
                       
        return view('userrole.userrolelist', compact('name'), ['result' => $result]);

    }

    public function addUserRoleList()
    {
        return view('userrole.adduserrole');
    }

    public function addPostUserRoleList(Request $request)
    {
        $userrole = $request->role;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $results = DB::insert('insert into users_roles(role,active) 
        values (?,?)', [$userrole,$active]);

        if ($results != false) {
            return redirect('/adduserrolelist')->with('roleSccssMsg', 'User Role Added Successfully.');
        } else {
            return redirect('/adduserrolelist')->with('roleErrMsg', 'User Role add to failed!!');
        }
       return view('userrole.adduserrole');
    }

    public function updateUserRoleList($id)
    {
        $singlefooditem = DB::table('users_roles')->where('id', $id)->first();
        return view('userrole.updateuserrole',['singlefooditem' => $singlefooditem]);
    }   
    
    public function postUpdateUserRoleList(Request $request, $id)
    {
        $userrole = $request->role;
        $active = $request->active;
        
        if($active != '1')
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update users_roles set role = ?, active = ? where id = ?', [$userrole, $active, $id]);

        if ($result != false) {
            return redirect('updateuserrolelist/'. $id)->with('updateCategoryInMsg', 'User Role Updated Successfully');
        } else {
            return redirect('updateuserrolelist/'. $id)->with('errUpdateCategoryInMsg', 'User Role not Updated');
        }
        return view('userrole.updateuserrole');
    }

    public function deleteUserRoleList($id)
    {
        $data = DB::delete('delete from users_roles where id = ?', [$id]);

        if ($data != false) {
            return redirect('/userrolelist')->with('deleteCategoryInMsg', 'User Role Deleted Successfully');
        } else {
            return redirect('/userrolelist')->with('errDeleteCategoryInMsg', 'User Role not Deleted');
        }
        return view('userrole.userrolelist');
    }
}
