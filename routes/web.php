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

Route::get('/test', function(){
    $user = User::find(14);
    $user->tokens()->delete();

});

//all
Auth::routes(['verify' => true]);

//all


//admin
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/about', 'HomeController@about')->name('about');

    Route::name('bookings.')->group(function(){
        Route::get('/my-bookings', 'BookingController@index')->name('my.bookings');
        Route::get('/book', 'BookingController@create')->name('book');
    });
});

Route::namespace('Admin')
    ->middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){

        Route::get('/profile', 'ProfileController@index')->name('profile');
        Route::put('/profile', 'ProfileController@update')->name('profile.update');

        Route::resource('buses','BusController');
        Route::resource('terminals','TerminalController');
        Route::resource('routes','RouteController');
        Route::resource('rides','RideController');
        Route::resource('employees', 'EmployeeController');
        Route::get('/createToken/{employee}', 'EmployeeController@createTokenForUser')->name('employee.createToken');
    });

Route::namespace('SuperAdmin')
    ->middleware('auth')
    ->prefix('super')
    ->name('super.')
    ->group(function(){
        Route::resource('users', 'UserController');
        Route::get('/users/{user}/activate', 'UserController@activate')->name('users.activate');
        Route::get('/users/{user}/deactivate', 'UserController@deactivate')->name('users.deactivate');
    });


