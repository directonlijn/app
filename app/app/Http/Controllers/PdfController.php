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
        $standhouder_merged['adres'] = $standhouder->Straat . " " . $standhouder->Huisnummer;
        $standhouder_merged['postcodeplaats'] = $standhouder->Postcode . ", " . $standhouder->Woonplaats;

        // dd($standhouder_merged);
        return $standhouder_merged;
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
                        if ($standhouder) {
                            $data['facturen']['tweede']['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                        }


                    }
                    // kijk of de derde herinnering gestuurd is en of het al langer dan 28 dagen geleden is t.o.v. de eerste factuur
                    else if (!$factuur->derde_herinnering && $diff->days > 28)
                    {
                        // return "langer dan 28 dagen geleden en nog geen derde herinnering gestuurd.";
                        $data['facturen']['derde']['totaal']++;

                        $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->first();
                        if ($standhouder) {
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

        $testText = "";

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
            $pathToAlgemeneVoorwaarden = dirname(__DIR__, 3) . "/public/algemene voorwaarden/Algemene voorwaarden Hippiemarkt Amsterdam XL.pdf";

            $pdf = \PDF::loadView('pdf.factuur', $pdf_data)->save( $path );
            // return $pdf->stream();
            // return $pdf;
            sleep(1);

            $testText .= " pdf created for " . $pdf_data['standhouder']['bedrijfsnaam'];

            $emailData = array(
                'template' => "factuur",
                'email' => "grahamneal1991@gmail.com",
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
                'datum' => "19 Januari 2017",
                'marktNaam' => 'Hippiemark Amsterdam XL'
            );

            \Mail::send('emails.'.$emailData['template'], $data5, function ($message) use($emailData) {

                $message->attach($emailData['pathToPdf']);
                $message->attach($emailData['pathToTerms']);

                $message->from('info@directevents.nl', 'Factuur Direct Events');

                $message->to($emailData['email'])->subject('Factuur Direct Events');

            });

            $testText .= " mail sent to " . $pdf_data['standhouder']['bedrijfsnaam'];

            $aantal_facturen++;
            sleep(2);
        }

        // return "Er zijn " . $aantal_facturen . " facturen verstuurd.";
        return $testText;
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
