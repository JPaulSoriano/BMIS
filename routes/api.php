<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('API')->group(function(){

    Route::get('/test', function(){
        return response()->json(['ok' => 'hello']);
    });

    Route::post('/register', 'PassengerController@register');
    Route::post('/login', 'PassengerController@login');


    Route::middleware(['auth:sanctum', 'verified'])
        ->prefix('passenger')
        ->group(function(){
            Route::post('/logout', 'PassengerController@logout');
            Route::resource('bookings', 'BookingController');
    });

    Route::prefix('conductor')
        ->group(function(){
            Route::post('/login', 'ConductorController@login');

            Route::middleware('auth:sanctum')
                ->group(function(){
                    Route::post('/logout', 'ConductorController@logout');

                    Route::post('/depart', 'ConductorController@depart');
                    Route::post('/arrive', 'ConductorController@arrive');
                    Route::post('/check-scheds', 'ConductorController@checkSchedules');
                    Route::get('/today-sched', 'ConductorController@todaySchedule');
                    Route::get('/employee-profile', 'ConductorController@getEmployeeProfile');
                });
        });
});
