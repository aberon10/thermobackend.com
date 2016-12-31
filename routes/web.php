<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// Login
Route::get('/login', 'LoginController@showLoginForm');
Route::post('/login', 'LoginController@authenticate');

Route::get('/dashboard', 'DashboardController@index');
