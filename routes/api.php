<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['authentication']], function(){

	Route::get('/auth/current', 'UserController@current');
	Route::patch('/auth/current', 'UserController@update');
    Route::get('/auth/logout', 'UserController@logout');

    Route::resource('songs','SongController');
});

Route::post('/users', 'UserController@create');
Route::post('/auth/login', 'UserController@login');
