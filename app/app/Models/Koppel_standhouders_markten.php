<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koppel_standhouders_markten extends Model
{
    protected $table = "koppel_standhouders_markten";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'markt_id',
                'standhouder_id',
                'type',
                'kraam',
                'grondplek',
                'bedrag',
                'grote-maten',
                'dames-kleding',
                'heren-kleding',
                'kinder-kleding',
                'baby-kleding',
                'fashion-accessoires',
                'schoenen',
                'lifestyle',
                'woon-accessoires',
                'kunst',
                'sieraden',
                'tassen',
                'brocante',
                'dierenspullen',
                'anders',
                'seen',
                'selected',
                'factuurnummer',
                'afgesproken_prijs',
                'afgesproken_bedrag'
            ];



}
