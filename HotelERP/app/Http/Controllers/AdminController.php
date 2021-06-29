<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function Login()
    {
        return view('admin.login');
    }
    
    public function isDashboard()
    {
        return view('admin.dashboard');
    }

    public function Logout(Request $request)
    {
        $request->session()->forget('admin_name');
        return view('admin.login');
    }
}
