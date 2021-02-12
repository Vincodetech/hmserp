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
}
