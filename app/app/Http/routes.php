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
    // Route::get('pdf', 'PdfController@sendInvoce');
    // Route::get('pdf', 'PdfController@hoogsteFactuurNummer');
    // Route::get('/testpdf', function () {
    //     return view('pdf.factuur');
    // });

    // Emails
    Route::get('sendemail2', 'MailController@sendWelcomeMail');
    // Route::get('sendemail', function () {
    //
    //     $data = array(
    //         'name' => "Learning Laravel",
    //     );
    //
    //     Mail::send('emails.welcome', $data, function ($message) {
    //
    //         $message->from('graham@directevents.nl', 'Learning Laravel');
    //
    //         $message->to('grahamneal1991@gmail.com')->subject('Learning Laravel test email');
    //
    //     });
    //
    //     return "Your email has been sent successfully";
    //
    // });

    // Register
    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');

    Route::get('dashboard', array('as'=>'dashboard', function()
	{
	       return View('users.dashboard');
	}));

    // PDF
    Route::get('markten/{slug}/sendInvoices', 'PdfController@sendInvoce');
    Route::post('markt/sendInvoiceForStandhouder', 'PdfController@sendInvoiceForStandhouder');
    Route::post('markt/downloadInvoice', 'PdfController@downloadInvoice');
    Route::get('markt/downloadInvoice/{year}/{factuurnummer}', 'PdfController@actualDownloadInvoice');

    // excel exports
    Route::get('markten/{slug}/export/aanmeldingen', 'MarktenController@exportAllStandhoudersForMarkt');
    Route::get('markten/{slug}/export/geselecteerd', 'MarktenController@exportAllSelectedStandhoudersForMarkt');
    Route::get('markten/{slug}/export/betaald', 'MarktenController@exportAllPayedStandhoudersForMarkt');
    Route::get('markten/{slug}/export/openstaand', 'MarktenController@exportAllOpenstaandeStandhoudersForMarkt');

    // Markten
    Route::get('markten/beheer', 'MarktenController@getManagement');
    Route::post('markten/beheer/getMarkt', 'MarktenController@getMarktManagement');
    Route::get('markten/{slug}/winkeliers', 'MarktenController@getMarktWinkeliers');
    Route::get('markten/{slug}/aanmeldingen', 'MarktenController@getMarktAanmeldingen');
    Route::get('markten/{slug}/geselecteerd', 'MarktenController@getMarktSelected');
    Route::get('markten/{slug}/betaald', 'MarktenController@getMarktBetaald');
    Route::get('markten/{slug}/openstaand', 'MarktenController@getMarktOpenstaand');
    Route::get('markten/{slug}', 'MarktenController@getMarkt');
    Route::get('markten', 'MarktenController@getIndex');
    Route::get('mail', 'MailController@getIndex');

    // API calls
    Route::post('markt/getStandhoudersForMarkt', 'MarktenController@getStandhouderTableJSON');
    Route::get('markt/getStandhoudersForMarkt', 'MarktenController@getStandhouderTableJSON');
    Route::post('markt/setStandhouderSeen', 'MarktenController@setStandhouderSeen');
    Route::post('markt/setStandhouderSelected', 'MarktenController@setStandhouderSelected');
    Route::post('markt/setStandhouderBetaald', 'MarktenController@setStandhouderBetaaldRequest');
    Route::post('markt/getStandhouder', 'MarktenController@getStandhouder');
    Route::post('markt/changeStandhouder', 'MarktenController@changeStandhouder');
});

return view('errors.404');
