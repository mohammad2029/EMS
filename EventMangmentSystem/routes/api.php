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

// ************************************ admin routes ************************************



Route::group(['prefix'=>'admin',],function(){
    Route::post('register',[AdminController::class,'admin_register'])->name('admin.register');
    Route::post('login',[AdminController::class,'admin_login'])->name('admin.login');
    Route::group(['middleware'=>'auth:api'],function () {

    });
});






// ************************************ user routes ************************************



Route::post('user_register',[UserController::class,'user_register'])->name('user.register');
Route::post('user_login',[UserController::class,'user_login'])->name('user.login');

Route::get('login_page', function(){
    return 'this is login page';
})->name('login');

Route::group(['middleware'=>'auth:api'],function(){
    Route::post('user_logout',[UserController::class,'user_logout'])->name('user.logout');

});
        Route::post('hello',[UserController::class,'hello'])->name('user.hello');










// Route::post('register',[UserController::class,'admin_register'])->name('admin.register');


// Route::prefix()
