<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factuur extends Model
{
    protected $table = "factuur";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['factuurnummer','datum','standhouder_id','markt_id','totaal_bedrag','betaald','tweede_herinnering','tweede_herinnering_datum','derde_herinnering','derde_herinnering_datum'];

}
