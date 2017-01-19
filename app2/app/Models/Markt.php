<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Markt extends Model
{
    protected $table = "markten";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['Naam', 'Datum', 'van-tijd', 'tot-tijd', 'Website', 'Adres', 'Huisnummer', 'Toevoeging', 'Postcode', 'Plaats', 'Land', 'bedrag_grondplek', 'bedrag_kraam', 'aantalPlekken', 'aantalGeselecteerd'];

    /**
     * Get all of the standhouders for the markt.
     */
    public function standhouders()
    {
        return $this->hasManyThrough('Standhouder', 'Koppel_standhouders_markten',
                                    'markt_id', 'id', 'id');
    }

}
