<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Standhouder as Standhouder;
use App\Models\Koppel_standhouders_markten as KoppelStandhoudersMarkten;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AanmeldController extends Controller
{
    /**
     *
     * Behandelt de nieuwe aanmelder
     *
     */
    public function postAanmelding(Request $request)
    {
        $required = ['bedrijfsnaam', 'voornaam', 'achternaam', 'straat', 'postcode', 'huisnummer', 'woonplaats', 'telefoon', 'email'];
        $allValues = ['bedrijfsnaam', 'voornaam', 'achternaam', 'straat', 'postcode', 'huisnummer', 'toevoeging', 'woonplaats', 'telefoon', 'email', 'website', 'kramen', 'grondplekken', 'foodNonfood'];
        $arrayedValues = ['producten'];

        for($x = 0; $x < count($required); $x++){
            $text = "". $required[$x];
            if(($text == "huisnummer" && strlen($request->$text) < 1) || ($text != "huisnummer" && strlen($request->$text) < 2)){

                abort(503);
            }
        }

        // Standhouder model
        // protected $fillable = ['Bedrijfsnaam', 'Voornaam', 'Achternaam', 'Straat', 'Postcode', 'Huisnummer', 'Toevoeging', 'Woonplaats', 'Telefoon', 'Email', 'Website'];
        $standhouder = new Standhouder;
        $standhouder->Bedrijfsnaam = $request->bedrijfsnaam;
        $standhouder->Voornaam = $request->voornaam;
        $standhouder->Achternaam = $request->achternaam;
        $standhouder->Straat = $request->straat;
        $standhouder->Postcode = $request->postcode;
        $standhouder->Huisnummer = $request->huisnummer;
        $standhouder->Toevoeging = $request->toevoeging;
        $standhouder->Woonplaats = $request->woonplaats;
        $standhouder->Telefoon = $request->telefoon;
        $standhouder->Email = $request->email;
        $standhouder->Website = $request->website;

        $standhouder->save();

        // get the current markt for signup
        $markt = Markt::where('id', $request->markt_id)->firstOrFail();

        // Koppel_standhouders_markten
        // protected $fillable = ['markt_id', 'standhouder_id', 'type', 'kraam', 'grondplek', 'bedrag', 'betaald'];

        $koppel_standhouders_markten = new KoppelStandhoudersMarkten;
        $koppel_standhouders_markten->markt_id = $request->markt_id;
        $koppel_standhouders_markten->standhouder_id = $standhouder->id;
        $koppel_standhouders_markten->type = $request->foodNonfood;
        $koppel_standhouders_markten->kraam = $request->kramen;
        $koppel_standhouders_markten->grondplek = $request->grondplekken;
        $koppel_standhouders_markten->bedrag = ($markt->bedrag_grondplek * $request->grondplekken) + ($markt->bedrag_kraam * $request->kramen);
        $koppel_standhouders_markten->betaald = 0;
        $koppel_standhouders_markten->stroom = 0;

        if(isset($request->producten)){
            foreach ($request->producten as $product)
            {
                $koppel_standhouders_markten->$product = 1;
            }
        }
        $koppel_standhouders_markten->save();

        // $msg = "<h1>Bedankt voor uw aanmelding!</h1>
        //         <br>
        //         <br>
        //         U bent aangemeld voor de:
        //         <br>
        //         Hippiemarkt Amsterdam XL op Zondag 26 maart 2017, Osdorpplein.
        //         <br>
        //         <br>
        //         We hebben uw bericht in goede orde ontvangen, we sturen
        //         <br>
        //         u zo spoedig mogelijk nadere informatie over het event!
        //         <br>
        //         <br>
        //         Hou de FacebookPagina in de gaten voor verdere updates
        //         <br>
        //         <br>
        //         @HippiemarktAmsterdamXL";

        // use wordwrap() if lines are longer than 70 characters
        // $msg = wordwrap($msg,70);

        $template_name = $markt->{"welcome-mail-template"};
        $data = array(
            'data' => array(
                    'template' => $template_name,
                    'email' => $request->email
                )
        );

        \App::call('App\Http\Controllers\MailController@sendWelcomeMail', $data);

        // send email
        // mail($request->email,"Aanmelding Ontvangen",$msg);

        return header("HTTP/1.1 200 OK");
    }
}
