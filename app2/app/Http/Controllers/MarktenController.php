<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Standhouder as Standhouder;
use App\Models\Koppel_standhouders_markten as KoppelStandhoudersMarkten;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarktenController extends Controller
{
    /**
     * Show the main page
     *
     * @return Response
     */
    public function getIndex()
    {
        $markten = Markt::orderBy('datum', 'desc')->get();
        return View('users.markten')->with('markten', $markten);
    }

    /**
     * Get page for markt
     *
     * @return Response
     */
    public function getMarkt($slug)
    {
        $data = array();

        $data['slug'] = $slug;

        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->get();

        $data['standhouders'] = array();
        $data['aantal_standhouders'] = 0;
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->id)->firstOrFail();
            if ($standhouder) {
                $data['standhouders'][$koppelStuk->id] = $standhouder;
                $data['aantal_standhouders']++;
            }
        }

        return View('users.markt')->with('data', $data);
    }

    /**
     * Get page for markt
     *
     * @return Response
     */
    public function getMarktAanmeldingen($slug)
    {
        $data = array();

        $data['slug'] = $slug;

        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->get();

        $data['standhouders'] = array();
        $data['aantal_standhouders'] = 0;
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->id)->firstOrFail();
            if ($standhouder) {
                $data['standhouders'][$koppelStuk->id] = $standhouder;
                $data['aantal_standhouders']++;
            }
        }

        return View('users.aanmeldingen')->with('data', $data);
    }

    /**
     * Export standhouders for markt
     *
     * @return Response
     */
    public function exportAllStandhoudersForMarkt($slug)
    {

        $data = array();
        // dd($slug);
        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->get();


        $data['standhouders'] = array();
        $data['aantal_standhouders'] = 0;
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->id)->firstOrFail();
            if ($standhouder) {
                $data['standhouders'][$koppelStuk->id] = $standhouder;
                $data['aantal_standhouders']++;
            }
        }

        $exportData = array();

        $headers = array();
        $headers[] = '#';
        $headers[] = 'Bedrijfsnaam';
        $headers[] = 'Naam';
        $headers[] = 'Telefoon';
        $headers[] = 'E-mail';
        $headers[] = 'Website';
        $headers[] = 'Type';
        $headers[] = 'Kraam';
        $headers[] = 'Grondplek';
        $headers[] = 'Bedrag';
        $headers[] = 'Betaald';
        $headers[] = 'Grote maten';
        $headers[] = 'Dames kleding';
        $headers[] = 'Heren kleding';
        $headers[] = 'Kinder kleding';
        $headers[] = 'Baby kleding';
        $headers[] = 'Fashion accessoires';
        $headers[] = 'Schoenen';
        $headers[] = 'Lifestyle';
        $headers[] = 'Woon accessoires';
        $headers[] = 'Kunst';
        $headers[] = 'Sieraden';
        $headers[] = 'Tassen';
        $headers[] = 'Brocante';
        $headers[] = 'Dieren spullen';
        $headers[] = 'Anders';

        $exportData[] = $headers;

        $x = 0;
        // for ($x=0;$x < count($data['standhouders']); $x++)
        foreach($data['standhouders'] as $standhouder)
        {
            $newRow = array();
            $newRow[] = $standhouder->id;
            $newRow[] = $standhouder->Bedrijfsnaam;
            $newRow[] = $standhouder->Voornaam . " " . $standhouder->Achternaam;
            $newRow[] = $standhouder->Telefoon;
            $newRow[] = $standhouder->Email;
            $newRow[] = $standhouder->Website;

            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->type;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->kraam;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->grondplek;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->bedrag;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->betaald;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->{"grote-maten"};
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->{"dames-kleding"};
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->{"heren-kleding"};
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->{"kinder-kleding"};
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->{"baby-kleding"};
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->{"fashion-accessoires"};
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->schoenen;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->lifestyle;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->{"woon-accessoires"};
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->kunst;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->sieraden;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->tassen;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->brocante;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->dierenspullen;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->anders;

            $exportData[] = $newRow;
            $x++;
        }

        \Excel::create($slug." ".date("Y-m-d"), function($excel) use($exportData) {

            $excel->sheet('Standhouders', function($sheet) use($exportData) {

                $sheet->fromArray($exportData, null, 'A1', false, false);

            });

        })->export('xls');
    }

    /**
     * Creates standhouder table voor single markt
     *
     * @return Response
     */
    public function getStandhouderTableJSON(Request $request)
    {
        // $markten = Markt::orderBy('datum', 'desc')->get();
        // return View('users.markten')->with('markten', $markten);
        // $json = Standhouder::markten->where("id", $request->input("markt_id"))->toJson();
        // $markt = Markt::where("id", "1")->get();
        $data = array();
        $data['standhouders'] = DB::select('SELECT standhouders.* FROM standhouders INNER JOIN koppel_standhouders_markten ON koppel_standhouders_markten.standhouder_id=standhouders.id WHERE koppel_standhouders_markten.markt_id = ?', [$request->input('id')]);

        return $data;
    }
}
