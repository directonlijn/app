<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Standhouder as Standhouder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    /**
     * Show the main page
     *
     * @return Response
     */
    public function getIndex()
    {
        // $markten = Markt::orderBy('datum', 'desc')->get();
        // return View('users.markten')->with('markten', $markten);
        return View('users.mail');
    }

    /**
     * Sends standhouder invoice by mail
     *
     */
    public function sendInvoce()
    {
        $data = array();
        $data['factuurnr'] = "201700001";
        $data['datum'] = "201700001";

        $path = dirname(__DIR__, 3) . "/public/pdf/".date("Y") . "00003.pdf";
//dd($path);
        $pdf = \PDF::loadView('pdf.factuur', $data)->save( $path )->stream();

        // $data = array(
        //     'name' => "Graham",
        //     'datum' => "19 Januari 2017",
        //     'marktNaam' => 'Hippiemark Amsterdam XL'
        // );
//dd($path);

        $emailData = array(
            'template' => "factuur",
            'email' => "grahamneal1991@gmail.com",
            'pathToFile' => $path
        );

        $data = array(
            'name' => "Graham",
            'datum' => "19 Januari 2017",
            'marktNaam' => 'Hippiemark Amsterdam XL'
        );

        \Mail::send('emails.'.$emailData['template'], $data, function ($message) use($emailData) {

            $message->attach($emailData['pathToFile']);

            $message->from('info@directevents.nl', 'Factuur Direct Events');

            $message->to($emailData['email'])->subject('Factuur Direct Events');

        });

        return "De e-mail is verstuurd";
    }

    /**
     * Sends standhouder welcome mail
     *
     */
    public function viewTemplate($slug)
    {
        return View('emails.'.$slug);
    }

}
