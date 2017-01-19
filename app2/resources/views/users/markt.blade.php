@extends('baselayout')

@section('title') Markten @stop

@section('bottom')
    <script>
        $(document).ready(function(){

            function getJsonData(type, url, $data)
            {
                var returnValue = '';
                $.post({
                    type: type,
                    url: url,
                    data: $data
                })
                .done(function(data){
                    returnValue = data;
                    console.log(data);
                    // $(".standhouders-table tbody").empty();
                    // $standhouders = data.standhouders;
                    // $html = '';
                    // for(var i = 0;i < $standhouders.length; i++)
                    // {
                    //     $html += "<tr>";
                    //     $html += "<td>"+ $standhouders[i].id +"</td>";
                    //     $html += "<td>"+ $standhouders[i].Bedrijfsnaam +"</td>";
                    //     $html += "<td>"+ $standhouders[i].Voornaam + " " + $standhouders[i].Achternaam +"</td>";
                    //     $html += "<td>"+ $standhouders[i].Telefoon +"</td>";
                    //     $html += "<td>"+ $standhouders[i].Email +"</td>";
                    //     $html += "<td>"+ $standhouders[i].Website +"</td>";
                    //     $html += "</tr>";
                    // }
                    //
                    // $(".standhouders-table tbody").append($html);
                })
                .fail(function(data){
                console.log(data);
                    returnValue = false;
                });

                return returnValue;
            }

            $(".markt-item").on("click", function(){
                var $id = $(this).find("a").data("id");
                var $data = { _token: "{{ csrf_token() }}", id: $id };

                data = getJsonData("POST", "getStandhoudersForMarkt", $data);
                $(".standhouders-table tbody").empty();
                console.log(data);
                $standhouders = data.standhouders;
                $html = '';
                for(var i = 0;i < $standhouders.length; i++)
                {
                    $html += "<tr>";
                    $html += "<td>"+ $standhouders[i].id +"</td>";
                    $html += "<td>"+ $standhouders[i].Bedrijfsnaam +"</td>";
                    $html += "<td>"+ $standhouders[i].Voornaam + " " + $standhouders[i].Achternaam +"</td>";
                    $html += "<td>"+ $standhouders[i].Telefoon +"</td>";
                    $html += "<td>"+ $standhouders[i].Email +"</td>";
                    $html += "<td>"+ $standhouders[i].Website +"</td>";
                    $html += "</tr>";
                }

                $(".standhouders-table tbody").append($html);
            });
        });
    </script>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="position: absolute;">
            <ul class="nav nav-sidebar">
                <li class="markt-overview active"><a href="/markten/{{ $data['slug'] }}">Overzicht <span class="sr-only">(current)</span></a></li>
                <li class="markt-aanmeldingen"><a href="/markten/{{ $data['slug'] }}/aanmeldingen">Aanmeldingen <span class="sr-only"></span></a></li>
                <li class="markt-geselecteerd">Geselecteerd <span class="sr-only"></span></li>
                <li class="markt-betaald">Betaald <span class="sr-only"></span></li>
                <li class="markt-openstaand">Openstaand <span class="sr-only"></span></li>
                <li class="markt-kosten">Kosten <span class="sr-only"></span></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="overzicht">
            <h1 class="page-header">Overzicht</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <div style="max-width: 100%;height: auto;">{{ $data['aantal_standhouders'] }}</div>
                    <h4>Aantal aanmeldingen</h4>

                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Betaald/openstaand</h4>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Kosten/inkomsten</h4>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Aantal vrije plekken van totaal</h4>
                    <span class="text-muted">{{ $data['markt']->aantalGeselecteerd }} van {{ $data['markt']->aantalPlekken }}</span>
                </div>
            </div>

            <!-- <h2 class="sub-header">Standhouders</h2>
            <div class="table-responsive">
                <table class="table table-striped standhouders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div> -->
        </div><!-- end of tab overzicht -->

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="aanmeldingen">
            <h1 class="page-header">Aanmeldingen</h1>
            <div class="table-responsive">
                <table class="table table-striped standhouders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        	foreach($data['standhouders'] as $standhouder)
                            {
                                // dd($standhouder);
                                echo '<tr>';
                                echo '<td>' . $standhouder->id . '</td>';
                                echo '<td>' . $standhouder->Bedrijfsnaam . '</td>';
                                echo '<td>' . $standhouder->Voornaam . " " . $standhouder->Achternaam . '</td>';
                                echo '<td>' . $standhouder->Telefoon . '</td>';
                                echo '<td>' . $standhouder->Email . '</td>';
                                echo '<td>' . $standhouder->Website . '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div><!-- end of tab aanmeldingen -->

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="geselecteerd">
            <h1 class="page-header">Geselecteerd</h1>
            <div class="table-responsive">
                <table class="table table-striped standhouders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div><!-- end of tab geselecteerd -->

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="betaald">
            <h1 class="page-header">Betaald</h1>
            <div class="table-responsive">
                <table class="table table-striped standhouders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div><!-- end of tab betaald -->

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="openstaand">
            <h1 class="page-header">Openstaand</h1>
            <div class="table-responsive">
                <table class="table table-striped standhouders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div><!-- end of tab openstaand -->

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="kosten">
            <h1 class="page-header">Kosten</h1>
            <div class="table-responsive">
                <table class="table table-striped standhouders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div><!-- end of tab kosten -->
    </div>
@stop
