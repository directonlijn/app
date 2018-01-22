<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Factuur as Factuur;
use App\Models\Standhouder as Standhouder;
use App\Models\Koppel_standhouders_markten as KoppelStandhoudersMarkten;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Jenssegers\Agent\Agent;

class PageController extends Controller
{
    private $agent;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->agent = new Agent();
        // $this->middleware('auth');
        //
        // $this->middleware('log')->only('index');
        //
        // $this->middleware('subscribed')->except('store');
    }
    // To have the agent in all the functions
    // public $agent = new Agent();

    /**
     * Get all events
     *
     * @return events
     */
    private function getAllEvents()
    {
        return Markt::orderBy('Datum_van', 'desc')->get();
    }

    /**
     * Load the dashboard
     *
     * @return Response
     */
    public function getDashboard()
    {
        // Get markt slugs with count of new standhouders
        $markten = $this->getAllEvents();

        $events = array();
        foreach ($markten as $markt) {
            $temp_array = array();
            $temp_array['name'] = $markt->Naam;
            $temp_array['amount_subscribers'] = $markt->getKoppelData->count();
            $temp_array['amount_selected'] = $markt->getSelectedStandhouders->count();
            $temp_array['amount_shopkeepers'] = $markt->getSelectedShopkeepers->count();
            $temp_array['amount_payed'] = $markt->getStandhoudersWithPayedInvoice->count();
            $temp_array['amount_unpayed'] = $markt->getStandhoudersWithUnpayedInvoice->count();

            $events[] = $temp_array;
        }

        if ($this->agent->isMobile()) {
            return View('users.mobile.dashboard')->with('events', $events);
        } else {
            return View('users.dashboard')->with('events', $events);
        }
    }

    /**
     * Retrieves markt for slug
     *
     * @return Markt
     */
    public function getMarktForSlug($slug)
    {
        return Markt::where('Naam', $slug)->firstOrFail();
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

        $data['markt'] = $this->getMarktForSlug($slug);

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

        if ($this->agent->isMobile()) {
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
            
            return View('users.mobile.aanmeldingen')->with('data', $data);
        } else {
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

    }
}
