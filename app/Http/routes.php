<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
define("OAUTH_CONSUMER_KEY",     "ry2qdxt3vmbtbm4ifcxxhpci");
define("OAUTH_CONSUMER_SECRET",    "9acefgi98s");

Route::get('/', function () {
    return view('welcome');
});
Route::get('my-fist-route', function () {
    return 'hello world';
});
Route::get('didihavetorestart', function () {
    return 'no';
});

/*this specifies a controller that handles all the different http methods by default mapped to named functions,, 
#https://laravel.com/docs/5.3/controllers#resource-controllers
*/
Route::resource('meal','MealController');


Route::get('getoauthconsumertoken', 'OAuthController@getoauthconsumertoken');
Route::get('getoauthtoken', 'OAuthController@getoauthtoken');
Route::get('getetsyuser', 'OAuthController@getetsyuser');