<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin',[AdminController::class,'Login']);
Route::post('/admin',[UserController::class,'isAuthenticate']);

Route::get('/dashboard',[AdminController::class,'isDashboard']);
Route::get('/admin',[AdminController::class,'Logout']);

Route::get('/foodcategory',[CategoryController::class,'foodCategoryList']);
Route::get('/addfoodcategory',[CategoryController::class,'addFoodCategory']);