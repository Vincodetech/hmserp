<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;


class UserRoleController extends Controller
{
    public function userRoleList()
    {
        $result = DB::table('users_roles')->paginate(2);
        return view('userrole.userrolelist',['result' => $result]);
    }

    public function addUserRoleList()
    {
        return view('userrole.adduserrole');
    }

    public function addPostUserRoleList(Request $request)
    {
        $userrole = $request->role;
        $active = $request->active;
        
        if($active != 1)
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
        
        if($active != 1)
        {
            $active = 0;
        }
        else
        {
            $active = 1;
        }
        $result = DB::update('update users_roles set role = ?, active = ? where id = ?', [$userrole, $active, $id]);

        if ($result != false) {
            return redirect('userrolelist')->with('updateCategoryInMsg', 'User Role Updated Successfully');
        } else {
            return redirect('updateuserrolelist/'. $id)->with('errUpdateCategoryInMsg', 'User Role not Updated');
        }
    }

    public function deleteUserRoleList($id)
    {
        $data = DB::delete('delete from users_roles where id = ?', [$id]);

        if ($data != false) {
            return redirect('/userrolelist')->with('deleteCategoryInMsg', 'User Role Deleted Successfully');
        } else {
            return redirect('/userrolelist')->with('errDeleteCategoryInMsg', 'User Role not Deleted');
        }

    }
}
