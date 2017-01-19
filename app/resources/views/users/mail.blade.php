@extends('baselayout')

@section('title') Mail @stop

@section('bottom')
    <?php
        echo realpath(dirname(__FILE__));
        echo realpath(__DIR__.'../../../vendor/google-api-php-client/vendor/autoload.php');
        require_once '/home/directevents/domains/directevents.nl/app/vendor/google-api-php-client/src/Google/autoload.php';
    ?>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="position: absolute;">
            <ul class="nav nav-sidebar">
                <li class="markt-overview"><a href="/markten/{{ $data['slug'] }}">Overzicht <span class="sr-only"></span></a></li>
                <li class="markt-aanmeldingen active"><a href="/markten/{{ $data['slug'] }}/aanmeldingen">Aanmeldingen <span class="sr-only">(current)</span></a></li>
                <li class="markt-aanmeldingen"><a href="/markten/{{ $data['slug'] }}/geselecteerd">Geselecteerd <span class="sr-only"></span></a></li>
                <li class="markt-betaald">Betaald <span class="sr-only"></span></li>
                <li class="markt-openstaand">Openstaand <span class="sr-only"></span></li>
                <li class="markt-kosten">Kosten <span class="sr-only"></span></li>
            </ul>
        </div>
    </div>
@stop
