<?php

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
    return view('welcome');
});

Route::prefix('/auth')->group(function () {
	Route::post('/register', 'AuthController@register')->middleware('tokenAuth.loggedOut');
	Route::post('/login', 'AuthController@login')->middleware('tokenAuth.loggedOut');
	Route::get('/account', 'AuthController@account')->middleware('tokenAuth.loggedIn');
	Route::post('/logout', 'AuthController@logout')->middleware('tokenAuth.loggedIn');
});

Route::middleware('tokenAuth.loggedIn')->prefix('/todos')->group(function () {
    Route::get('/', 'TodosController@index');
    Route::get('/{id}', 'TodosController@show');
    Route::post('/', 'TodosController@create');
    Route::put('/{id}', 'TodosController@update');
    Route::put('/{id}/complete', 'TodosController@complete');
    Route::put('/{id}/incomplete', 'TodosController@incomplete');
    Route::delete('/{id}', 'TodosController@destroy');
});