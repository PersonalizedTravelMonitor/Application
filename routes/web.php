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


Auth::routes();
Route::get('/auth/google', 'Auth\LoginController@redirectToGoogle')->name('login.google');
Route::get('/auth/google/callback', 'Auth\LoginController@handleGoogleCallback')->name('callback.google');

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('trips','TripController');

Route::post('/tripParts/{tripPart}/travelerReportEvent','TripPartController@addTravelerReportEvent')->name('tripParts.addTravelerReportEvent');


