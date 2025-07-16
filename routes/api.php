<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout',[AuthController::class,'logout']);
    
    Route::resource('/users', UserController::class);

    Route::resource('/products', ProductController::class);
    
});
