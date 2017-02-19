@extends('baselayout')

@section('title') Markten @stop

@section('bottom')
    <!-- <script src="/assets/js/aanmelding-geselecteerd.js"></script> -->
    <script>
        $(document).ready(function(){
            $(".show-overzicht").on("click", function(){
                $(".overlay").show();
                $("body").addClass("loading");

                setTimeout(function(){
                    $(".markt-tab").hide();
                    $(".overzicht").show();
                    $(".overlay").hide();
                    $("body").removeClass("loading");
                }, 100);
            });
            $(".show-markt").on("click", function(){
                $(".overlay").show();
                $("body").addClass("loading");
                var $data = { _token: $(".token").text(), markt_id: $(this).attr("data-marktid")};
                $.post({
                    type: "POST",
                    url: "/markten/beheer/getMarkt",
                    data: $data
                })
                .done(function(data){
                    var dataParsed = JSON.parse(data);
                    // alert(JSON.parse(data).message);
                    if (dataParsed.code == 200)
                    {
                        console.log(data);
                        $marktData = dataParsed.data;
                        console.log($marktData);
                        $(".markt-titel").text($marktData["Naam"]);
                        for (var key in $marktData)
                        {
                            if ($marktData.hasOwnProperty(key)) {
                                //  console.log("Key is " + key + ", value is " + $marktData[key]);
                                $(".markt-form input[name="+key+"]").val($marktData[key]);
                            }
                        }
                        $(".overzicht").hide();
                        $(".markt-tab").show();
                        $(".overlay").hide();
                        $("body").removeClass("loading");
                    }
                    else if (dataParsed.code == 400)
                    {
                        alert(dataParsed.message);
                        $(".markt-tab").hide();
                        $(".overzicht").show();
                        $(".overlay").hide();
                        $("body").removeClass("loading");
                    }


                })
                .fail(function(data){
                    // alert(JSON.parse(data).message);
                    alert("Er is iets fout gegaan. Mocht dit probleem zich voor blijven doen neem dan contact op met uw systeem beheerder.");
                    $(".markt-tab").hide();
                    $(".overzicht").show();
                    $(".overlay").hide();
                    $("body").removeClass("loading");
                });
            });
        })
    </script>
@stop

@section('content')
    <?php
        // dd($markten);
        // dd($data['standhouders'][1]->id);
        // dd($data['koppelStandhoudersMarkten'][0]['markt_id']);
    ?>
    <div class="token">{{ csrf_token() }}</div>
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="position: absolute;">
            <ul class="nav nav-sidebar">
                <li class="markt-overview"><a class="show-overzicht">Overzicht <span class="sr-only"></span></a></li>
                @foreach ($markten as $markt)
                    <li class="markt"><a class="show-markt" data-marktid="{{ $markt['id'] }}">{{ $markt['Naam'] }} <span class="sr-only"></span></a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 overzicht" data-tab="overzicht">

        </div><!-- end of tab overzicht -->

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 markt-tab" data-tab="markt" style="display: none;">
            <h1 class="page-header markt-titel"></h1>
            <form class="markt-form">
                <div class="form-title">Markt gegevens:</div>
                <label><span>id:</span><input type="text" name="id" value="" readonly></label>
                <br>
                <label><span>Markt naam:</span><input type="text" name="naam" value=""></label>
                <label><span>Datum:</span><input type="text" name="Datum" value=""></label>
                <br>
                <label><span>Bedrag Kraam:</span><input type="text" name="bedrag_kraam" value=""></label>
                <label><span>Bedrag Grondplek:</span><input type="text" name="bedrag_grondplek" value=""></label>
                <br>
                <label><span>Vanaf:</span><input type="text" name="van-tijd" value=""></label>
                <label><span>tot:</span><input type="text" name="tot-tijd" value=""></label>
                <br>
                <label><span>Website:</span><input type="text" name="Website" value=""></label>

                <br>
                <br>
                <br>

                <div class="form-title">Markt adres gegevens:</div>
                <label><span>Straat:</span><input type="text" name="Adres" value=""></label>
                <label><span>Postcode:</span><input type="text" name="Postcode" value=""></label>
                <br>
                <label><span>Huisnummer:</span><input type="text" name="Huisnummer" value=""></label>
                <label><span>Toevoeging:</span><input type="text" name="Toevoeging" value=""></label>
                <br>
                <label><span>Plaats:</span><input type="text" name="Plaats" value=""></label>
                <label><span>Land:</span><input type="text" name="Land" value=""></label>

                <br>
                <br>
                <br>

                <div class="form-title">Extra gegevens:</div>
                <span>Welcome Email Template Naam:</span><input type="text" name="welcome-mail-template" value="">
                <br>
                <span>Algemene Voorwaarden Naam:</span><input type="text" name="algemene-voorwaarden" value="">


            </form>
        </div><!-- end of tab markt -->

        <div class="overlay"></div>

        <div id="loader-wrapper">
			<div id="loader"></div>
		</div>

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
