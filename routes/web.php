<?php

Auth::routes();

Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->middleware('auth');
Route::get('/home/{mode}', 'HomeController@index')->middleware('auth');

// profile controller
Route::get('/profile', 'ProfileController@showProfile')->middleware('auth');
Route::post('/profile/update', 'ProfileController@updateProfile')->middleware('auth');

// anything about students
Route::get('/student', 'StudentController@index')->middleware('auth');
Route::post('/student/update/{id}', 'StudentController@updateStudent')->middleware('auth');

// get / send Location
Route::post('/getLocation', 'LocationController@getLocation')->middleware('auth');
Route::get('/sendLocation/{adapter_name}', 'LocationController@sendLocation');

// WaitingList
Route::post('/callStudent/{device_mac_address}/{area}', 'WaitingListController@callStudent')->middleware('auth');
Route::get('/WaitingList/{location}', 'WaitingListController@displayWaiting')->middleware('auth');

// get Image with authentication
Route::get('/image/{folder}/{id}', 'ProfileController@getImage')->middleware('auth');

// receiver
Route::get('/system/receiver', 'SystemController@getReceiver');
Route::post('/system/receiver/edit', 'SystemController@updateReceiver');
Route::post('/system/receiver/create', 'SystemController@createReceiver');
Route::post('/system/receiver/remove', 'SystemController@removeReceiver');
Route::post('/system/receiver/command', 'SystemController@sendCommand');

// user management
Route::get('/system/user', 'ProfileController@getUser')->middleware('auth');
Route::post('/system/user/email', 'ProfileController@getUserByEmail')->middleware('auth');
Route::post('/system/user/updateStatus/{id}', 'ProfileController@updateStatus')->middleware('auth');