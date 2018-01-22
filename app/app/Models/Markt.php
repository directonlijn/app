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
    public $fillable = [
                'Naam',
                'Datum_van',
                'Datum_tot',
                'van-tijd',
                'tot-tijd',
                'Website',
                'Adres',
                'Huisnummer',
                'Toevoeging',
                'Postcode',
                'Plaats',
                'Land',
                'bedrag_grondplek',
                'bedrag_kraam',
                'aantalPlekken',
                'aantalGeselecteerd',
                'welcome-mail-template',
                'factuur-mail-template',
                'algemene-voorwaarden-template',
                'totaal_prijs_kraam',
                'totaal_prijs_grondplek',
                'aantal_dagen'
            ];

    /**
     * Get all standhouders with an invoice
     */
    public function getStandhoudersWithInvoice()
    {
        return $this->hasMany('App\Models\Factuur', 'markt_id', 'id');
    }

    /**
     * Get all standhouders with a payed invoice
     */
    public function getStandhoudersWithPayedInvoice()
    {
        return $this->hasMany('App\Models\Factuur', 'markt_id', 'id')->where('betaald', '=', 1);
    }

    /**
     * Get all standhouders with a unpayed invoice
     */
    public function getStandhoudersWithUnpayedInvoice()
    {
        return $this->hasMany('App\Models\Factuur', 'markt_id', 'id')->where('betaald', '=', 0);
    }

    /**
     * Retrieves all selected standhouders
     */
    public function getSelectedStandhouders()
    {
        return $this->getKoppelData()->where('selected', '=', 1);
    }

    /**
     * Retrieves all winkeliers
     */
    public function getSelectedShopkeepers()
    {
        return $this->standhouders_all()->where('selected', '=', 1)->where('winkelier', '=', 1);
    }

    /**
     * Get all of the standhouders for the markt with additional data.
     */
    public function getKoppelData()
    {
        return $this->hasMany('App\Models\Koppel_standhouders_markten', 'markt_id', 'id');
    }

    /**
    * Get all of the standhouders for the markt with additional data.
    */
    public function standhouders_all()
    {
        return $this->hasManyThrough('App\Models\Standhouder', 'App\Models\Koppel_standhouders_markten',
                                'markt_id', 'id', 'id', 'standhouder_id');
    }

}
