@extends('baselayout-mobile')

@section('title') Markten @stop

@section('bottom')
    <script src="/assets/js/aanmelding-geselecteerd.js"></script>
@stop

@section('content')
    <?php
        // dd($data);
        // dd($data['koppelStandhoudersMarkten']);
        // dd($data['koppelStandhoudersMarkten'][0]);
        // dd($data['standhouders']);
        // dd($data['standhouders'][6]);
        // dd($data['standhouders'][0]->id);
        // dd($data['koppelStandhoudersMarkten'][0]['markt_id']);

        $standhouders = array();

        foreach($data['koppelStandhoudersMarkten'] as $koppel_standhouder) {
            if (isset($data['standhouders'][$koppel_standhouder->standhouder_id])) {
                $standhouders[$koppel_standhouder->standhouder_id] = array();
                $standhouders[$koppel_standhouder->standhouder_id]['koppel'] = $koppel_standhouder;
                $standhouders[$koppel_standhouder->standhouder_id]['standhouder'] = $data['standhouders'][$koppel_standhouder->standhouder_id];
            }
        }

        // dd($standhouders);
    ?>
    <div class="token">{{ csrf_token() }}</div>

    <style>
    	.panel-default>.panel-heading .badge {
        float: right;
        float: right;
      }
    </style>
    <div class="row nav-blocks">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach ($standhouders as $index => $standhouder)
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id='heading-index'>
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#list-index-{{ $index }}" aria-expanded="false" aria-controls="list-index">
                                {{ $standhouder['standhouder']->Bedrijfsnaam }}
                                <!-- <span class="badge badge-default badge-pill">10</span> -->
                            </a>
                        </h4>
                    </div>
                    <div id="list-index-{{ $index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="">
                        <ul class="list-group">
                            <li class="list-group-item">
                                Naam: {{ $standhouder['standhouder']->Voornaam }} {{ $standhouder['standhouder']->Achternaam }}
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xs-6">
                                        Telefoon: {{ $standhouder['standhouder']->Telefoon }}
                                    </div>
                                    <div class="col-xs-6">
                                        Email: {{ $standhouder['standhouder']->Email }}
                                    </div>
                                </diV>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xs-6">
                                        Kramen: {{ $standhouder['koppel']->kraam }}
                                    </div>
                                    <div class="col-xs-6">
                                        Grondplekken: {{ $standhouder['koppel']->grondplek }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <button id="credit" class="btn btn-warning" data-id="{{ $index }}">Crediteren</button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button id="delete" class="btn btn-danger" data-id="{{ $index }}">Verwijderen</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(document).on('click', '#delete', function(){
                var id = $(this).attr('data-id');

                $.post({
                    type: 'GET',
                    url: '/standhouder/delete/'+id
                })
                .done(function(data){
                    data = JSON.parse(data);
                    console.log(data);
                    if (data.success) {
                        alert('Verwijderd en gecrediteerd als er een factuur gestuurd was.');
                    } else {
                        alert('Er is iets mis gegaan');
                    }
                })
                .fail(function(data){
                    console.log(data);
                    alert('Er is iets mis gegaan');
                });
            });

            $(document).on('click', '#credit', function(){
                var id = $(this).attr('data-id');

                $.post({
                    type: 'GET',
                    url: '/standhouder/credit/'+id
                })
                .done(function(data){
                    data = JSON.parse(data);
                    console.log(data);
                    if (data.success) {
                        alert('Gecrediteerd');
                    } else {
                        alert('Er is iets mis gegaan');
                    }
                })
                .fail(function(data){
                    // data = JSON.parse(data);
                    console.log(data);
                    if (data.status == '404') {
                        alert('Waarschijnlijk bestaat er geen factuur');
                    } else {
                        alert('Er is iets mis gegaan');
                    }
                });
            });
        });
    </script>
@stop
