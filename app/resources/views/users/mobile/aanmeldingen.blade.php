@extends('baselayout-mobile')

@section('title') Markten @stop

@section('bottom')
    <script src="/assets/js/aanmelding-geselecteerd.js"></script>
@stop

@section('content')
    <?php
        // dd($data);
        // dd($data['koppelStandhoudersMarkten'][0]);
        // dd($data['standhouders'][1]->id);
        // dd($data['koppelStandhoudersMarkten'][0]['markt_id']);
    ?>
    <div class="token">{{ csrf_token() }}</div>


@stop
