<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Session;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Exports\FoodItemExport;
use App\Imports\FoodItemImport;
use App\Exports\FoodCategoryExport;
use App\Imports\FoodCategoryImport;
use Maatwebsite\Excel\Facades\Excel;

class MyController extends Controller
{
    
    public function foodItemExport() 
    {
        $fname = "Food_Item-".date('Y-m-d').".xlsx";
        return Excel::download(new FoodItemExport, $fname);
    }
     
    public function foodCategoryExport() 
    {
        $fname = "Food_Category-".date('Y-m-d').".xlsx";
        return Excel::download(new FoodCategoryExport, $fname);
    }

    public function usersExport() 
    {
        $fname = "Users-".date('Y-m-d').".xlsx";
        return Excel::download(new UsersExport, $fname);
    }
}
