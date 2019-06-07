<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Factuur as Factuur;
use App\Models\Standhouder as Standhouder;
use App\Models\Koppel_standhouders_markten as KoppelStandhoudersMarkten;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StandhouderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function get($id)
    {
        return Standhouder::where('id', $id)->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // Credit invoice if any
        $factuur = Factuur::where('standhouder_id', $id)->where('credit', 0)->where('totaal_bedrag', '>', 0)->first();
        $credited = '';

        if (isset($factuur)) {
            // We hebben een factuur dus die moet gecrediteerd worden

            $credited = $this->credit($id, true);
        }

        if (isset($factuur) && $credited === true || !isset($factuur) && $credited === '') {
            // Remove koppel
            $standhouderExtra = KoppelStandhoudersMarkten::where('standhouder_id', $id)->firstOrFail();
            $standhouderExtra->destroy($standhouderExtra->id);
            // Remove standhouder
            $standhouder = Standhouder::where('id', $id)->firstOrFail();
            $standhouder->destroy($standhouder->id);

            return json_encode(array("success" => true));
        } else {
            return json_encode(array("success" => false, "message" => "Er is iets mis gegaan123"));
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

        return $factuurnummer;
    }

    public function credit($id, $asFunction = false) {
        $originalFactuur = Factuur::where('standhouder_id', $id)->where('credit', 0)->where('totaal_bedrag', '>', 0)->firstOrFail();
        $standhouder = Standhouder::where('id', $id)->firstOrFail();
        $standhouderExtra = KoppelStandhoudersMarkten::where('standhouder_id', $id)->firstOrFail();
        $markt = Markt::where('id', $originalFactuur->markt_id)->firstOrFail();

        // Er is nog geen credit factuur en dus gaan we een nieuwe credit factuur versturen
        $factuur = new Factuur;
        $factuur->factuurnummer = $this->geefNieuwFactuurNummer();
        $factuur->datum = new \DateTime();
        $factuur->standhouder_id = $standhouder->id;
        $factuur->markt_id = $markt->id;

        if ($factuur->afgesproken_prijs)
        {
            $factuur->totaal_bedrag = '-'.number_format(round($standhouderExtra->afgesproken_bedrag, 2), 2);
        }
        else
        {
            $dagen = count(explode(",", $standhouderExtra->dagen));
            if ($dagen > 1) {
                if ($markt->aantal_dagen == $dagen) {
                    $factuur->totaal_bedrag = '-'.number_format(round(($markt->totaal_prijs_kraam * $standhouderExtra->kraam) + ($markt->totaal_prijs_grondplek * $standhouderExtra->grondplek), 2), 2);
                }  else {
                    $factuur->totaal_bedrag = '-'.number_format(round(($dagen * $markt->bedrag_grondplek * $standhouderExtra->grondplek) + ($dagen * $markt->bedrag_kraam * $standhouderExtra->kraam)));
                }
            } else {
                $factuur->totaal_bedrag = '-'.number_format(round($markt->bedrag_grondplek * $standhouderExtra->grondplek + $markt->bedrag_kraam * $standhouderExtra->kraam, 2), 2);
            }
        }

        $factuur->betaald = 0;
        $factuur->tweede_herinnering = 0;
        $factuur->derde_herinnering = 0;
        $factuur->save();




        $aantal_dagen = count(explode(",", $standhouderExtra->dagen));
        $pdf_data = array();
        $pdf_data['dagen'] = explode(",", $standhouderExtra->dagen);
        $pdf_data['aantal_dagen'] = $aantal_dagen;
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
            $pdf_data['tabel'][0]['prijsperstuk'] = "€".'-'.number_format(round($standhouderExtra->afgesproken_bedrag/1.21, 2), 2);
            $pdf_data['tabel'][0]['totaal'] = "€ " . '-'.number_format(round($standhouderExtra->afgesproken_bedrag/1.21, 2), 2);

            $pdf_data['totaalexbtw'] = "€ " . '-'.number_format(round($standhouderExtra->afgesproken_bedrag/1.21, 2), 2);
            $pdf_data['totaalbtw'] = "€ " . '-'.number_format(round($standhouderExtra->afgesproken_bedrag/1.21*0.21, 2), 2);
            $pdf_data['totaalinbtw'] = "€ " . '-'.number_format(round($standhouderExtra->afgesproken_bedrag, 2), 2);
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
                $pdf_data['tabel'][$key]['prijsperstuk'] = "€".'-'.number_format(round($markt->bedrag_kraam/1.21, 2), 2);
                $pdf_data['tabel'][$key]['totaal'] = "€ " . '-'.number_format(round($markt->bedrag_kraam*($standhouderExtra->kraam/1.21)*$aantal_dagen, 2), 2);
            }

            if ($standhouderExtra->grondplek > 0)
            {
                $pdf_data['tabel'][] = array();
                $key = count($pdf_data['tabel']) - 1;
                $pdf_data['tabel'][$key]['factuurnummer'] =  $factuur->factuurnummer;
                $pdf_data['tabel'][$key]['aantal'] = $standhouderExtra->grondplek;
                $pdf_data['tabel'][$key]['soort'] = "Grondplek";
                $pdf_data['tabel'][$key]['btw'] = "21%";
                $pdf_data['tabel'][$key]['prijsperstuk'] = "€".'-'.number_format(round($markt->bedrag_grondplek/1.21, 2), 2);
                $pdf_data['tabel'][$key]['totaal'] = "€ " . '-'.number_format(round($markt->bedrag_grondplek*($standhouderExtra->grondplek/1.21)*$aantal_dagen, 2), 2);
            }

            $pdf_data['totaalexbtw'] = "€ " . '-'.number_format(round($standhouderExtra->kraam*($markt->bedrag_kraam/1.21)*$aantal_dagen + $standhouderExtra->grondplek*($markt->bedrag_grondplek/1.21)*$aantal_dagen, 2), 2);
            $pdf_data['totaalbtw'] = "€ " . '-'.number_format(round($standhouderExtra->kraam*($markt->bedrag_kraam/1.21*0.21)*$aantal_dagen + $standhouderExtra->grondplek*($markt->bedrag_grondplek/1.21*0.21)*$aantal_dagen, 2), 2);
            $pdf_data['totaalinbtw'] = "€ " . '-'.number_format(round($standhouderExtra->kraam*$markt->bedrag_kraam*$aantal_dagen + $standhouderExtra->grondplek*$markt->bedrag_grondplek*$aantal_dagen, 2), 2);
        }

        $pdf_data['vervaldatum'] = date('d-m-Y', strtotime(date("d-m-Y"). ' + 8 days'));

        $pdf_data['standhouder'] = array();
        $pdf_data['standhouder']['bedrijfsnaam'] = $standhouder->Bedrijfsnaam;
        $pdf_data['standhouder']['adres'] = $standhouder->Straat . " " . $standhouder->Huisnummer;
        $pdf_data['standhouder']['postcodeplaats'] = $standhouder->Postcode . ", " . $standhouder->Woonplaats;

        // return \PDF::loadView('pdf.factuur', $pdf_data)->stream();

        $path = dirname(__DIR__) . "../../../public/pdf/".date("Y")."/".$factuur->factuurnummer.".pdf";
//        $pathToAlgemeneVoorwaarden = dirname(__DIR__) . "../../../public/algemene voorwaarden/algemene voorwaarden.pdf";

        $pdf = \PDF::loadView('pdf.factuur', $pdf_data)->save( $path );

        $emailData = array(
            'template' => $markt->{"factuur-mail-template"},
            'email' => $standhouder->Email,
            'pathToPdf' => $path,
            'markt' => $markt
        );

        $data5 = array(
            'dagen' => explode(",", $standhouderExtra->dagen),
            'name' => "Graham",
            'datum' => "11 Februari 2017",
            'marktNaam' => 'Hippiemark Amsterdam XL',
            'markt' => $markt,
            'credit' => 1
        );

        \Mail::send('emails.'.$emailData['template'], $data5, function ($message) use($emailData) {

            $message->attach($emailData['pathToPdf']);

            $message->from('info@directevents.nl', 'Credit factuur Direct Events');

            $message->to($emailData['email'])->subject('Credit factuur Direct Events');

        });

        // Set original invoice to credited
        $originalFactuur->credit = 1;
        $originalFactuur->save();

        if (!$asFunction) {
            return json_encode(array("success" => true, "message" => "De credit factuur voor de standhouder is aangemaakt en verstuurd."));
        } else {
            return true;
        }
    }
}
