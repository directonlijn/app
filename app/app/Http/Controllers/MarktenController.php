<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Standhouder as Standhouder;
use App\Models\Factuur as Factuur;
use App\Models\Koppel_standhouders_markten as KoppelStandhoudersMarkten;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarktenController extends Controller
{

    public function test()
    {
        $markt = Markt::where('id', 2)->firstOrFail();
        $template_name = $markt->{"welcome-mail-template"};
        $data = array(
            'data' => array(
                    'template' => $template_name,
                    'email' => 'grahamneal1991@gmail.com'
                )
        );

        \App::call('App\Http\Controllers\MailController@sendWelcomeMail', $data);
    }

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
     * Show magement page for all the markten
     *
     * @return Response
     */
    public function getManagement()
    {
        // dd("test");
        // return View('users.management-markten');
        $markten = Markt::orderBy('datum', 'Naam')->get();
        return View('users.management-markten')->with('markten', $markten);
    }

    /**
     * Get Markt Data
     *
     * @return Response
     */
    public function getMarktManagement(Request $request)
    {
        try {
            $markt = Markt::where('id', $request->input("markt_id"))->firstOrFail();
            return json_encode(array("code" => "200", "data" => $markt, "message" => "Markt data is opgehaald."));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_encode(array("code" => "400", "message" => "Markt kon niet gevonden worden."));
        }
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

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->orderBy('standhouder_id', 'desc')->take(10)->get();

        $data['standhouders'] = array();
        $data['aantal_standhouders'] = $count = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->count();
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder) {
                $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
            }
        }

        $data['koppelStandhoudersSelected'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)
                                                        ->where('selected', 1)
                                                        ->orderBy('standhouder_id', 'desc')
                                                        ->take(10)
                                                        ->get();

        $data['selected'] = array();
        foreach($data['koppelStandhoudersSelected'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder) {
                $data['selected'][$koppelStuk->standhouder_id] = $standhouder;
            }
        }

        return View('users.markt')->with('data', $data);
    }

    /**
     * Get page for markt met alle aanmeldingen
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
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();

            if ($standhouder && $standhouder->winkelier != 1) {
                $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;

                try {
                    $factuur = Factuur::where('markt_id', $data['markt']->id)->where("standhouder_id", $koppelStuk->standhouder_id)->firstOrFail();
                    if ($factuur) {
                        $data['factuur'][$koppelStuk->standhouder_id] = $factuur;
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        return View('users.aanmeldingen')->with('data', $data);
    }

    /**
     * Get standhouderData
     *
     * @return Response
     */
    public function getStandhouder(Request $request)
    {
        $data = array();
        $data['standhouderMarktData'] = KoppelStandhoudersMarkten::where("markt_id", $request->input('markt_id'))->where('standhouder_id', $request->input('standhouder_id'))->firstOrFail();

        $data['standhouder'] = Standhouder::where('id', $data['standhouderMarktData']['standhouder_id'])->firstOrFail();

        $data['factuur'] = ($this->getFactuurModel($data['standhouderMarktData']['standhouder_id']));

        return $data;
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
     * Get facuur Model by ID
     *
     * @return Model or false
     */
    private function getFactuurModel($id)
    {
        try {
            return Factuur::where('id', $id)->firstOrFail();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get standhouderData
     *
     * @return Response
     */
    public function changeStandhouder(Request $request)
    {

        $markt = $this->getMarktModel($request->input("markt_id"));
        if ($markt == false) return json_encode(array("message" => "De bijbehorende markt kon niet gevonden worden."));

        $standhouderData = array("Bedrijfsnaam", "Voornaam", "Achternaam", "Email", "Telefoon", "Website", "Straat", "Postcode", "Huisnummer", "Toevoeging", "Woonplaats");
        $standhouderMarktData = array(
                    "afgesproken_prijs",
                    "afgesproken_bedrag",
                    "kraam",
                    "grondplek",
                    "anders",
                    "baby-kleding",
                    "brocante",
                    "dames-kleding",
                    "dierenspullen",
                    "fashion-accesoires",
                    "selected",
                    "grote-maten",
                    "heren-kleding",
                    "kinder-kleding",
                    "kunst",
                    "lifestyle",
                    "schoenen",
                    "sieraden",
                    "stroom",
                    "tassen",
                    "woon-accessoires"
                );

        try {
            $koppelStandhoudersMarkten = KoppelStandhoudersMarkten::where("markt_id", $request->input("markt_id"))->where('standhouder_id', $request->input("id"))->firstOrFail();

            $koppelStandhoudersMarkten->type = $request->input("foodNonfood");

            foreach ($standhouderMarktData as $dataItem)
            {
                if (null !== $request->input($dataItem))
                    $koppelStandhoudersMarkten->$dataItem = $request->input($dataItem);
            }

            $koppelStandhoudersMarkten->bedrag = ($markt->bedrag_kraam * $request->input("kraam") + $markt->bedrag_grondplek * $request->input("grondplek"));
            $this->setStandhouderBetaaldBedrag($request->input("markt_id"), $request->input("id"), ($markt->bedrag_kraam * $request->input("kraam") + $markt->bedrag_grondplek * $request->input("grondplek")), $request->input("betaald"));

            $koppelStandhoudersMarkten->save();

            try {
                $standhouder = $this->getStandhouderModel($koppelStandhoudersMarkten->standhouder_id);

                foreach ($standhouderData as $dataItem)
                {
                    if ($request->input($dataItem))
                        $standhouder->$dataItem = $request->input($dataItem);
                }

                $standhouder->save();

                $factuur = $this->getFactuurModel($request->input("markt_id"), $request->input("standhouder_id"));
                if ($factuur != false)
                {
                    $factuur->betaald = $request->input("betaald");
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return json_encode(array("message" => "De marktdata voor de desbetreffende standhouder is bijgewerkt. Alleen de standhouder is niet gevonden en de contact/adres gegevens konden niet bijgewerkt worden."));
            }

            return json_encode(array("message" => "Standhouder is geupdate"));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_encode(array("message" => "Standhouder is niet gevonden bij de markt"));
        }
    }

    /**
     * Get page for markt met alle geselecteerde aanmeldingen
     *
     * @return Response
     */
    public function getMarktSelected($slug)
    {
        $data = array();

        $data['slug'] = $slug;

        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)
                                                        ->where('selected', 1)
                                                        ->get();

        $data['standhouders'] = array();
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder && $standhouder->winkelier != 1) {
                $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;

                try {
                    $factuur = Factuur::where('markt_id', $data['markt']->id)->where("standhouder_id", $koppelStuk->standhouder_id)->firstOrFail();
                    if ($factuur) {
                        $data['factuur'][$koppelStuk->standhouder_id] = $factuur;
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        return View('users.selected')->with('data', $data);
    }

    /**
     * Get page for markt met alle betaalde aanmeldingen
     *
     * @return Response
     */
    public function getMarktBetaald($slug)
    {
        $data = array();

        $data['slug'] = $slug;

        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)
                                                        ->where('selected', 1)
                                                        ->get();

        $data['standhouders'] = array();
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder) {
                try {
                    $factuur = Factuur::where('markt_id', $data['markt']->id)->where("standhouder_id", $koppelStuk->standhouder_id)->firstOrFail();
                    if ($factuur->betaald == 1) {
                        $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                        $data['factuur'][$koppelStuk->standhouder_id] = $factuur;
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        return View('users.betaald')->with('data', $data);
    }

    /**
     * Get page for markt met alle openstaand aanmeldingen
     *
     * @return Response
     */
    public function getMarktOpenstaand($slug)
    {
        $data = array();

        $data['slug'] = $slug;

        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)
                                                        ->where('selected', 1)
                                                        ->get();

        $data['standhouders'] = array();
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder) {
                try {
                    $factuur = Factuur::where('markt_id', $data['markt']->id)->where("standhouder_id", $koppelStuk->standhouder_id)->firstOrFail();
                    if ($factuur->betaald == 0) {
                        $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                        $data['factuur'][$koppelStuk->standhouder_id] = $factuur;
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        return View('users.openstaand')->with('data', $data);
    }

    /**
     * Get page for markt met alle winkeliers
     *
     * @return Response
     */
    public function getMarktWinkeliers($slug)
    {
        $data = array();

        $data['slug'] = $slug;

        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)
                                                        ->where('selected', 1)
                                                        ->get();

        $data['standhouders'] = array();
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder && $standhouder->winkelier == 1) {
                $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;

                try {
                    $factuur = Factuur::where('markt_id', $data['markt']->id)->where("standhouder_id", $koppelStuk->standhouder_id)->firstOrFail();
                    if ($factuur) {
                        $data['factuur'][$koppelStuk->standhouder_id] = $factuur;
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        return View('users.winkeliers')->with('data', $data);
    }

    /**
     * Set standhouder seen
     *
     * @return Response
     */
    public function setStandhouderSeen(Request $request)
    {
        // dd($request->input('id'));

        $standhouder = KoppelStandhoudersMarkten::where('markt_id', $request->input('markt_id'))->where('standhouder_id', $request->input('standhouder_id'))->firstOrFail();
        $standhouder->seen = $request->input('value');

        $standhouder->save();
    }

    /**
     * Set standhouder selected
     *
     * @return Response
     */
    public function setStandhouderSelected(Request $request)
    {
        // dd($request->input('id'));

        $standhouder = KoppelStandhoudersMarkten::where('markt_id', $request->input('markt_id'))->where('standhouder_id', $request->input('standhouder_id'))->firstOrFail();
        $standhouder->selected = $request->input('value');

        $standhouder->save();
    }

    /**
     * Set standhouder betaald with request
     *
     * @return Response
     */
    public function setStandhouderBetaaldRequest(Request $request)
    {
        // dd($request->input('id'));
        try {
            $factuur = Factuur::where('markt_id', $request->input('markt_id'))->where('standhouder_id', $request->input('standhouder_id'))->firstOrFail();
            $factuur->betaald = $request->input('value');

            $factuur->save();

            return json_encode(array("message" => "De standhouder factuur betaald is gewijzigd."));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return json_encode(array("message" => "De factuur is niet gevonden of nog niet aangemaakt."));
        }
    }

    /**
     * Set standhouder betaald
     *
     * @return Response
     */
    private function setStandhouderBetaaldBedrag($markt_id, $standhouder_id, $bedrag, $betaald)
    {
        // dd($request->input('id'));
        try {
            $factuur = Factuur::where('markt_id', $markt_id)->where('standhouder_id', $standhouder_id)->firstOrFail();
            $factuur->totaal_bedrag = $bedrag;
            $factuur->betaald = $betaald;

            $factuur->save();

            return true;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
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
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder && $standhouder->winkelier != 1) {
                $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                $data['aantal_standhouders']++;
            }
        }

        $this->exportStandhouders($data, $slug);
    }

    /**
     * Export selected standhouders for markt
     *
     * @return Response
     */
    public function exportAllSelectedStandhoudersForMarkt($slug)
    {

        $data = array();
        // dd($slug);
        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->where("selected", 1)->get();


        $data['standhouders'] = array();
        $data['aantal_standhouders'] = 0;
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder && $standhouder->winkelier != 1) {
                $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                $data['aantal_standhouders']++;
            }
        }

        $this->exportStandhouders($data, $slug);
    }

    /**
     * Export payed standhouders for markt
     *
     * @return Response
     */
    public function exportAllPayedStandhoudersForMarkt($slug)
    {

        $data = array();
        // dd($slug);
        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->where("selected", 1)->get();


        $data['standhouders'] = array();
        $data['aantal_standhouders'] = 0;
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder && $standhouder->winkelier != 1) {
                try {
                    $factuur = Factuur::where('markt_id', $data['markt']->id)->where("standhouder_id", $koppelStuk->standhouder_id)->firstOrFail();
                    if ($factuur->betaald == 1) {
                        $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                        $data['factuur'][$koppelStuk->standhouder_id] = $factuur;
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        $this->exportStandhouders($data, $slug);
    }

    /**
     * Export unpayed standhouders for markt
     *
     * @return Response
     */
    public function exportAllOpenstaandeStandhoudersForMarkt($slug)
    {

        $data = array();
        // dd($slug);
        $data['markt'] = Markt::where('Naam', $slug)->firstOrFail();

        $data['koppelStandhoudersMarkten'] = KoppelStandhoudersMarkten::where('markt_id', $data['markt']->id)->where("selected", 1)->get();


        $data['standhouders'] = array();
        $data['aantal_standhouders'] = 0;
        foreach($data['koppelStandhoudersMarkten'] as $koppelStuk)
        {
            $standhouder = Standhouder::where('id', $koppelStuk->standhouder_id)->firstOrFail();
            if ($standhouder && $standhouder->winkelier != 1) {
                try {
                    $factuur = Factuur::where('markt_id', $data['markt']->id)->where("standhouder_id", $koppelStuk->standhouder_id)->firstOrFail();
                    if ($factuur->betaald == 0) {
                        $data['standhouders'][$koppelStuk->standhouder_id] = $standhouder;
                        $data['factuur'][$koppelStuk->standhouder_id] = $factuur;
                    }
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        $this->exportStandhouders($data, $slug);
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

    /**
     * Exports standhouders to excel
     * @var $standhouders - de standhouders die geexporteerd moeten worden
     *
     * @return Response
     */
    private function exportStandhouders($data, $slug)
    {
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
        $headers[] = 'Gezien';
        $headers[] = 'Geselecteerd';

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
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->seen;
            $newRow[] = $data['koppelStandhoudersMarkten'][$x]->selected;

            $exportData[] = $newRow;
            $x++;
        }

        \Excel::create($slug." ".date("Y-m-d"), function($excel) use($exportData) {

            $excel->sheet('Standhouders', function($sheet) use($exportData) {

                $sheet->fromArray($exportData, null, 'A1', false, false);

            });

        })->export('xls');
    }
}
