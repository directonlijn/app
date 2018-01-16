<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Factuur as Factuur;
use App\Models\Standhouder as Standhouder;
use App\Models\Koppel_standhouders_markten as KoppelStandhoudersMarkten;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Get all the participants for the event
     *
     * @return Response
     */
    public function getEventParticipants($slug)
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

        return View('users.registrations')->with('data', $data);
    }
}
