<?php

Auth::routes();

Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->middleware('auth');

Route::post('/manageStudent', 'HomeController@manageStudent')->middleware('auth');
Route::get('/updateProfile', 'HomeController@updateProfile')->middleware('auth');

Route::post('/getLocation', 'LocationController@getLocation')->middleware('auth');
Route::get('/sendLocation/{adapter_id}', 'LocationController@sendLocation');

Route::get('/waitingList/{location}', 'WaitingListController@displayWaiting')->middleware('auth');