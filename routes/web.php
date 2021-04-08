<?php

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


//all
Auth::routes();

//all


//admin
Route::middleware('auth')->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/about', 'HomeController@about')->name('about');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::resource('users', 'UserController');
    Route::get('/users/{user}/activate', 'UserController@activate')->name('users.activate');
    Route::get('/users/{user}/deactivate', 'UserController@deactivate')->name('users.deactivate');

    Route::resource('buses','BusController');
    Route::resource('terminals','TerminalController');
    Route::resource('routes','RouteController');
    Route::resource('schedules','ScheduleController');
});



