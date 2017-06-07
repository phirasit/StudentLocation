<?php

Auth::routes();

Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->middleware('auth');

Route::post('/manageStudent', 'HomeController@manageStudent')->middleware('auth');
Route::get('/profile', 'ProfileController@showProfile')->middleware('auth');
Route::post('/profile/update', 'ProfileController@updateProfile')->middleware('auth');

Route::post('/getLocation', 'LocationController@getLocation')->middleware('auth');
Route::get('/sendLocation/{adapter_name}', 'LocationController@sendLocation');

Route::post('/callStudent/{device_mac_address}/{area}', 'WaitingListController@callStudent')->middleware('auth');
Route::get('/WaitingList/{location}', 'WaitingListController@displayWaiting')->middleware('auth');
