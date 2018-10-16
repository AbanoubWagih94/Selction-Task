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

Route::post('register', 'RegistrationController@store');
Route::post('login', 'LoginController@store');


// return list of countries and some information about every country
Route::middleware('jwt.auth')->get('countries', function() {
    $json = json_encode(file_get_contents("https://restcountries.eu/rest/v2/region/Africa"), true);
    return response()->json($json);
});

