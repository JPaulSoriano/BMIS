<?php

use App\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});

Route::get('/test', 'Admin\DashboardController@todayRides');

//all
Auth::routes(['verify' => true]);


//admin
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/about', 'HomeController@about')->name('about');

    Route::name('bookings.')->group(function(){
        Route::get('/my-bookings', 'BookingController@index')->name('my.bookings');
        Route::get('/create-booking', 'BookingController@create')->name('book.create');
        Route::get('/create-booking/{ride}/{start}/{end}/{travelDate}', 'BookingController@book')->name('book');
        Route::post('/book', 'BookingController@store')->name('book.store');

        Route::get('/booking/confirm/{booking}', 'BookingController@confirm')->name('book.confirm');
        Route::put('/booking/reject/{booking}', 'BookingController@reject')->name('book.reject');
    });
});

Route::namespace('Admin')
    ->middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/graph', 'DashboardController@graph');
        Route::get('/todayRides', 'DashboardController@todayRides');

        Route::get('/profile', 'ProfileController@index')->name('profile');
        Route::put('/profile', 'ProfileController@update')->name('profile.update');

        Route::resource('buses','BusController');
        Route::resource('bus-classes','BusClassController')->except(['index', 'show']);
        Route::resource('terminals','TerminalController');
        Route::resource('routes','RouteController');
        Route::resource('rides','RideController');
        Route::resource('employees', 'EmployeeController');
        Route::resource('sales', 'SaleController');
        Route::get('/createToken/{employee}', 'EmployeeController@createTokenForUser')->name('employee.createToken');

        Route::get('/passengers', 'PassengerController@index')->name('passengers');
    });

Route::namespace('SuperAdmin')
    ->middleware('auth')
    ->prefix('super')
    ->name('super.')
    ->group(function(){
        Route::resource('users', 'UserController');
        Route::get('/users/{user}/activate', 'UserController@activate')->name('users.activate');
        Route::get('/users/{user}/deactivate', 'UserController@deactivate')->name('users.deactivate');

        Route::get('/passengers', 'PassengerController@index')->name('passengers');
    });


