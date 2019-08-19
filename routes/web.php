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