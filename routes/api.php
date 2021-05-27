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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json('ok');
    return response()->json($request->user());
});

Route::namespace('API')->group(function(){

    Route::get('/test', function(){
        return response()->json(['ok' => 'hello']);
    });

    Route::post('/register', 'PassengerController@register');

    Route::post('/login', 'PassengerController@login');
    Route::get('/retrieve-points-company/{ride_id}', 'PassengerController@retrievePointsByCompany');

    Route::middleware(['auth:sanctum'])
        ->prefix('passenger')
        ->group(function(){
            Route::get('/retrieve-points', 'PassengerController@retreivePoints');
            Route::post('/update', 'PassengerController@updateAccount');
            Route::post('/logout', 'PassengerController@logout');

            Route::get('/bookings','BookingController@index');
            Route::post('/book-by-cash', 'BookingController@bookByCash');
            Route::post('/book-by-points', 'BookingController@bookByPoints');
            Route::get('/get-terminals', 'BookingController@getTerminals');
            Route::get('/search-rides', 'BookingController@searchRides');
            Route::get('/compute-fare', 'BookingController@computeFare');
            Route::get('/book', 'BookingController@book');
            Route::get('/get-book', 'BookingController@getBooking');
            Route::get('/cancel-booking/{book_code}', 'BookingController@cancelBooking');

    });

    Route::prefix('conductor')
        ->group(function(){
            Route::post('/login', 'ConductorController@login');

            Route::middleware('auth:sanctum')
                ->group(function(){
                    Route::post('/logout', 'ConductorController@logout');

                    Route::post('/depart', 'ConductorController@depart');
                    Route::post('/arrive', 'ConductorController@arrive');
                    Route::get('/check-scheds', 'ConductorController@checkSchedules');

                    Route::get('/today-sched', 'ConductorController@todaySchedule');
                    Route::get('/employee-profile', 'ConductorController@getEmployeeProfile');
                    Route::get('/issue-receipt/{book_code}', 'ConductorController@issueReceipt');
                    Route::get('/get-ride/{id}', 'ConductorController@getRide');
                });
        });


});
