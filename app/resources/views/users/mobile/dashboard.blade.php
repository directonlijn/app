@extends('baselayout-mobile')

@section('title') Dashboard @stop

@section('content')
<?php
	// dd($events);
    $markten = App\Models\Markt::orderBy('Datum_van', 'desc')->get();
?>
<style>
	.panel-default>.panel-heading .badge {
    float: right;
  }
</style>
<div class="row nav-blocks">
	<!-- <div class="col-xs-12">
		<h1 style="text-align:center;">Dashboard</h1>
	</div> -->

  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach ($events as $index => $event)
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id='heading{{ $index }}'>
          <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#list{{ $index }}" aria-expanded="false" aria-controls="list{{ $index }}">
            {{ $event['name'] }}
            <span class="badge badge-default badge-pill">{{ $event['amount_subscribers'] }}</span>
          </a>
        </h4>
        </div>
        <div id="list{{ $index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="">
          <ul class="list-group">
            <a href="/markten/{{ $event['name'] }}/aanmeldingen" class="list-group-item">
              Aanmeldingen
              <span class="badge badge-default badge-pill">{{ $event['amount_subscribers'] }}</span>
            </a>
            <a href="/markten/{{ $event['name'] }}/geselecteerd" class="list-group-item">
              Geselecteerd
              <span class="badge badge-default badge-pill">{{ $event['amount_selected'] }}</span>
            </a>
            <a href="/markten/{{ $event['name'] }}/winkeliers" class="list-group-item">
              Winkeliers
              <span class="badge badge-default badge-pill">{{ $event['amount_shopkeepers'] }}</span>
            </a>
            <a href="/markten/{{ $event['name'] }}/betaald" class="list-group-item">
              Betaald
              <span class="badge badge-default badge-pill">{{ $event['amount_payed'] }}</span>
            </a>
            <a href="/markten/{{ $event['name'] }}/openstaand" class="list-group-item">
              Openstaand
              <span class="badge badge-default badge-pill">{{ $event['amount_unpayed'] }}</span>
            </a>
          </ul>
        </div>
      </div>
    @endforeach
  </div>

</div>
@stop
