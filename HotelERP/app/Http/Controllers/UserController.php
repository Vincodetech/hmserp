<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
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
}
