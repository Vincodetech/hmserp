<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FoodCategoryAPIController;
use App\Http\Controllers\FoodItemAPIController;
use App\Http\Controllers\SliderAPIController;
use App\Http\Controllers\CartAPIController;
use App\Http\Controllers\OrderAPIController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('users',[ApiController::class,'getUsers']);
Route::get('user/{id}',[ApiController::class,'getUser']);
Route::post('addusers',[ApiController::class,'addUsers']);
Route::post('loginuser',[ApiController::class,'loginUser']);
Route::post('updateuser/{id}',[ApiController::class,'updateUser']);
Route::post('updateaddress/{id}',[ApiController::class,'updateAddress']);
Route::get('deleteuser/{id}',[ApiController::class,'deleteUser']);

Route::get('foodcategorylist',[FoodCategoryAPIController::class,'displayFoodCategory']);

Route::get('fooditemlist',[FoodItemAPIController::class,'displayFoodItem']);

Route::get('sliderlist',[SliderAPIController::class,'displaySliderImage']);

Route::get('getfooditems',[FoodItemAPIController::class,'getFoodItems']);

Route::get('singlefooditem',[FoodItemAPIController::class,'getFoodItem']);

Route::get('getcafeitems/{id}',[FoodItemAPIController::class,'getCafeItems']);

Route::get('getrelatedfooditem/{category_id}',[FoodItemAPIController::class,'getRelatedFoodItem']);

Route::post('addcartitem',[CartAPIController::class,'addCartItem']);

Route::post('addorder',[OrderAPIController::class,'addOrder']);

Route::get('getorderid',[OrderAPIController::class,'getOrderId']);

Route::post('updateorderid/{id}',[OrderAPIController::class,'updateOrderId']);

Route::get('getorder',[OrderAPIController::class,'getOrder']);

Route::post('addorderdetail',[OrderAPIController::class,'addOrderDetail']);

Route::post('updatestatus/{id}',[OrderAPIController::class,'updateStatus']);

Route::post('addbilldetail',[OrderAPIController::class,'addBillDetail']);

Route::get('getbillno',[OrderAPIController::class,'getBillNo']);

Route::get('getcartdata',[CartController::class,'getCartData']);

Route::post('addcartdata',[CartController::class,'addCartData']);

Route::post('updatecartdata/{id}',[CartController::class,'updateCartData']);

Route::get('deletecartdata/{id}',[CartController::class,'deleteCartData']);

Route::get('deletecartdata/{u_id}',[CartController::class,'deleteCartDatabyUserId']);