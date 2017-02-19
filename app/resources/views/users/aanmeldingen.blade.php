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
                window.open("/markten/Hippiemarkt Amsterdam XL/export/aanmeldingen", '_blank');
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
                    return data;
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
                console.log(returnValue);
                    returnValue = false;
                });

                console.log(returnValue);

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

            $(".standhouders-table tr.unseen-row").on("click", function(){
                $(this).removeClass("unseen-row");

                var $standhouder_id = $(this).data("id");
                var $markt_id = $(this).closest("table").data("marktid");

                setStandhouderSeen($markt_id, $standhouder_id, 1)
            });

            $(".standhouders-table tr input.seen").on("click", function(){
                var self = $(this);

                setTimeout(function(){
                    var $markt_id = self.closest("table").data("marktid");
                    var id = self.closest("tr").data("id");
                    if(self.prop("checked")){
                        setStandhouderSeen($markt_id, $standhouder_id, 1)
                        self.closest("tr").removeClass("unseen-row");
                    } else {
                        setStandhouderSeen($markt_id, $standhouder_id, 0)
                        self.closest("tr").addClass("unseen-row");
                    }
                }, 20);
            });

            function setStandhouderSeen($markt_id, $standhouder_id, $value)
            {
                var $data = { _token: "{{ csrf_token() }}", markt_id: $id, standhouder_id: $standhouder_id, value: $value };

                data = getJsonData("POST", "/markt/setStandhouderSeen", $data);
            }

            $(".adjust").on("click", function(){
                var $markt_id = $(this).closest("table").data("marktid");
                var $standhouder_id = $(this).closest("tr").data("id");
                var $data = { _token: "{{ csrf_token() }}", markt_id: $markt_id ,standhouder_id: $standhouder_id};

                $.post({
                    type: "POST",
                    url: "/markt/getStandhouder",
                    data: $data
                })
                .done(function(data){
                    // contact gegevens
                    $(".standhouder-wijzig input[name=id]").val(data.standhouder.id);
                    $(".standhouder-wijzig input[name=Bedrijfsnaam]").val(data.standhouder.Bedrijfsnaam);
                    $(".standhouder-wijzig input[name=Voornaam]").val(data.standhouder.Voornaam);
                    $(".standhouder-wijzig input[name=Achternaam]").val(data.standhouder.Achternaam);
                    $(".standhouder-wijzig input[name=Email]").val(data.standhouder.Email);
                    $(".standhouder-wijzig input[name=Telefoon]").val(data.standhouder.Telefoon);
                    $(".standhouder-wijzig input[name=Website]").val(data.standhouder.Website);

                    // adres gegevens
                    $(".standhouder-wijzig input[name=Straat]").val(data.standhouder.Straat);
                    $(".standhouder-wijzig input[name=Postcode]").val(data.standhouder.Postcode);
                    $(".standhouder-wijzig input[name=Huisnummer]").val(data.standhouder.Huisnummer);
                    $(".standhouder-wijzig input[name=Toevoeging]").val(data.standhouder.Toevoeging);
                    $(".standhouder-wijzig input[name=Woonplaats]").val(data.standhouder.Woonplaats);

                    $(".standhouder-wijzig input[name=afgesproken_prijs]").prop("checked", ((data.standhouderMarktData.afgesproken_prijs) ? true : false));
                    $(".standhouder-wijzig input[name=afgesproken_bedrag]").val(data.standhouderMarktData.afgesproken_bedrag);

                    // Markt gegevens
                    $(".standhouder-wijzig input[name=foodNonfood]").each(function(){
                        if ($(this).val() == data.standhouderMarktData.type) $(this).prop("checked", true);
                    });
                    $(".standhouder-wijzig input[name=kraam]").val(data.standhouderMarktData.kraam);
                    $(".standhouder-wijzig input[name=grondplek]").val(data.standhouderMarktData.grondplek);
                    $(".standhouder-wijzig input[name=bedrag]").val(data.standhouderMarktData.bedrag);
                    $(".standhouder-wijzig input[name=betaald]").prop("checked", ((data.standhouderMarktData.betaald) ? true : false));


                    $(".standhouder-wijzig input[name=anders]").prop("checked", ((data.standhouderMarktData.anders) ? true : false));
                    $(".standhouder-wijzig input[name=baby-kleding]").prop("checked", ((data.standhouderMarktData["baby-kleding"]) ? true : false));
                    $(".standhouder-wijzig input[name=brocante]").prop("checked", ((data.standhouderMarktData.brocante) ? true : false));
                    $(".standhouder-wijzig input[name=dames-kleding]").prop("checked", ((data.standhouderMarktData["dames-kleding"]) ? true : false));
                    $(".standhouder-wijzig input[name=dierenspullen]").prop("checked", ((data.standhouderMarktData.dierenspullen) ? true : false));
                    $(".standhouder-wijzig input[name=fashion-accessoires]").prop("checked", ((data.standhouderMarktData["fashion-accessoires"]) ? true : false));
                    $(".standhouder-wijzig input[name=selected]").prop("checked", ((data.standhouderMarktData.selected) ? true : false));
                    $(".standhouder-wijzig input[name=grote-maten]").prop("checked", ((data.standhouderMarktData["grote-maten"]) ? true : false));
                    $(".standhouder-wijzig input[name=heren-kleding]").prop("checked", ((data.standhouderMarktData["heren-kleding"]) ? true : false));
                    $(".standhouder-wijzig input[name=kinder-kleding]").prop("checked", ((data.standhouderMarktData["kinder-kleding"]) ? true : false));
                    $(".standhouder-wijzig input[name=kunst]").prop("checked", ((data.standhouderMarktData.kunst) ? true : false));
                    $(".standhouder-wijzig input[name=lifestyle]").prop("checked", ((data.standhouderMarktData.lifestyle) ? true : false));
                    $(".standhouder-wijzig input[name=schoenen]").prop("checked", ((data.standhouderMarktData.schoenen) ? true : false));
                    $(".standhouder-wijzig input[name=sieraden]").prop("checked", ((data.standhouderMarktData.sieraden) ? true : false));
                    $(".standhouder-wijzig input[name=stroom]").prop("checked", ((data.standhouderMarktData.stroom) ? true : false));
                    $(".standhouder-wijzig input[name=tassen]").prop("checked", ((data.standhouderMarktData.tassen) ? true : false));
                    $(".standhouder-wijzig input[name=woon-accessoires]").prop("checked", ((data.standhouderMarktData["woon-accessoires"]) ? true : false));

                    // markt gegevens
                    // if(data.standhou)

                    $(".overlay").show();
                    $(".standhouder-wijzig").show();
                })
                .fail(function(data){
                    alert("failed to get data");
                });
            });

            $(".standhouderAdjustForm").on("submit", function(e){
                e.preventDefault();
                e.stopPropagation();

                var self = $(this);

                var postData = {markt_id: $(".standhouders-table").attr("data-marktid"), _token: "{{ csrf_token() }}"};
                $(".standhouderAdjustForm input[type=checkbox]").each(function(){
                    if (!$(this).prop("checked")) {
                        postData[$(this).attr("name")] = 0;
                    }
                });

                $.post({
                    type: "POST",
                    url: "/markt/changeStandhouder",
                    data: (self.serialize()+"&"+$.param(postData))
                })
                .done(function(data){
                    // var dataParsed = JSON.parse(data);
                    alert(JSON.parse(data).message);
                })
                .fail(function(data){
                    alert(JSON.parse(data).message);
                });
            });

            $(".close-standhouder-wijzig, .cancel-standhouder-change").on("click", function(){
                $(".overlay").hide();
                $(".standhouder-wijzig").hide();
            });

            $(".standhouders-table tr input.selected").on("click", function(){
                var self = $(this);

                setTimeout(function(){
                    var $markt_id = self.closest("table").data("marktid");
                    var $standhouder_id = self.closest("tr").data("id");
                    if(self.prop("checked")){
                        setStandhouderSelected($markt_id, $standhouder_id, 1)
                        self.closest("tr").addClass("selected-row");
                    } else {
                        setStandhouderSelected($markt_id, $standhouder_id, 0)
                        self.closest("tr").removeClass("selected-row");
                    }
                }, 20);
            });

            function setStandhouderSelected($markt_id, $standhouder_id, $value)
            {
                var $data = { _token: "{{ csrf_token() }}", markt_id: $markt_id, standhouder_id: $standhouder_id, value: $value };

                data = getJsonData("POST", "/markt/setStandhouderSelected", $data);
            }

            $(".standhouders-table tr.unseen-row").on("click", function(){
                $(this).removeClass("unseen-row");

                var $standhouder_id = $(this).data("id");
                var $markt_id = $(this).closest("table").data("marktid");

                setStandhouderSeen($markt_id, $standhouder_id, 1)
            });

            $(".standhouders-table tr input.seen").on("click", function(){
                var self = $(this);

                setTimeout(function(){
                    var $markt_id = self.closest("table").data("marktid");
                    var id = self.closest("tr").data("id");
                    if(self.prop("checked")){
                        setStandhouderSeen($markt_id, $standhouder_id, 1)
                        self.closest("tr").removeClass("unseen-row");
                    } else {
                        setStandhouderSeen($markt_id, $standhouder_id, 0)
                        self.closest("tr").addClass("unseen-row");
                    }
                }, 20);
            });

            function setStandhouderSeen($markt_id, $standhouder_id, $value)
            {
                var $data = { _token: "{{ csrf_token() }}", markt_id: $markt_id, standhouder_id: $standhouder_id, value: $value };

                data = getJsonData("POST", "/markt/setStandhouderSeen", $data);
            }

            $(".standhouders-table tr input.betaald").on("click", function(e){

                var self = $(this);

                setTimeout(function(){
                    var standhouder_id = self.closest("tr").data("id");
                    var markt_id = $(".standhouders-table").attr("data-marktid");
                    var $data = { _token: "{{ csrf_token() }}", markt_id: markt_id, standhouder_id: standhouder_id, value: ((self.prop("checked")) ? 1 : 0 ) };

                    $.post({
                        type: "POST",
                        url: "/markt/setStandhouderBetaald",
                        data: $data
                    })
                    .done(function(data){
                        // self.prop("checked", !self.prop("checked"));
                        alert(JSON.parse(data).message);
                    })
                    .fail(function(data){
                        e.stopPropagation();
                        alert(JSON.parse(data).message);
                    });
                }, 20);
            });

            function setStandhouderBetaald($markt_id, $standhouder_id, $value)
            {
                var $data = { _token: "{{ csrf_token() }}", markt_id: $markt_id, standhouder_id: $standhouder_id, value: $value };

                data = getJsonData("POST", "/markt/setStandhouderBetaald", $data);
            }

            $(".send-single-invoice").on("click", function(){
                $(".standhouder-wijzig").hide();
                $(".popup-single-invoice").show();
            });

            $(".cancel-standhouder-send-invoice").on("click", function(){
                $(".popup-single-invoice").hide();
                $(".standhouder-wijzig").show();
            });

            $(".send-single-invoice-definitief").on("click", function(){
                var standhouder_id = $(".standhouder-wijzig").find("input[name=id]").val();
                var markt_id = $(".standhouders-table").attr("data-marktid");
                var $data = { _token: "{{ csrf_token() }}", markt_id: markt_id, standhouder_id: standhouder_id };

                $.post({
                    type: "POST",
                    url: "/markt/sendInvoiceForStandhouder",
                    data: $data
                })
                .done(function(data){
                    // self.prop("checked", !self.prop("checked"));
                    alert(JSON.parse(data).message);
                    $(".popup-single-invoice").hide();
                    $(".standhouder-wijzig").show();
                })
                .fail(function(data){
                    e.stopPropagation();
                    alert(JSON.parse(data).message);
                });
            });
        });
    </script>
@stop

@section('content')
    <?php
        // dd($data);
        // dd($data['standhouders'][1]->id);
        // dd($data['koppelStandhoudersMarkten'][0]['markt_id']);
    ?>
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

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" data-tab="aanmeldingen">
            <h1 class="page-header">Aanmeldingen</h1>
            <input type="button" class="exportToExcel" value="export all">
            <div class="table-responsive" style="max-height: 70vh;margin-top: 50px;">
                <table class="table table-striped standhouders-table" data-marktid="{{$data['koppelStandhoudersMarkten'][0]['markt_id']}}">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Wijzig</th>
                            <th>Gezien</th>
                            <th>Geselecteerd</th>
                            <th>Betaald</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                            <th>Type</th>
                            <th>Kraam</th>
                            <th>Grondplek</th>
                            <th>Bedrag</th>
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

                                echo '<td class="filterable-cell"><img class="adjust" src="/assets/img/dashboard/icons/pencil.png"></td>';

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
                                echo '<td class="filterable-cell">' . $standhouder->Website . '</td>';

                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->type . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->kraam . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->grondplek . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->bedrag . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->{"grote-maten"} . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->{"dames-kleding"} . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->{"heren-kleding"} . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->{"kinder-kleding"} . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->{"baby-kleding"} . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->{"fashion-accessoires"} . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->schoenen . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->lifestyle . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->{"woon-accessoires"} . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->kunst . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->sieraden . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->tassen . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->brocante . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->dierenspullen . '</td>';
                                echo '<td class="filterable-cell">' . $data['koppelStandhoudersMarkten'][$x]->anders . '</td>';

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

                <div class="form-title">Ander bedrag:</div>
                <label><span>Prijsafspraak:</span><input type="checkbox" name="afgesproken_prijs" value="1"></label>
                <label><span>Afgesproken prijs:</span><input type="text" name="afgesproken_bedrag" value=""></label>

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
@stop
