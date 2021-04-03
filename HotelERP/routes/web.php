<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\Session;
use App\Http\Controllers\ApiController;
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
Route::post('/postfoodcategory',[CategoryController::class,'addPostFoodCategory']);
Route::get('/updatefoodcategory/{id}',[CategoryController::class,'updateFoodCategory']);
Route::post('/postupdatefoodcategory/{id}',[CategoryController::class,'updatePostFoodCategory']);
Route::get('/deletefoodcategory/{id}',[CategoryController::class,'deleteFoodCategory']);


Route::get('/fooditem',[ItemController::class,'foodItemList']);
Route::get('/addfooditem',[ItemController::class,'addFoodItem']);
Route::post('/postfooditem',[ItemController::class,'addPostFoodItem']);
Route::get('/updatefooditem/{id}',[ItemController::class,'updateFoodItem']);
Route::post('/postupdatefooditem/{id}',[ItemController::class,'updatePostFoodItem']);
Route::get('/deletefooditem/{id}',[ItemController::class,'deleteFoodItem']);

Route::get('users',[ApiController::class,'getUsers']);
// Route::post('/upload',[ItemController::class,'upload']);

Route::get('/tables',[TableController::class,'tablesList']);
Route::get('/addtables',[TableController::class,'addTables']);
Route::post('/posttables',[TableController::class,'addPostTables']);
