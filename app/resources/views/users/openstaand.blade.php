@extends('baselayout')

@section('title') Markten @stop

@section('bottom')
    <script src="/assets/js/aanmelding-geselecteerd.js"></script>
@stop

@section('content')
    <div class="token">{{ csrf_token() }}</div>
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="position: absolute;">
            <ul class="nav nav-sidebar">
                <li class="markt-overview"><a href="/markten/{{ $data['slug'] }}">Overzicht <span class="sr-only"></span></a></li>
                <li class="markt-aanmeldingen active"><a href="/markten/{{ $data['slug'] }}/aanmeldingen">Aanmeldingen <span class="sr-only">(current)</span></a></li>
                <li class="markt-aanmeldingen"><a href="/markten/{{ $data['slug'] }}/geselecteerd">Geselecteerd <span class="sr-only"></span></a></li>
                <li class="markt-aanmeldingen"><a href="/markten/{{ $data['slug'] }}/winkeliers">Winkeliers <span class="sr-only"></span></a></li>
                <li class="markt-betaald"><a href="/markten/{{ $data['slug'] }}/betaald">Betaald <span class="sr-only"></span></a></li>
                <li class="markt-openstaand"><a href="/markten/{{ $data['slug'] }}/openstaand">Openstaand <span class="sr-only"></span></a></li>
                <li class="markt-kosten">Kosten <span class="sr-only"></span></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="aanmeldingen">
            <h1 class="page-header">Openstaand</h1>
            <input type="button" class="exportToExcel" value="export all">
            <div class="table-responsive" style="max-height: 70vh;margin-top: 50px;position:relative;">
                <table class="table table-striped standhouders-table" data-marktid="{{$data['koppelStandhoudersMarkten'][0]['markt_id']}}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th></th>
                        <th>credit</th>
                        <th>Gezien</th>
                        <th>Select</th>
                        <th>Betaald</th>
                        <th>Bedrijfsnaam</th>
                        <th>Naam</th>
                        <th>Telefoon</th>
                        <th>E-mail</th>
                        {{--<th>Website</th>--}}
                        {{--<th>Type</th>--}}
                        <th>Kraam</th>
                        <th>Grondplek</th>
                        <th>Bedrag</th>
                        {{--<th>Grote maten</th>--}}
                        {{--<th>Dames kleding</th>--}}
                        {{--<th>Heren kleding</th>--}}
                        {{--<th>Kinder kleding</th>--}}
                        {{--<th>Baby kleding</th>--}}
                        {{--<th>Fashion accessoires</th>--}}
                        {{--<th>Schoenen</th>--}}
                        {{--<th>Lifestyle</th>--}}
                        {{--<th>Woon accessoires</th>--}}
                        {{--<th>Kunst</th>--}}
                        {{--<th>Sieraden</th>--}}
                        {{--<th>Tassen</th>--}}
                        {{--<th>Brocante</th>--}}
                        {{--<th>Dieren spullen</th>--}}
                        {{--<th>Anders</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $x = 0;
                    // for ($x=0;$x < count($data['standhouders']); $x++)
                    // $data['standhouders'][1]['id'];
                    foreach($data['standhouders'] as $standhouder)
                    {
                        // dd($standhouder);
                        if (!$data['koppelStandhoudersMarkten'][$x]->seen)
                        {
                            echo '<tr class="unseen-row" data-id="'.$standhouder->id.'">';
                        }
                        else if ($data['koppelStandhoudersMarkten'][$x]->selected)
                        {
                            echo '<tr class="selected-row" data-id="'.$standhouder->id.'">';
                        }
                        else
                        {
                            echo '<tr data-id="'.$standhouder->id.'">';
                        }

                        echo '<td class="filterable-cell">' . $standhouder->id . '</td>';

                        echo '<td class="filterable-cell"><img class="delete-standhouder" data-id="' . $standhouder->id . '" style="width: 20px;" src="/assets/img/dashboard/icons/close-icon.png"></td>';
                        echo '<td class="filterable-cell"><img class="adjust" src="/assets/img/dashboard/icons/pencil.png"></td>';
                        echo '<td class="filterable-cell"><img class="credit-standhouder" data-id="' . $standhouder->id . '" style="width: 20px;" src="/assets/img/dashboard/icons/credit.png"></td>';

                        echo '<td class="filterable-cell"><input type="checkbox" class="seen" name="seen" value="seen"';
                        if($data['koppelStandhoudersMarkten'][$x]->seen){
                            echo 'checked=checked>' . '</td>';
                        } else {
                            echo '>' . '</td>';
                        }

                        echo '<td class="filterable-cell"><input type="checkbox" class="selected" name="selected" value="selected"';
                        if($data['koppelStandhoudersMarkten'][$x]->selected){
                            echo 'checked=checked>' . '</td>';
                        } else {
                            echo '>' . '</td>';
                        }

                        echo '<td class="filterable-cell"><input type="checkbox" class="betaald" name="betaald" value="betaald"';
                        if(isset($data['factuur'][$standhouder->id]) && $data['factuur'][$standhouder->id]->betaald){
                            echo 'checked=checked>' . '</td>';
                        } else {
                            echo '>' . '</td>';
                        }

                        echo '<td class="filterable-cell">' . $standhouder->Bedrijfsnaam . '</td>';
                        echo '<td class="filterable-cell">' . $standhouder->Voornaam . " " . $standhouder->Achternaam . '</td>';
                        echo '<td class="filterable-cell">' . $standhouder->Telefoon . '</td>';
                        echo '<td class="filterable-cell">' . $standhouder->Email . '</td>';
//                                echo '<td class="filterable-cell">' . $standhouder->Website . '</td>';
//
//                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->type . '</td>';
                        echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->kraam . '</td>';
                        echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->grondplek . '</td>';
                        echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->bedrag . '</td>';

                        echo '</tr>';
                        $x++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div><!-- end of tab aanmeldingen -->

        <div class="overlay"></div>

        <div class="standhouder-wijzig">
            <img src="/assets/img/dashboard/icons/close-icon.png" class="close-standhouder-wijzig">
            <form class="standhouderAdjustForm">
                <div class="form-title">Contact gegevens:</div>
                <label><span>id:</span><input type="text" name="id" value="" readonly></label>
                <br>
                <label><span>Bedrijfsnaam:</span><input type="text" name="Bedrijfsnaam" value=""></label>
                <br>
                <label><span>Voornaam:</span><input type="text" name="Voornaam" value=""></label>
                <br>
                <label><span>Achternaam:</span><input type="text" name="Achternaam" value=""></label>
                <br>
                <label><span>Email:</span><input type="text" name="Email" value=""></label>
                <br>
                <label><span>Telefoon:</span><input type="text" name="Telefoon" value=""></label>
                <br>
                <label><span>Website:</span><input type="text" name="Website" value=""></label>

                <br><br><br>

                <div class="form-title">Adres gegevens:</div>
                <label><span>Straat:</span><input type="text" name="Straat" value=""></label>
                <label><span>Postcode:</span><input type="text" name="Postcode" value=""></label>
                <br>
                <label><span>Huisnummer:</span><input type="text" name="Huisnummer" value=""></label>
                <label><span>Toevoeging:</span><input type="text" name="Toevoeging" value=""></label>
                <br>
                <label><span>Woonplaats:</span><input type="text" name="Woonplaats" value=""></label>

                <br><br><br>

                <input type="button" value="download factuur" class="download-single-invoice">
                <div class="form-title">Ander bedrag:</div>
                <label><span>Prijsafspraak:</span><input type="checkbox" name="afgesproken_prijs" value="1"></label>
                <label><span>Afgesproken prijs:</span><input type="text" name="afgesproken_bedrag" value=""></label>
                <br>
                <label><span>Factuur verstuurd:</span><input type="checkbox" name="factuur_verstuurd" value="1"></label>
                <label><span>Factuur datum:</span><input type="text" name="factuur_datum" value="" readonly></label>

                <br>
                <br>
                <br>

                <div class="form-title">Dagen:</div>
                <?php
                if ($data['markt']->aantal_dagen != '' && $data['markt']->aantal_dagen > 0) {
                    for ($x=0;$x<$data['markt']->aantal_dagen;$x++) {
                        echo '<label><span>dag'.($x+1).'</span><input type="checkbox" class="dagen" name="dag['.($x+1).']"><br>';
                    }
                }
                ?>

                <br><br><br>

                <input type="button" value="verstuur factuur" class="send-single-invoice">
                <div class="form-title">Markt Gegevens:</div>
                <label>
                    Food/non-food*:
                    <input type="radio" name="foodNonfood" value="food">food
                    <span style="display:inline-block;width:20px;"></span>
                    <input type="radio" name="foodNonfood" value="non-food">non food
                </label>
                <br>
                <label><span>Kramen:</span><input type="text" name="kraam" value=""></label>
                <label><span>Grondplekken:</span><input type="text" name="grondplek" value=""></label>
                <br>
                <label><span>Betaald:</span><input type="checkbox" name="betaald" value="1"></label>
                <label><span>Bedrag:</span><input type="text" name="bedrag" value="" readonly></label>

                <br>
                <br>
                <br>

                <label><input type="checkbox" name="anders" value="1"><span>Anders:</span></label>
                <label><input type="checkbox" name="baby-kleding" value="1"><span>Baby Kleding:</span></label>
                <br>
                <label><input type="checkbox" name="brocante" value="1"><span>Brocante:</span></label>
                <label><input type="checkbox" name="dames-kleding" value="1"><span>Dames Kleding</span></label>
                <br>
                <label><input type="checkbox" name="dierenspullen" value="1"><span>Dierenspullen:</span></label>
                <label><input type="checkbox" name="fashion-acceoires" value="1"><span>Fashion accesoires:</span></label>
                <br>
                <label><input type="checkbox" name="selected" value="1"><span>Geselecteerd:</span></label>
                <label><input type="checkbox" name="grote-maten" value="1"><span>Grote maten:</span></label>
                <br>
                <label><input type="checkbox" name="heren-kleding" value="1"><span>Heren kleding:</span></label>
                <label><input type="checkbox" name="kinder-kleding" value="1"><span>Kinder kleding:</span></label>
                <br>
                <label><input type="checkbox" name="kunst" value="1"><span>Kunst:</span></label>
                <label><input type="checkbox" name="lifestyle" value="1"><span>Lifestyle:</span></label>
                <br>
                <label><input type="checkbox" name="schoenen" value="1"><span>Schoenen</span></label>
                <label><input type="checkbox" name="sieraden" value="1"><span>Sieraden:</span></label>
                <br>
                <label><input type="checkbox" name="stroom" value="1"><span>Stroom</span></label>
                <label><input type="checkbox" name="tassen" value="1"><span>Tassen:</span></label>
                <br>
                <label><input type="checkbox" name="woon-accessoires" value="1"><span>Woon accessoires:</span></label>

                <br><br>


                <input type="button" class="cancel-standhouder-change" value="Annuleren" style="margin-right:20px;"> <input type="submit" value="Opslaan">
            </form>
        </div>

        <div class="popup popup-single-invoice">
            <div class="popup-title">Weet u het zeker?</div>

            <div class="popup-text">U staat op het punt om een standhouder een nieuwe of een mogelijk gewijzigde factuur te sturen.<br><span style="color:red;">Heeft u wel eerst de wijzigingen opgeslagen?</span></div>

            <input type="button" class="cancel-standhouder-send-invoice" value="Annuleren" style="margin-right:20px;"> <input type="button" class="send-single-invoice-definitief" value="Verzenden">
        </div>

    </div>

    <script>
        $(document).ready(function(){
            $(document).on('click', '.delete-standhouder', function(){
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

            $(document).on('click', '.credit-standhouder', function(){
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
