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

Route::get('/', function () {
    return view('welcome');
});

//Social Login
Route::get('/login/{provider?}',[
    'uses' => 'AuthController@getSocialAuth',
    'as'   => 'auth.getSocialAuth'
]);


Route::get('/login/callback/{provider?}',[
    'uses' => 'AuthController@getSocialAuthCallback',
    'as'   => 'auth.getSocialAuthCallback'
]);

Route::get('/logged', function () {
    return view('logged');
});
