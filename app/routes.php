<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', 'uses' => 'DashboardsController@main'));
Route::get('/door', array('as' => 'door', 'uses' => 'DashboardsController@openDoor'));
Route::get('/stats', array('as' => 'stats', 'uses' => 'DashboardsController@stats'));
Route::get('/log', 'DashboardsController@displayLog');


Route::resource('sessions', 'SessionsController', array('only' => array('store')));
Route::get('/login', array('as' => 'login', 'uses' => 'SessionsController@create'));
Route::get('/logout', array('as' => 'logout', 'uses' => 'SessionsController@destroy'));


Route::resource('customers', 'CustomersController');
Route::resource('events', 'CardEventsController', array('only' => array('store')));


//Route::get('users/{username}', ....);