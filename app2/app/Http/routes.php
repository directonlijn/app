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

/* User Authentication */
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// To show markt page
Route::get('markt/{slug}', 'MarktController@getMarkt');

    // External API calls
    Route::post('aanmelding/markt', 'AanmeldController@postAanmelding');
    // Route::post('aanmelding/markt', 'Auth\AuthController@postLogin');
    Route::get('aanmelding/markt', 'AanmeldController@postAanmelding');

/* Authenticated users */
Route::group(['middleware' => 'auth'], function()
{

    // Register
    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');

    Route::get('dashboard', array('as'=>'dashboard', function()
	{
	       return View('users.dashboard');
	}));

    Route::get('markten/{slug}/export', 'MarktenController@exportAllStandhoudersForMarkt');


    Route::get('markten/{slug}/aanmeldingen', 'MarktenController@getMarktAanmeldingen');
    Route::get('markten/{slug}', 'MarktenController@getMarkt');
    Route::get('markten', 'MarktenController@getIndex');

    // API calls
    Route::post('markt/getStandhoudersForMarkt', 'MarktenController@getStandhouderTableJSON');
    Route::get('markt/getStandhoudersForMarkt', 'MarktenController@getStandhouderTableJSON');
});

return view('errors.404');
