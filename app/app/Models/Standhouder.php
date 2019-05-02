<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standhouder extends Model
{
    protected $table = "standhouders";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Bedrijfsnaam', 'Voornaam', 'Achternaam', 'Straat', 'Postcode', 'Huisnummer', 'Toevoeging', 'Woonplaats', 'Land', 'Telefoon', 'Email', 'Website', 'winkelier'];

    /**
     * Get all of the markten for the standhouder.
     */
    public function markten()
    {
        return $this->hasManyThrough('App\Models\Markt', 'App\Models\Koppel_standhouders_markten',
                                    'standhouder_id', 'id', 'id');
    }

    /**
     * Gets all the standhouders for markt
     */
    public static function getStandhoudersForMarkt($markt_id)
    {
        return $table->markten->where("id", $markt_id)->toJson();
    }

    public function koppelStandhoudersMarkten()
    {
        return $this->hasOne('App\Models\Koppel_standhouders_markten');
    }

    public function koppelStandhoudersMarktenWithMarkt()
    {
        return $this->hasOne('App\Models\Koppel_standhouders_markten')->with('markt');
    }

}
