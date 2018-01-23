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

// automagically enable the routes for the authentication (/login, /logout...)
Auth::routes();
// These routes are for handling oauth login requests from the users and oauth callbacks from the providers
Route::get('/auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::get('/home', 'HomeController@index')->name('home');

// define a resource route, see official documentation for details on this
Route::resource('trips','TripController');

Route::post('tripParts/{trip}/{tripPart}/travelerReportEvent','TripPartController@addTravelerReportEvent')->name('tripParts.addTravelerReportEvent');


