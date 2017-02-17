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

Auth::routes();

Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->middleware('auth');

Route::get('/manageStudent', 'HomeController@manageStudent')->middleware('auth');
Route::get('/updateProfile', 'HomeController@updateProfile')->middleware('auth');

Route::post('/getLocation', 'LocationController@getLocation')->middleware('auth');
Route::get('/sendLocation/{adapter_id}', 'LocationController@sendLocation');

Route::get('/waitingList/{location}', 'LocationController@displayWaiting')->middleware('auth');