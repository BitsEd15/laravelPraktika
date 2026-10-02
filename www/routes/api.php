<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;


Route::prefix('catalog')->group(function(){
    Route::get('/',[ProductController::class, 'index']);
    Route::get('/{id}',[ProductController::class, 'show']);
});

Route::prefix('auth')->group(function(){
    Route::post('/sign-up',[AuthController::class,'signUp']);
    Route::post('/sign-in',[AuthController::class,'signIn']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/log-out',[AuthController::class,'logOut']);
    Route::get('/cart',[CartController::class,'index']);
    Route::post('/', [CartController::class, 'store']);
});
