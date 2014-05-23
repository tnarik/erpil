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

Route::get('cust', 'CustomersController@index');
Route::get('cust/{username}', 'CustomersController@show');

Route::resource('customers', 'CustomersController');


//Route::get('users/{username}', ....);