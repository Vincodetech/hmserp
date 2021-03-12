<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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
Route::post('addusers',[ApiController::class,'addUsers']);
Route::post('loginuser',[ApiController::class,'loginUser']);
Route::post('updateuser/{id}',[ApiController::class,'updateUser']);
Route::get('deleteuser/{id}',[ApiController::class,'deleteUser']);
