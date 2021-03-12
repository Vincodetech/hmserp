<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getUsers(Request $request)
    {
         $email = $request->user_name;
         $pass =  $request->password;

        $results = DB::select('select user_name, password from users');
        if ($results) 
        {
            return response()->json($results, 200);
            
        } 
        else 
        {
            return response()->json($results, 400);
        }
    }
    
    public function addUsers(Request $request)
    {
        $fname = $request->first_name;
        $lname = $request->last_name;
        $email = $request->email;
        $phone = $request->phone;
        $uname = $request->user_name;
        $pass =  $request->password;
        $active = $request->active;
        $joined_date = $request->joined_date;
        $user_role = $request->user_role;

        $checkUser= DB::select("select * from users where email = '$email'");
        if ($checkUser) 
        {
            $response['error']="002";
        	$response['message']="User exist";
            return response()->json($response);
        } 
        else 
        {
            $results = DB::insert('insert into users(first_name,last_name,email,
            phone,user_name,password,active,joined_date,user_role) values
            (?,?,?,?,?,?,?,?,?)', [$fname,$lname,$email,$phone,$uname,$pass,$active,$joined_date,$user_role]);
        
            if($results) 
            {
                $response['error']="000";
  	            $response['message']="Register Successful!";
                return response()->json($response);
            } 
            else 
            {
                $response['error']="000";
  	            $response['message']="Registration Failed!";
                return response()->json($response);
            }
        }
    }

    public function loginUser(Request $request)
    {
        $id = $request->id;
        $email = $request->email;
        $uname = $request->user_name;
        $pass =  $request->password;

        $results= DB::select("select id, email, user_name from users where user_name = '$uname'
        and password = '$pass'");
        
        if($results) 
            {
                $response['users']=$results;
                $response['error']="200";
  	            $response['message']="Login Successful!";
                return response()->json($response);
                
            } 
            else 
            {
                $response['users']=(object)[];
                $response['error']="400";
  	            $response['message']="Wrong Credentials!";
                return response()->json($response);
            }
    }

    public function updateUser(Request $request, $id)
    {
        $fname = $request->first_name;
        $lname = $request->last_name;
        $email = $request->email;
        $phone = $request->phone;
        $uname = $request->user_name;
        $pass =  $request->password;
        $active = $request->active;
        $joined_date = $request->joined_date;
        $user_role = $request->user_role;

        $results = DB::update('update users set first_name = ?, last_name = ?, email = ?,
            phone = ?, user_name = ?, password = ?, active = ?, joined_date = ?, user_role = ?
            where id = ?', [$fname, $lname, $email, $phone, $uname, $pass, $active,
            $joined_date, $user_role, $id]);
        
            if($results) 
            {
                $response['users']=$results;
                $response['error']="000";
  	            $response['message']="Update User Successful!";
                return response()->json($response);
            } 
            else 
            {
                $response['users']=(object)[];
                $response['error']="000";
  	            $response['message']="Update User Failed!";
                return response()->json($response);
            }

    }

    public function deleteUser($id)
    {
        $result = DB::delete('delete from users where id = ?', [$id]);

        if($result) 
            {
                $response['error']="000";
  	            $response['message']="Delete User Successful!";
                return response()->json($response);
            } 
            else 
            {
                $response['error']="000";
  	            $response['message']="Delete User Failed!";
                return response()->json($response);
            }
    }
}