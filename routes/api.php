<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'AuthenticationController@register');
Route::post('login', 'AuthenticationController@login');

// return list of countries and some information about every country

Route::middleware('jwt.auth')->group(function (){
    Route::get('countries', 'CountriesController@index');
});
