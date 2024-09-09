<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






// ************************************ organization routes ************************************





    Route::prefix('organization')->group(function(){
        Route::post('register',[OrganizationController::class,'organization_register'])->name('organization.register');
        Route::post('login',[OrganizationController::class,'organization_login'])->name('organization.login');
        Route::group(['middleware'=>'auth:organization'],function(){
            Route::post('logout',[OrganizationController::class,'organization_logout'])->name('organization.logout');

            Route::post('helllo',[OrganizationController::class,'hello'])->name('organization.hello');
        });
    });










// ************************************ admin routes ************************************



Route::group(['prefix'=>'admin',],function(){
    Route::post('register',[AdminController::class,'admin_register'])->name('admin.register');
    Route::post('login',[AdminController::class,'admin_login'])->name('admin.login');
    Route::group(['middleware'=>'auth:admin'],function () {
        Route::post('logout',[AdminController::class,'admin_logout'])->name('admin.logout');

    });
});






// ************************************ user routes ************************************



Route::group(['prefix'=>'user',],function(){
    Route::post('register',[UserController::class,'user_register'])->name('user.register');
    Route::post('login',[UserController::class,'user_login'])->name('user.login');

    Route::group(['middleware'=>'auth:user'],function () {
        Route::post('logout',[AdminController::class,'admin_logout'])->name('user.logout');

    });
});




// ************************************ event routes ************************************



Route::group(['prefix'=>'event',],function(){
   Route::get('all', [EventController::class,'all_events'])->name('all_events');
   Route::post('store', [EventController::class,'store'])->name('event.store');
   Route::post('update', [EventController::class,'update'])->name('event.update');
   Route::post('destroy', [EventController::class,'destroy'])->name('event.destroy');
   Route::post('get', [EventController::class,'get_event'])->name('event.get');
});








Route::get('login_page', function(){
    return response()->json([
        'message'=>'you are not authorized',
        'code'=>403
    ]);
})->name('login');


Route::post('hello',[UserController::class,'hello'])->name('user.hello');








