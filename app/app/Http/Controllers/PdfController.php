<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Standhouder as Standhouder;
use App\Models\Koppel_standhouders_markten as KoppelStandhoudersMarkten;
use App\Models\Factuur as Factuur;
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
     * Downloads invoice
     *
     * @return Response
     */
    public function actualDownloadInvoice($year, $factuurnummer)
    {
        $path = dirname(__DIR__, 3) . "/public/pdf/".$year."/".$factuurnummer.".pdf";

        if (file_exists($path))
        {
            $headers = array(
                'Content-Type: application/pdf',
            );

            return response()->download($path, $factuurnummer.'.pdf', $headers);
        }
        else
        {
            $returnData = array(
                'message' => 'De factuur is niet gevonden.'
            );

            return response()->json($returnData, 500);
        }
    }

    /**
     * Checks if download is possible
     *
     * @return Response
     */
    public function downloadInvoice(Request $request)
    {

        try {
            $factuur = Factuur::where("markt_id", $request->input("markt_id"))->where("standhouder_id", $request->input("standhouder_id"))->firstOrFail();

            $date = \DateTime::createFromFormat("Y-m-d", $factuur->datum);

            $path = dirname(__DIR__, 3) . "/public/pdf/".$date->format("Y")."/".$factuur->factuurnummer.".pdf";

            if (file_exists($path))
            {
                $headers = array(
                    'Content-Type: application/pdf',
                );

                // return Response::download($path, 'filename.pdf', $headers);
                // return response()->download($path, $factuur->factuurnummer.'.pdf', $headers);
                return json_encode(array("message" => "De factuur is opgehaald.", "year" => $date->format("Y"), "factuurnummer" => $factuur->factuurnummer));
            }
            else
            {
                $returnData = array(
                    'message' => 'De factuur is niet gevonden.'
                );

                return response()->json($returnData, 500);
            }


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $returnData = array(
                'message' => 'Er is nog geen factuur aangemaakt.'
            );

            return response()->json($returnData, 500);
        }
    }

    /**
     * Pak het hoogste factuurnummer
     *
     */
    private function geefNieuwFactuurNummer()
    {
        $year = date("Y");
        $factuur = Factuur::where('factuurnummer', 'LIKE', $year.'%')->orderBy('factuurnummer', 'desc')->first();

        $factuurnummer = ($factuur) ? (str_pad(($factuur->factuurnummer+1), 9, " ", STR_PAD_LEFT)) : $year."00001";

        return intval($factuurnummer);
    }

    /**
     * Pak het hoogste factuurnummer
     *
     */
    private function mergeStandhouderData($standhouder, $standhouderKoppel)
    {
        $standhouder_merged = array();

        $standhouder_merged['id'] = $standhouder->id;
        $standhouder_merged['markt_id'] = $standhouderKoppel->markt_id;
        $standhouder_merged['type'] = $standhouderKoppel->type;
        $standhouder_merged['kraam'] = $standhouderKoppel->kraam;
        $standhouder_merged['grondplek'] = $standhouderKoppel->grondplek;
        $standhouder_merged['stroom'] = $standhouderKoppel->stroom;
        $standhouder_merged['bedrag'] = $standhouderKoppel->bedrag;
        $standhouder_merged['bedrijfsnaam'] = $standhouder->Bedrijfsnaam;
        $standhouder_merged['email'] = $standhouder->Email;
        $standhouder_merged['adres'] = $standhouder->Straat . " " . $standhouder->Huisnummer;
        $standhouder_merged['postcodeplaats'] = $standhouder->Postcode . ", " . $standhouder->Woonplaats;

        // dd($standhouder_merged);
        return $standhouder_merged;
    }

    /**
     * Checks if standhouders allready has an invoice
     *
     */
    private function checkIfStandhouderHasInvoice($markt_id, $standhouder_id)
    {
        try {
            $factuur = Factuur::where("markt_id", $markt_id)->where("standhouder_id", $standhouder_id)->firstOrFail();
            return $factuur;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get Markt Model by ID
     *
     * @return Model or false
     */
    private function getMarktModel($id)
    {
        try {
            return Markt::where('id', $id)->firstOrFail();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get standhouder Model by ID
     *
     * @return Model or false
     */
    private function getStandhouderModel($id)
    {
        try {
            return Standhouder::where('id', $id)->firstOrFail();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get standhouder Model by ID
     *
     * @return Model or false
     */
    private function getStandhouderExtraModel($markt_id, $standhouder_id)
    {
        try {
            $standhouderExtra = KoppelStandhoudersMarkten::where("markt_id", $markt_id)->where("standhouder_id", $standhouder_id)->firstOrFail();
            return $standhouderExtra;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Send standhouder invoice new or adjusted
     *
     */
    public function sendInvoiceForStandhouder(Request $request)
    {
        $markt = $this->getMarktModel($request->input('markt_id'));
        if ($markt == false) return json_encode(array("message" => "De markt kon niet gevonden worden."));

        $standhouder = $this->getStandhouderModel($request->input('standhouder_id'));
        if ($standhouder == false) return json_encode(array("message" => "De standhouder kon niet gevonden worden."));

        $standhouderExtra = $this->getStandhouderExtraModel($request->input('markt_id'), $request->input('standhouder_id'));
        if ($standhouderExtra == false) return json_encode(array("message" => "De standhouder extra gegevens konden niet gevonden worden."));

        /*
            1. Kijken of er voor deze standhouder en markt al een factuur vestuurd is
            2a. Als die al verstuurd is moeten we dat factuurnummer gebruiken en die opnieuw sturen
            2b. Als die nog niet verstuurd is volgen we de normale weg om voor deze enkele gebruiker
                een factuur te sturen
        */
        $factuur = $this->checkIfStandhouderHasInvoice($request->input('markt_id'), $request->input('standhouder_id'));

        if ($factuur == false)
        {
            // Er is nog geen factuur en dus gaan we een nieuwe factuur versturen
            $factuur = new Factuur;
            $factuur->factuurnummer = $this->geefNieuwFactuurNummer();
            $factuur->datum = new \DateTime();
            $factuur->standhouder_id = $standhouder->id;
            $factuur->markt_id = $markt->id;
            if ($factuur->afgesproken_prijs)
            {
                $factuur->totaal_bedrag = number_format(round($standhouderExtra->afgesproken_bedrag, 2), 2);
            }
            else
            {
                $factuur->totaal_bedrag = number_format(round($markt->bedrag_grondplek * $standhouderExtra->grondplek + $markt->bedrag_kraam * $standhouderExtra->kraam, 2), 2);
            }
            $factuur->betaald = 0;
            $factuur->tweede_herinnering = 0;
            $factuur->derde_herinnering = 0;

            $factuur->save();
        }
        else
        {
            // We hebben al een factuur dus gaan we dat factuurnummer gebruiken
            $factuur->datum = date("Y-m-d");
            $factuur->betaald = 0;
            $factuur->tweede_herinnering = 0;
            $factuur->tweede_herinnering_datum = "";
            $factuur->derde_herinnering = 0;
            $factuur->derde_herinnering_datum = "";
            if ($standhouderExtra->afgesproken_prijs)
            {
                $factuur->totaal_bedrag = number_format(round($standhouderExtra->afgesproken_bedrag, 2), 2);
            }
            else
            {
                $factuur->totaal_bedrag = number_format(round($markt->bedrag_grondplek * $standhouderExtra->grondplek + $markt->bedrag_kraam * $standhouderExtra->kraam, 2), 2);
            }

            $factuur->save();
        }

        $pdf_data = array();
        $pdf_data['factuurnr'] = $factuur->factuurnummer;
        $pdf_data['datum'] = date("d-m-Y");
        $pdf_data['tabel'] = array();
        $pdf_data['titel'] = $markt->Naam;

        if ($standhouderExtra->afgesproken_prijs)
        {
            $pdf_data['tabel'][0] = array();
            $pdf_data['tabel'][0]['factuurnummer'] =  $factuur->factuurnummer;
            $pdf_data['tabel'][0]['aantal'] = 1;
            $pdf_data['tabel'][0]['soort'] = "Prijs afspraak";
            $pdf_data['tabel'][0]['btw'] = "21%";
            $pdf_data['tabel'][0]['prijsperstuk'] = "€".number_format(round($standhouderExtra->afgesproken_bedrag/1.21, 2), 2);
            $pdf_data['tabel'][0]['totaal'] = "€ " . number_format(round($standhouderExtra->afgesproken_bedrag/1.21, 2), 2);

            $pdf_data['totaalexbtw'] = "€ " . number_format(round($standhouderExtra->afgesproken_bedrag/1.21, 2), 2);
            $pdf_data['totaalbtw'] = "€ " . number_format(round($standhouderExtra->afgesproken_bedrag/1.21*0.21, 2), 2);
            $pdf_data['totaalinbtw'] = "€ " . number_format(round($standhouderExtra->afgesproken_bedrag, 2), 2);
        }
        else
        {
            if ($standhouderExtra->kraam > 0)
            {
                $pdf_data['tabel'][] = array();
                $key = count($pdf_data['tabel']) - 1;
                $pdf_data['tabel'][$key]['factuurnummer'] =  $factuur->factuurnummer;
                $pdf_data['tabel'][$key]['aantal'] = $standhouderExtra->kraam;
                $pdf_data['tabel'][$key]['soort'] = "Kraam";
                $pdf_data['tabel'][$key]['btw'] = "21%";
                $pdf_data['tabel'][$key]['prijsperstuk'] = "€".number_format(round($markt->bedrag_kraam/1.21, 2), 2);
                $pdf_data['tabel'][$key]['totaal'] = "€ " . number_format(round($markt->bedrag_kraam*($standhouderExtra->kraam/1.21), 2), 2);
            }

            if ($standhouderExtra->grondplek > 0)
            {
                $pdf_data['tabel'][] = array();
                $key = count($pdf_data['tabel']) - 1;
                $pdf_data['tabel'][$key]['factuurnummer'] =  $factuur->factuurnummer;
                $pdf_data['tabel'][$key]['aantal'] = $standhouderExtra->grondplek;
                $pdf_data['tabel'][$key]['soort'] = "Grondplek";
                $pdf_data['tabel'][$key]['btw'] = "21%";
                $pdf_data['tabel'][$key]['prijsperstuk'] = "€".number_format(round($markt->bedrag_grondplek/1.21, 2), 2);
                $pdf_data['tabel'][$key]['totaal'] = "€ " . number_format(round($markt->bedrag_kraam*($standhouderExtra->grondplek/1.21), 2), 2);
            }

            $pdf_data['totaalexbtw'] = "€ " . number_format(round($standhouderExtra->kraam*($markt->bedrag_kraam/1.21) + $standhouderExtra->grondplek*($markt->bedrag_grondplek/1.21), 2), 2);
            $pdf_data['totaalbtw'] = "€ " . number_format(round($standhouderExtra->kraam*($markt->bedrag_kraam/1.21*0.21) + $standhouderExtra->grondplek*($markt->bedrag_grondplek/1.21*0.21), 2), 2);
            $pdf_data['totaalinbtw'] = "€ " . number_format(round($standhouderExtra->kraam*$markt->bedrag_kraam + $standhouderExtra->grondplek*$markt->bedrag_grondplek, 2), 2);
        }

        $pdf_data['vervaldatum'] = date('d-m-Y', strtotime(date("d-m-Y"). ' + 14 days'));

        $pdf_data['standhouder'] = array();
        $pdf_data['standhouder']['bedrijfsnaam'] = $standhouder->Bedrijfsnaam;
        $pdf_data['standhouder']['adres'] = $standhouder->Straat . " " . $standhouder->Huisnummer;
        $pdf_data['standhouder']['postcodeplaats'] = $standhouder->Postcode . ", " . $standhouder->Woonplaats;

        // return \PDF::loadView('pdf.factuur', $pdf_data)->stream();
        // dd($pdf_data);

        $path = dirname(__DIR__, 3) . "/public/pdf/".date("Y")."/".$factuur->factuurnummer.".pdf";
        $pathToAlgemeneVoorwaarden = dirname(__DIR__, 3) . "/public/algemene voorwaarden/".$markt->{"algemene-voorwaarden-template"}.".pdf";

        $pdf = \PDF::loadView('pdf.factuur', $pdf_data)->save( $path );

        $emailData = array(
            'template' => "factuur",
            'email' => $standhouder->Email,
            'pathToPdf' => $path,
            'pathToTerms' => $pathToAlgemeneVoorwaarden
        );

        $data5 = array(
            'name' => "Graham",
            'datum' => "11 Februari 2017",
            'marktNaam' => 'Hippiemark Amsterdam XL'
        );

        \Mail::send('emails.'.$emailData['template'], $data5, function ($message) use($emailData) {

            $message->attach($emailData['pathToPdf']);
            $message->attach($emailData['pathToTerms']);

            $message->from('info@directevents.nl', 'Factuur Direct Events');

            $message->to($emailData['email'])->subject('Factuur Direct Events');

        });

        return json_encode(array("message" => "De factuur voor de standhouder is aangemaakt en verstuurd."));
    }

    /**
     * Sends standhouder invoice by mail
     *
     */
    public function sendInvoce($slug)
    {
        /*

            1. Wat is het hoogste huidige factuurnummer
            2. welke markt?
            3. Pak de geselecteerde standhouders van de markt
            4. Kijk of ze al een factuur gehad hebben.
                4 A. Ja kijk dan of die betaald is. Als die niet betaald is en het is langer dan 14 dagen geleden stuur een herinnering. Anders verwijder uit de array
                4 B. Nee.
            5. Maak de gegevens aan voor de nieuwe facturen voor het template
            6. Maak de facturen aan en sla ze op en verstuur ze via de e-mail
            7. Maak de gegevens aan voor de herrineringen voor het template
            8. Maak de herringerings factuur en en sla ze op en verstuur ze via de e-mail

        */

        // 1. Wat is het hoogste huidige factuurnummer
        // $hoogsteFactuurNummer = $this->geefNieuwFactuurNummer();

        $data = array();

        // 2. welke markt?
        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();
        $marktId = $data['markt']->id;

        // 3. Pak de geselecteerde standhouders van de markt
        $data['koppelStandhoudersMarkten'] = array();
        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->where('selected', 1)->get();

        $data['facturen']['normaal'] = array();
        $data['facturen']['normaal']['standhouders'] = array();
        $data['facturen']['normaal']['totaal'] = array();

        $data['facturen']['tweede'] = array();
        $data['facturen']['tweede']['standhouders'] = array();
        $data['facturen']['tweede']['totaal'] = array();

        $data['facturen']['derde'] = array();
        $data['facturen']['derde']['standhouders'] = array();
        $data['facturen']['derde']['totaal'] = array();

        $data['facturen']['geselecteerd'] = 0;
        $data['facturen']['nietGeselecteerd'] = 0;
        $data['facturen']['nietBetaaldNa28'] = 0;

        // 4. Kijk of ze al een factuur gehad hebben.
        $x = 0;
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            // Kijk of er al een factuur bestaat voor deze standhouder voor deze markt
            $factuur = Factuur::where('standhouder_id', $koppelStuk->standhouder_id)->where('markt_id', $marktId)->first();

            //  Kijk of er al een factuur bestaat voor deze standhouder voor deze markt en of deze betaald is
            if ($factuur) {
                if (!$factuur->betaald){
                    // Er bestaat al een factuur maar die is nog niet gemarkeerd als betaald
                    $dt = $factuur->datum;
                    $date = new \DateTime($dt);
                    $now = new \DateTime();
                    $diff = $now->diff($date);

                    // kijk of de tweede herinnering gestuurd is en of het al langer dan 14 dagen geleden is t.o.v. de eerste factuur
                    if (!$factuur->tweede_herinnering && $diff->days > 14)
                    {
                        // return "langer dan 14 dagen geleden en nog geen tweede herinnering gestuurd.";
                        $data['facturen']['tweede']['totaal']++;

                        $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->first();
                        if ($standhouder && $standhouder->winkelier != 1) {
                            $data['facturen']['tweede']['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                        }


                    }
                    // kijk of de derde herinnering gestuurd is en of het al langer dan 28 dagen geleden is t.o.v. de eerste factuur
                    else if (!$factuur->derde_herinnering && $diff->days > 28)
                    {
                        // return "langer dan 28 dagen geleden en nog geen derde herinnering gestuurd.";
                        $data['facturen']['derde']['totaal']++;

                        $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->first();
                        if ($standhouder && $standhouder->winkelier != 1) {
                            $data['facturen']['derde']['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                        }

                    }
                    // We sturen geen geautomatisserde factuur meer
                    else
                    {
                        $data['facturen']['nietGeselecteerd']++;
                        $data['facturen']['nietBetaaldNa28']++;
                    }
                }
                else
                {
                    // De factuur is al voldaan
                }
            }
            else
            {
                $data['facturen']['normaal']['totaal']++;
                $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->first();
                if ($standhouder) {
                    $standhouder_merged = $this->mergeStandhouderData($standhouder, $koppelStuk);
                    // dd($standhouder_merged);
                    $data['facturen']['normaal']['standhouders'][$koppelStuk->standhouder_id] = $standhouder_merged;
                }
            }
            $x++;
        }

        // return $data['facturen'];

        // $hoogsteFactuurNummer
        $aantal_facturen = 0;
        foreach($data['facturen']['normaal']['standhouders'] as $nieuwe_factuur)
        {

            $hoogsteFactuurNummer = $this->geefNieuwFactuurNummer();

            $factuurInstance = new Factuur;
            $factuurInstance->factuurnummer = $hoogsteFactuurNummer;
            $factuurInstance->datum = date("Y-m-d");
            $factuurInstance->standhouder_id = $nieuwe_factuur['id'];
            $factuurInstance->markt_id = $nieuwe_factuur['markt_id'];
            $factuurInstance->totaal_bedrag =  number_format(round($nieuwe_factuur['kraam']*$data['markt']->bedrag_kraam + $nieuwe_factuur['grondplek']*$data['markt']->bedrag_grondplek, 2), 2);
            $factuurInstance->betaald = 0;
            $factuurInstance->tweede_herinnering = 0;
            $factuurInstance->derde_herinnering = 0;

            $factuurInstance->save();

            $pdf_data = array();
            $pdf_data['factuurnr'] = $hoogsteFactuurNummer;
            $pdf_data['datum'] = date("d-m-Y");
            $pdf_data['bedrag_grondplek'] = $data['markt']->bedrag_grondplek;
            $pdf_data['bedrag_kraam'] = $data['markt']->bedrag_kraam;
            $pdf_data['tabel'] = array();
            $pdf_data['titel'] = $data['markt']->Naam;

            $pdf_data['tabel'][0] = array();
            $pdf_data['tabel'][0]['factuurnummer'] = $hoogsteFactuurNummer;
            $pdf_data['tabel'][0]['aantal'] = $nieuwe_factuur['kraam'];
            $pdf_data['tabel'][0]['soort'] = "Kraam";
            $pdf_data['tabel'][0]['btw'] = "21%";
            $pdf_data['tabel'][0]['prijsperstuk'] = "€".number_format(round($data['markt']->bedrag_kraam/1.21, 2), 2);
            $pdf_data['tabel'][0]['totaal'] = "€ " . number_format(round($nieuwe_factuur['kraam']*($data['markt']->bedrag_kraam/1.21), 2), 2);

            $pdf_data['tabel'][1] = array();
            $pdf_data['tabel'][1]['factuurnummer'] = "";
            $pdf_data['tabel'][1]['aantal'] = $nieuwe_factuur['grondplek'];
            $pdf_data['tabel'][1]['soort'] = "Grondplaats";
            $pdf_data['tabel'][1]['btw'] = "21%";
            $pdf_data['tabel'][1]['prijsperstuk'] = "€".number_format(round($data['markt']->bedrag_grondplek/1.21, 2), 2);
            $pdf_data['tabel'][1]['totaal'] = "€ " . number_format(round($nieuwe_factuur['grondplek']*($data['markt']->bedrag_grondplek/1.21), 2), 2);

            $pdf_data['totaalexbtw'] = "€ " . number_format(round($nieuwe_factuur['kraam']*($data['markt']->bedrag_kraam/1.21) + $nieuwe_factuur['grondplek']*($data['markt']->bedrag_grondplek/1.21), 2), 2);
            $pdf_data['totaalbtw'] = "€ " . number_format(round($nieuwe_factuur['kraam']*($data['markt']->bedrag_kraam/1.21*0.21) + $nieuwe_factuur['grondplek']*($data['markt']->bedrag_grondplek/1.21*0.21), 2), 2);
            $pdf_data['totaalinbtw'] = "€ " . number_format(round($nieuwe_factuur['kraam']*$data['markt']->bedrag_kraam + $nieuwe_factuur['grondplek']*$data['markt']->bedrag_grondplek, 2), 2);

            $pdf_data['vervaldatum'] = date('d-m-Y', strtotime(date("d-m-Y"). ' + 14 days'));

            $pdf_data['standhouder'] = array();
            $pdf_data['standhouder']['bedrijfsnaam'] = $nieuwe_factuur['bedrijfsnaam'];
            $pdf_data['standhouder']['adres'] = $nieuwe_factuur['adres'];
            $pdf_data['standhouder']['postcodeplaats'] = $nieuwe_factuur['postcodeplaats'];

            // return \PDF::loadView('pdf.factuur', $pdf_data)->stream();
            // dd($pdf_data);

            $path = dirname(__DIR__, 3) . "/public/pdf/".date("Y")."/".$hoogsteFactuurNummer.".pdf";
            $pathToAlgemeneVoorwaarden = dirname(__DIR__, 3) . "/public/algemene voorwaarden/".$data['markt']->{"algemene-voorwaarden-template"}.".pdf";

            $pdf = \PDF::loadView('pdf.factuur', $pdf_data)->save( $path );
            // return $pdf->stream();
            // return $pdf;
            // sleep(1);
            // dd($nieuwe_factuur);
            $emailData = array(
                'template' => "factuur",
                'email' => $nieuwe_factuur['email'],
                'pathToPdf' => $path,
                'pathToTerms' => $pathToAlgemeneVoorwaarden
            );

        // $path = dirname(__DIR__, 3) . "/public/pdf/".date("Y") . "00003.pdf";
//dd($path);
        // $pdf = \PDF::loadView('pdf.factuur', $data)->save( $path )->stream();

        // $data = array(
        //     'name' => "Graham",
        //     'datum' => "19 Januari 2017",
        //     'marktNaam' => 'Hippiemark Amsterdam XL'
        // );
//dd($path);
    sleep(1);

            $data5 = array(
                'name' => "Graham",
                'datum' => "11 Februari 2017",
                'marktNaam' => 'Hippiemark Amsterdam XL'
            );

            \Mail::send('emails.'.$emailData['template'], $data5, function ($message) use($emailData) {

                $message->attach($emailData['pathToPdf']);
                $message->attach($emailData['pathToTerms']);

                $message->from('info@directevents.nl', 'Factuur Direct Events');

                $message->to($emailData['email'])->subject('Factuur Direct Events');

            });

            $aantal_facturen++;
            sleep(1);
        }

        return "Er zijn " . $aantal_facturen . " facturen verstuurd.";
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
