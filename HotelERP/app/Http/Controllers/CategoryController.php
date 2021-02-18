<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function foodCategoryList()
    {
        return view('restaurent.foodcategorylist');
    }

    public function addFoodCategory()
    {
        return view('restaurent.addfoodcategory');
    }
}
