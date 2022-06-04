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

Route::get('Users/search/{term?}', 'UserController@index');
Route::get('doctors/search/{term?}', 'DoctorController@index');
Route::get('centers/search/{term?}', 'CenterController@index');
Route::get('getCenter', 'DoctorController@centers');
Route::get('getUser', 'CenterController@users');
Route::resource('users', 'UserController');
Route::resource('doctors', 'DoctorController');
Route::resource('centers', 'CenterController');
