<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {

    Route::controller(App\Http\Controllers\AttributeController::class)->group(function (){
        Route::get('attributes/{id?}', 'get')->name('attributes.get');
        Route::post('attributes/', 'store')->name('attributes.store');
        Route::put('attributes/{id}', 'update')->name('attributes.update');
        Route::delete('attributes/{id}', 'delete')->name('attributes.delete');
    });

    Route::controller(App\Http\Controllers\TimesheetController::class)->group(function (){
        Route::get('timesheets/{id?}', 'get')->name('timesheets.get');
        Route::post('timesheets/', 'store')->name('timesheets.store');
        Route::put('timesheets/{id}', 'update')->name('timesheets.update');
        Route::delete('timesheets/{id}', 'delete')->name('timesheets.delete');
    });
    

    Route::controller(App\Http\Controllers\ProjectController::class)->group(function (){
        Route::get('projects/{id?}', function (Illuminate\Http\Request $request, $id = null) {
            return app(App\Http\Controllers\ProjectController::class)->get($id, $request);
        })->name('project.get');
        Route::post('projects/', 'store')->name('project.store');
        Route::put('projects/{id}', 'update')->name('project.update');
        Route::delete('projects/{id}', 'delete')->name('project.delete');
    });
    

});


