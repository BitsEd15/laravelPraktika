<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\NewAuthController;


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

//новое практическое задание
Route::post('/login',[NewAuthController::class,'login']);//аутентификация
//Группа «Комнаты» (/api/rooms):
Route::prefix('rooms')->middleware(['auth:sanctum','role_check'])->group(function(){
    Route::get('/',[RoomsController::class,'index']);
    Route::post('/',[RoomsController::class,'store']);
    Route::delete('/{room}',[RoomsController::class,'destroy']);
});
//Группа «Студенты» (/api/students):
Route::prefix('students')->middleware(['auth:sanctum','role_check'])->group(function(){
    Route::get('/',[StudentsController::class,'index']);
    Route::post('/',[StudentsController::class,'store']);
    Route::put('/{id}/settle',[StudentsController::class,'update']);
});