<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FoodCategoryAPIController;
use App\Http\Controllers\FoodItemAPIController;
use App\Http\Controllers\SliderAPIController;

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
Route::get('deleteuser/{id}',[ApiController::class,'deleteUser']);

Route::get('foodcategorylist',[FoodCategoryAPIController::class,'displayFoodCategory']);

Route::get('fooditemlist',[FoodItemAPIController::class,'displayFoodItem']);

Route::get('sliderlist',[SliderAPIController::class,'displaySliderImage']);

Route::get('getfooditems',[FoodItemAPIController::class,'getFoodItems']);

Route::get('getcafeitems/{id}',[FoodItemAPIController::class,'getCafeItems']);