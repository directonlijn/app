<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Standhouder as Standhouder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
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
     * Sends standhouder welcome mail
     *
     */
    //  public function sendWelcomeMail($standhouderId, $marktId)
    public function sendWelcomeMail($emailData)
    {
        $data = array(
            'name' => "Graham",
            'datum' => "19 Januari 2017",
            'marktNaam' => 'Hippiemark Amsterdam XL',
            'markt' => $emailData['markt']
        );

        \Mail::send('emails.'.$emailData['template'], $data, function ($message) use($emailData) {

            $message->from('info@directevents.nl', 'Bedankt voor uw aanmelding');

            $message->to($emailData['email'])->subject('Bedankt voor uw aanmelding');

        });

        return "De e-mail is verstuurd";
    }

    /**
     * Sends standhouder welcome mail
     *
     */
    public function viewTemplate($slug, $markt_id = false)
    {
        if ($markt_id !== false) {
            $markt = Markt::where('id', $markt_id)->firstOrFail();

            return View('emails.' . $slug)->with('markt', $markt);
        } else {
            return View('emails.' . $slug);
        }
    }

}
