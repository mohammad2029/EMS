<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware'=>'auth:api'],function(){

});

Route::group(['prefix'=>'admin'],function(){
Route::post('register',[AdminController::class,'admin_register'])->name('admin.register');
Route::post('login',[AdminController::class,'admin_login'])->name('admin.login');
});


// Route::post('register',[UserController::class,'admin_register'])->name('admin.register');


// Route::prefix()
