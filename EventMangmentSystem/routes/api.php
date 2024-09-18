<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventEmployeeController;
use App\Http\Controllers\EventPhotoController;
use App\Http\Controllers\EventRequirmentController;
use App\Http\Controllers\EventSectionController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






// ************************************ organization routes ************************************





Route::prefix('organization')->group(function () {
    Route::post('register', [OrganizationController::class, 'organization_register'])->name('organization.register');
    Route::post('login', [OrganizationController::class, 'organization_login'])->name('organization.login');
    Route::post('email_verify', [AuthController::class, 'send_verification_code'])->name('organization.send_verification_code');

    Route::group(['middleware' => 'auth:organization'], function () {
        Route::post('logout', [OrganizationController::class, 'organization_logout'])->name('organization.logout');
        Route::post('events', [OrganizationController::class, 'organization_events'])->name('organization_events.all');
        Route::post('event_show', [OrganizationController::class, 'organization_event_show'])->name('organization_event.show');
        Route::post('ended_events', [OrganizationController::class, 'organization_ended_events'])->name('organization.organization_ended_events');
        Route::post('helllo', [OrganizationController::class, 'hello'])->name('organization.hello');
    });
});



// ************************************ event routes ************************************



Route::get('all', [EventController::class, 'all_events'])->name('event.all');
Route::post('search', [EventController::class, 'search_throw_event_type'])->name('event.search');
Route::group(['prefix' => 'event', 'middleware' => 'auth:organization'], function () {
    Route::post('store', [EventController::class, 'store'])->name('event.store');
    Route::post('update', [EventController::class, 'update'])->name('event.update');
    Route::post('destroy', [EventController::class, 'destroy'])->name('event.destroy');
    Route::post('publish', [EventController::class, 'publish_event'])->name('event.publish_event');
});

// ************************************ eventEmployees routes ************************************


Route::group(['prefix' => 'eventEmployee', 'middleware' => 'auth:organization'], function () {
    Route::get('all', [EventEmployeeController::class, 'all'])->name('eventEmployee.all');
    Route::post('store', [EventEmployeeController::class, 'store'])->name('eventEmployee.store');
    Route::post('update', [EventEmployeeController::class, 'update'])->name('eventEmployee.update');
    Route::post('destroy', [EventEmployeeController::class, 'destroy'])->name('eventEmployee.destroy');
    Route::post('show', [EventEmployeeController::class, 'show'])->name('eventEmployee.show');
});


// ************************************ event photos routes ************************************


Route::group(['prefix' => 'eventPhoto', 'middleware' => 'auth:organization'], function () {
    Route::post('store', [EventPhotoController::class, 'store_images'])->name('eventphoto.store');
    Route::post('destroy', [EventPhotoController::class, 'destroy'])->name('eventphoto.destroy');
});



// ************************************ event requirment routes ************************************


Route::group(['prefix' => 'eventRequirment', 'middleware' => 'auth:organization'], function () {
    Route::post('store', [EventRequirmentController::class, 'store'])->name('eventRequirment.store');
    Route::post('update', [EventRequirmentController::class, 'update'])->name('eventRequirment.update');
    Route::post('all', [EventRequirmentController::class, 'get_event_requriments'])->name('eventRequirment.all');
    Route::post('destroy', [EventRequirmentController::class, 'destroy'])->name('eventRequirment.destroy');
    Route::post('mark', [EventRequirmentController::class, 'mark_event_requirmant'])->name('eventRequirment.mark');
});



// ************************************ event section routes ************************************


Route::group(['prefix' => 'eventSection', 'middleware' => 'auth:organization'], function () {
    Route::post('store', [EventSectionController::class, 'store'])->name('eventSection.store');
    Route::post('update', [EventSectionController::class, 'update'])->name('eventSection.update');
    Route::post('destroy', [EventSectionController::class, 'destroy'])->name('eventSection.destroy');
});


// ************************************ speaker routes ************************************


Route::group(['prefix' => 'speaker', 'middleware' => 'auth:organization'], function () {
    Route::post('store', [SpeakerController::class, 'store'])->name('speaker.store');
    Route::post('update', [SpeakerController::class, 'update'])->name('speaker.update');
    Route::post('destroy', [SpeakerController::class, 'destroy'])->name('speaker.destroy');
    Route::post('index', [SpeakerController::class, 'index'])->name('speaker.index');
    Route::post('show', [SpeakerController::class, 'show'])->name('speaker.show');
});






// ************************************ admin routes ************************************



Route::group(['prefix' => 'admin',], function () {
    Route::post('register', [AdminController::class, 'admin_register'])->name('admin.register');
    Route::post('login', [AdminController::class, 'admin_login'])->name('admin.login');
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('organizations',  [OrganizationController::class, 'all_organizations'])->name('organization.all');
        Route::post('logout', [AdminController::class, 'admin_logout'])->name('admin.logout');
    });
});






// ************************************ user routes ************************************



Route::group(['prefix' => 'user',], function () {
    Route::post('register', [UserController::class, 'user_register'])->name('user.register');
    Route::post('login', [UserController::class, 'user_login'])->name('user.login');
    Route::post('email_verify', [AuthController::class, 'send_verification_code'])->name('user.send_verification_code');
    Route::group(['middleware' => 'auth:user'], function () {
        Route::post('logout', [UserController::class, 'user_logout'])->name('user.logout');
        Route::post('event_register', [UserController::class, 'user_event_register'])->name('user.event_register');
        Route::post('event_show', [UserController::class, 'user_event_show'])->name('user_event.show');
        Route::get('registerd_event', [UserController::class, 'show_registerd_events'])->name('user.show_registerd_events');
    });
});











Route::get('login_page', function () {
    return response()->json([
        'message' => 'you are not authorized',
        'code' => 403
    ]);
})->name('login');


Route::post('hello', [UserController::class, 'hello'])->name('user.hello');