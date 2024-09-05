<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('mhn', function () {
    return view('welcome');
});

// Route::get('hello',function(){
//     return 'hello';
// });
// Route::post('uregister',[UserController::class,'user_register']);
// Route::get('hello1', [UserController::class,'hello'])->name('hello');
