<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class MyController extends Controller
{
    
    public function export() 
    {
        return Excel::download(new UsersExport, 'food_item.xlsx');
    }
     
    
}
