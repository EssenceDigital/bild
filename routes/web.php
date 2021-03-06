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

Route::get('/', 'RsvpController@index');

Auth::routes();

Route::get('/app', 'DashboardController@app');
Route::get('/guests/all', 'GuestsController@all');
Route::post('/rsvp/send', 'RsvpController@send');
Route::post('/rsvp/update', 'GuestsController@updateRsvp');
Route::get('/guests/export', 'GuestsController@export');
