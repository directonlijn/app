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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'Auth\AuthController@getLogin');

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

// To show welcome mail in browser
Route::get("mail/view/{slug}", 'MailController@viewTemplate');

Route::get("mail/test", "MarktenController@test");

/* Authenticated users */
Route::group(['middleware' => 'auth'], function()
{
    // PDF
    Route::get('pdf', function () {
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();
        $data = array();
        $data['factuurnr'] = "201700001";
        $data['datum'] = "201700001";

        // $pdf = PDF::setOptions(["logOutputFile" => "/tmp/log.htm"]);
        $pdf = PDF::loadView('pdf.factuur', $data);
        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    });

    // Emails
    Route::get('sendemail2', 'MailController@sendWelcomeMail');
    Route::get('sendemail', function () {

        $data = array(
            'name' => "Learning Laravel",
        );

        Mail::send('emails.welcome', $data, function ($message) {

            $message->from('graham@directevents.nl', 'Learning Laravel');

            $message->to('grahamneal1991@gmail.com')->subject('Learning Laravel test email');

        });

        return "Your email has been sent successfully";

    });

    // Register
    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');

    Route::get('dashboard', array('as'=>'dashboard', function()
	{
	       return View('users.dashboard');
	}));

    // excel exports
    Route::get('markten/{slug}/export/aanmeldingen', 'MarktenController@exportAllStandhoudersForMarkt');
    Route::get('markten/{slug}/export/selected', 'MarktenController@exportAllSelectedStandhoudersForMarkt');

    // Markten
    Route::get('markten/{slug}/aanmeldingen', 'MarktenController@getMarktAanmeldingen');
    Route::get('markten/{slug}/geselecteerd', 'MarktenController@getMarktSelected');
    Route::get('markten/{slug}', 'MarktenController@getMarkt');
    Route::get('markten', 'MarktenController@getIndex');
    Route::get('mail', 'MailController@getIndex');

    // API calls
    Route::post('markt/getStandhoudersForMarkt', 'MarktenController@getStandhouderTableJSON');
    Route::get('markt/getStandhoudersForMarkt', 'MarktenController@getStandhouderTableJSON');
    Route::post('markt/setStandhouderSeen', 'MarktenController@setStandhouderSeen');
    Route::post('markt/setStandhouderSelected', 'MarktenController@setStandhouderSelected');
});

return view('errors.404');
