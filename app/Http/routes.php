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

Route::get('/uploadExcel',function(){
	return view('welcome');
});

Route::get('/testfastupload','ExcelhandellerController@testfastupload');

Route::post('/uploadExcel', 'ExcelhandellerController@uploadExcel');

Route::get('/status', 'ExcelhandellerController@status');

Route::get('/game/home', 'BoardGameController@showHome');
Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/redirect/{service}', 'SocialAuthController@redirect');
Route::get('/callback/{service}', 'SocialAuthController@callback');
