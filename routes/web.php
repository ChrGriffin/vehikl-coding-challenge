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

Route::get('/', 'AppController@index')->name('home');

Route::group(['prefix' => 'tickets'], function () {
	Route::post('/', 'TicketController@create')->name('ticket.create');
	Route::get('/status/{code}', 'TicketController@status')->name('ticket.status');
	Route::post('/pay/{code}', 'Ticketcontroller@pay')->name('ticket.pay');
});