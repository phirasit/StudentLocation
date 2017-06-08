<?php

Auth::routes();

Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->middleware('auth');

// managing student
Route::post('/manageStudent', 'HomeController@manageStudent')->middleware('auth');

// profile controller
Route::get('/profile', 'ProfileController@showProfile')->middleware('auth');
Route::post('/profile/update', 'ProfileController@updateProfile')->middleware('auth');

// anything about students
Route::get('/student', 'StudentController@index')->middleware('auth');

// get / send Location
Route::post('/getLocation', 'LocationController@getLocation')->middleware('auth');
Route::get('/sendLocation/{adapter_name}', 'LocationController@sendLocation');

// WaitingList
Route::post('/callStudent/{device_mac_address}/{area}', 'WaitingListController@callStudent')->middleware('auth');
Route::get('/WaitingList/{location}', 'WaitingListController@displayWaiting')->middleware('auth');

// get Image with authentication
Route::get('/image/{folder}/{id}', 'ProfileController@getImage')->middleware('auth');
