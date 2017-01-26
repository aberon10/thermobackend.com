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

// Dashboard
Route::get('/dashboard', 'DashboardController@index');

// Genres
Route::get('/genres', 'GenresController@index');
Route::post('/genres/search', 'GenresController@search');
Route::get('/genres/add', 'GenresController@showForm');
Route::post('/genres/add', 'GenresController@add');
Route::get('/genres/edit/{id}', 'GenresController@edit');
Route::post('/genres/update/{id}', 'GenresController@update');
Route::post('/genres/delete', 'GenresController@delete');

// Artist
Route::get('/artists', 'ArtistsController@index');
Route::post('/artists/search', 'ArtistsController@search');
Route::get('/artists/add', 'ArtistsController@showForm');
Route::post('/artists/add', 'ArtistsController@add');
Route::get('/artists/edit/{id}', 'ArtistsController@edit');
Route::post('/artists/update/{id}', 'ArtistsController@update');
Route::post('/artists/delete', 'ArtistsController@delete');

// Album
Route::get('/albums', 'AlbumsController@index');
Route::get('/albums/list/{id}', 'AlbumsController@list');
Route::post('/albums/search', 'AlbumsController@search');
Route::get('/albums/add', 'AlbumsController@showForm');
Route::post('/albums/add', 'AlbumsController@add');
Route::get('/albums/edit/{id}', 'AlbumsController@edit');
Route::post('/albums/update/{id}', 'AlbumsController@update');
Route::post('/albums/delete', 'AlbumsController@delete');

// Pistas
Route::get('/tracks/add', 'TracksController@showForm');
Route::post('/tracks/add', 'TracksController@add');
Route::get('/tracks/{id}', 'TracksController@index');
Route::get('/tracks/edit/{id}', 'TracksController@edit');
Route::post('/tracks/update/{id}', 'TracksController@update');
Route::post('/tracks/{id}/delete', 'TracksController@delete');

// Tareas
Route::get('/task', 'TaskController@index');

// Usuarios
Route::get('/users', 'UserController@index');
Route::post('/users/search', 'UserController@search');
Route::get('/users/add', 'UserController@showForm');
Route::post('/users/add', 'UserController@add');
Route::get('/users/edit/{id}', 'UserController@edit');
Route::post('/users/update/{id}', 'UserController@update');
Route::post('/users/delete', 'UserController@delete');

