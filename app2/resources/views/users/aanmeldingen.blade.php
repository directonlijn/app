@extends('baselayout')

@section('title') Markten @stop

@section('bottom')
    <script>
        $(document).ready(function(){

            $(".exportToExcel").on("click", function(){
                // markten/{slug}/export
                // $.ajax({
                //     url: "/markten/Hippiemarkt Amsterdam XL/export",
                //     success: function(result){
                //         alert("succes");
                //     },
                //     fail: function(){
                //         alert("fail");
                //     }
                // });
                window.open("/markten/Hippiemarkt Amsterdam XL/export", '_blank');
            });

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
    <?php
        // dd($data);
    ?>
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="position: absolute;">
            <ul class="nav nav-sidebar">
                <li class="markt-overview"><a href="/markten/{{ $data['slug'] }}">Overzicht <span class="sr-only"></span></a></li>
                <li class="markt-aanmeldingen active"><a href="/markten/{{ $data['slug'] }}/aanmeldingen">Aanmeldingen <span class="sr-only">(current)</span></a></li>
                <li class="markt-geselecteerd">Geselecteerd <span class="sr-only"></span></li>
                <li class="markt-betaald">Betaald <span class="sr-only"></span></li>
                <li class="markt-openstaand">Openstaand <span class="sr-only"></span></li>
                <li class="markt-kosten">Kosten <span class="sr-only"></span></li>
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="aanmeldingen">
            <h1 class="page-header">Aanmeldingen</h1>
            <input type="button" class="exportToExcel" value="export all">
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
                            <th>Type</th>
                            <th>Kraam</th>
                            <th>Grondplek</th>
                            <th>Bedrag</th>
                            <th>Betaald</th>
                            <th>Grote maten</th>
                            <th>Dames kleding</th>
                            <th>Heren kleding</th>
                            <th>Kinder kleding</th>
                            <th>Baby kleding</th>
                            <th>Fashion accessoires</th>
                            <th>Schoenen</th>
                            <th>Lifestyle</th>
                            <th>Woon accessoires</th>
                            <th>Kunst</th>
                            <th>Sieraden</th>
                            <th>Tassen</th>
                            <th>Brocante</th>
                            <th>Dieren spullen</th>
                            <th>Anders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $x = 0;
                            // for ($x=0;$x < count($data['standhouders']); $x++)
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

                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->type . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->kraam . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->grondplek . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->bedrag . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->betaald . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->{"grote-maten"} . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->{"dames-kleding"} . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->{"heren-kleding"} . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->{"kinder-kleding"} . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->{"baby-kleding"} . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->{"fashion-accessoires"} . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->schoenen . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->lifestyle . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->{"woon-accessoires"} . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->kunst . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->sieraden . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->tassen . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->brocante . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->dierenspullen . '</td>';
                                echo '<td>' . $data['koppelStandhoudersMarkten'][$x]->anders . '</td>';
                                echo '</tr>';
                                $x++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div><!-- end of tab aanmeldingen -->

    </div>
@stop
