<?php

namespace App\Http\Controllers;

use App\Models\Markt as Markt;
use App\Models\Standhouder as Standhouder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarktController extends Controller
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
        // $data = array();
        // $data['standhouders'] = DB::select('
        //         SELECT standhouders.*
        //         FROM standhouders
        //         INNER JOIN koppel_standhouders_markten
        //         ON koppel_standhouders_markten.standhouder_id=standhouders.id
        //         INNER JOIN markten
        //         ON koppel_standhouders_markten.markt_id = markten.id
        //         WHERE markten.Naam = ?',
        //     [$slug]);

        // return View('markt.{$slug}');
        return view("markt.{$slug}");
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
