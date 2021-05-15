<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\Session;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MyController;
use App\http\Controllers\ItemDataTableController;
use App\Http\Controllers\BillingController;
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

Route::get('/userslist',[UserController::class,'usersList']);
Route::get('/adduserslist',[UserController::class,'addUsersList']);
Route::post('/postuserslist',[UserController::class,'addPostUsersList']);
Route::get('/updateuserslist/{id}',[UserController::class,'updateUsersList']);
Route::post('/postupdateuserslist/{id}',[UserController::class,'postUpdateUsersList']);
Route::get('/deleteuserslist/{id}',[UserController::class,'deleteUsersList']);

Route::get('/userrolelist',[UserRoleController::class,'userRoleList']);
Route::get('/adduserrolelist',[UserRoleController::class,'addUserRoleList']);
Route::post('/postuserrolelist',[UserRoleController::class,'addPostUserRoleList']);
Route::get('/updateuserrolelist/{id}',[UserRoleController::class,'updateUserRoleList']);
Route::post('/postupdateuserrolelist/{id}',[UserRoleController::class,'postUpdateUserRoleList']);
Route::get('/deleteuserrolelist/{id}',[UserRoleController::class,'deleteUserRoleList']);

Route::get('/orderlist',[OrderController::class,'orderList']);

Route::get('/sliderlist',[SettingsController::class,'sliderList']);
Route::get('/addslider',[SettingsController::class,'addSlider']);
Route::post('/postslider',[SettingsController::class,'addPostSlider']);
Route::get('/updateslider/{id}',[SettingsController::class,'updateSlider']);
Route::post('/postupdateslider/{id}',[SettingsController::class,'postUpdateSlider']);
Route::get('/deleteslider/{id}',[SettingsController::class,'deleteSlider']);


Route::get('fooditemexport', [MyController::class, 'foodItemExport']);
Route::get('foodcategoryexport', [MyController::class, 'foodCategoryExport']);
Route::get('usersexport', [MyController::class, 'usersExport']);


Route::get('/billinglist',[BillingController::class,'billingList']);
Route::get('/addbilling',[BillingController::class,'addBilling']);
Route::post('/postbilling',[BillingController::class,'addPostBilling']);
Route::get('/updatebilling/{id}',[BillingController::class,'updateBilling']);
Route::post('/postupdatebilling/{id}',[BillingController::class,'postUpdateBilling']);
Route::get('/deletebilling/{id}',[BillingController::class,'deleteBilling']);
Route::get('/viewbilling/{id}',[BillingController::class,'viewBilling']);
Route::get('/getorder',[BillingController::class,'getOrderByOrderId']);
Route::get('/getitemname',[BillingController::class,'getItemNameById']);