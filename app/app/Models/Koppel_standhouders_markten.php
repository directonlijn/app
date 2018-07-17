<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Koppel_standhouders_markten extends Model
{
    use SoftDeletes;

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
                'afgesproken_bedrag',
                'dagen'
            ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}
