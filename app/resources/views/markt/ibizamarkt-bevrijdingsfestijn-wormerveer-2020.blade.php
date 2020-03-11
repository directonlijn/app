<?php

//dd($markt);
if ($markt) {
    $days = array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');
    $name = $markt->Naam;
    $name_lowered_without_spaces = str_replace(' ', '_', strtolower($name));
    $markt_id = $markt->id;
    $week_day_number = date('N', strtotime($markt['Datum_van']));
    $day = $days[$week_day_number - 1];
    setlocale(LC_ALL, 'nl_NL');
    $date = date('j', strtotime($markt['Datum_van'])).' '. strftime('%B', strtotime($markt['Datum_van']));
    $start_time = substr($markt["van-tijd"], 0, -3);
    $end_time = substr($markt["tot-tijd"], 0, -3);
    $kraam_prijs = round($markt->bedrag_kraam / 1.21, 2);
    $grondplek_prijs = round($markt->bedrag_grondplek / 1.21, 2);
    $markt_vol = false;

    //        dd($markt);
} else {
    dd('Deze markt is al geweest. Mocht u zich willen aanmelden voor volgende markten kunt u een e-mail sturen naar info@directevents.nl');
}
?>
<html>
<head>
    <meta charset="utf-8">

    <meta property="og:url" content="<?=$markt->Website;?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?=$name;?> - Direct Events">
    <meta property="og:description"
          content="<?=$name;?> is op <?=$day;?> <?=$date;?> van <?=$start_time;?> tot <?=$end_time;?> in de <?=$markt->Adres;?>, <?=$markt->Plaats;?>">
    <meta property="og:image" content="http://{{ $_SERVER['HTTP_HOST'] }}/{{ $slug }}/mail.jpg">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{{ csrf_token() }}}">

    <title>Direct Events - {{ $name }}</title>

    <base href="http://{{ $_SERVER['HTTP_HOST'] }}/{{ $slug }}/">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

    <link media="all" type="text/css" rel="stylesheet" href="style/style.css">

    <link rel="image_src" href="http://{{ $_SERVER['HTTP_HOST'] }}/{{ $slug }}/mail.jpg">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="d-none d-md-block col-md-2 rounds-left">
            <div class="yellow-round date">
                <?=$day;?>
                <div><?=$date;?></div>
            </div>
            <div class="yellow-round time">
                <?=$start_time;?><br>
                -<br>
                <?=$end_time;?>
            </div>
        </div>
        <div class="col-12 col-md-10">
            <img src="images/bord.png" class="bord">
        </div>
        <div class="col-12 d-block d-sm-none types">
            fashion | food | drinks | music | lifestyle
        </div>
    </div>
    <div class="row d-flex d-md-none">
        <div class="col-6">
            <div class="yellow-round date">
                <?=$day;?>
                <div><?=$date;?></div>
            </div>
        </div>
        <div class="col-6">
            <div class="yellow-round time">
                <?=$start_time;?><br>
                -<br>
                <?=$end_time;?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button data-src="#aanmeldformulier" class="aanmelden btn _aanmeldformulieropenen">aanmelden</button>
        </div>
    </div>
    <div class="row d-none d-sm-block">
        <div class="col-12 types">
            fashion | food | drinks | music | lifestyle
        </div>
        <div class="col-12">
            <img src="/images/logo.png" class="directevents_logo">
        </div>
    </div>
</div>

<div style="display: none;" class="modal" id="aanmeldformulier">
    <div class="modal-content">
        <?php if (isset($markt_vol) && $markt_vol) { ?>
        <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">Aanmelden</h4>
        </div>
        <div class="modal-body mx-3">
            Beste standhouder,<br><br>
            Helaas zitten wij helemaal vol en is aanmelden niet meer mogelijk. We hopen u te mogen verwelkomen op een van onze andere markten of als bezoeker op {{ $name }}.<br><br>
            Met vriendelijke groet,<br>
            Direct Events
        </div>
        <?php } else { ?>
        <form id="aanmeld-formulier">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Aanmelden</h4>
            </div>
            <div class="modal-body mx-3">
                <div class="container">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <input type="hidden" name="markt_id" value="{{ $markt_id }}" />
                    <input style="display: none;" type="radio" name="foodNonfood" value="non-food" checked="checked">

                    <section data-section="bedrijfsgegevens">
                        <h4>
                            Bedrijfs gegevens:
                        </h4>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="bedrijfsnaam">Bedrijfsnaam: *</label>
                                    <input type="text" class="form-control" id="bedrijfsnaam" name="bedrijfsnaam" placeholder="Uw bedrijfsnaam">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">Email: *</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Uw email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="voornaam">Voornaam: *</label>
                                    <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Uw voornaam">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="achternaam">Achternaam: *</label>
                                    <input type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Uw achternaam">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="telefoon">Telefoon: *</label>
                                    <input type="text" class="form-control" id="telefoon" name="telefoon" placeholder="Uw nummer">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="website">Website/facebook/etc: *</label>
                                    <input type="text" class="form-control" id="website" name="website" placeholder="Uw website">
                                </div>
                            </div>
                        </div>
                    </section>

                    <section data-section="adresgegevens">
                        <h4 class="mt-3">
                            Adres gegevens:
                        </h4>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="woonplaats">Woonplaats: *</label>
                                    <input type="text" class="form-control" id="woonplaats" name="woonplaats" placeholder="Uw woonplaats">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="postcode">Postcode: *</label>
                                    <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Uw postcode">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="straat">Straat: *</label>
                                    <input type="text" class="form-control" id="straat" name="straat" placeholder="Uw straat">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label for="huisnummer">Huisnummer: *</label>
                                    <input type="text" class="form-control" id="huisnummer" name="huisnummer" placeholder="Uw huisnummer">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label for="toevoeging">Toevoeging:</label>
                                    <input type="text" class="form-control" id="toevoeging" name="toevoeging" placeholder="Uw toevoeging">
                                </div>
                            </div>
                        </div>
                    </section>

                    <section data-section="marktgegevens">
                        <h4 class="mt-3">
                            Markt gegevens:
                        </h4>
                        {{--<p>--}}
                            {{--Stroom is inbegrepen!--}}
                        {{--</p>--}}
                        <input type="hidden" name="dag[0]" checked="checked">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="kramen">Aantal kramen (&euro;{{ $kraam_prijs }},- excl. BTW): *</label>
                                    <input type="text" class="form-control" id="kramen" name="kramen" placeholder="Aantal kramen">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="grondplek">Grondplek per strekkende meter (&euro;{{ $grondplek_prijs }} excl. BTW): *</label>
                                    <input type="text" class="form-control" id="grondplek" name="grondplekken" placeholder="Aantal meters">
                                </div>
                            </div>
                        </div>
                        <div class="row checkboxes mt-3">
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="grote-maten">Grote maten:</label>
                                    <input type="checkbox" class="form-control" name="producten[0]" id="grote-maten" value="grote-maten">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="dames-kleding">Dames kleding:</label>
                                    <input type="checkbox" class="form-control" name="producten[1]" id="dames-kleding" value="dames-kleding">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="heren-kleding">Herenkleding:</label>
                                    <input type="checkbox" class="form-control" name="producten[2]" id="heren-kleding" value="heren-kleding">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="kinder-kleding">Kinderkleding:</label>
                                    <input type="checkbox" class="form-control" name="producten[3]" id="kinder-kleding" value="kinder-kleding">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="baby-kleding">Babykleding:</label>
                                    <input type="checkbox" class="form-control" name="producten[4]" id="baby-kleding" value="baby-kleding">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="fashion-accesoires">Kledingaccesoires:</label>
                                    <input type="checkbox" class="form-control" name="producten[5]" id="fashion-accesoires" value="fashion-accesoires">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="schoenen">Schoenen:</label>
                                    <input type="checkbox" class="form-control" name="producten[6]" id="schoenen" value="schoenen">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="lifestyle">Lifestyle:</label>
                                    <input type="checkbox" class="form-control" name="producten[7]" id="lifestyle" value="lifestyle">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="woon-accessoires">Woonaccessoires:</label>
                                    <input type="checkbox" class="form-control" name="producten[8]" id="woon-accessoires" value="woon-accessoires">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="kunst">Kunst:</label>
                                    <input type="checkbox" class="form-control" name="producten[9]" id="kunst" value="kunst">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="sieraden">Sieraden:</label>
                                    <input type="checkbox" class="form-control" name="producten[10]" id="sieraden" value="sieraden">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="tassen">Tassen:</label>
                                    <input type="checkbox" class="form-control" name="producten[11]" id="tassen" value="tassen">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="brocante">Brocante:</label>
                                    <input type="checkbox" class="form-control" name="producten[12]" id="brocante" value="brocante">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="dierenspullen">Dierenspullen:</label>
                                    <input type="checkbox" class="form-control" name="producten[13]" id="dierenspullen" value="dierenspullen">
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group">
                                    <label for="anders">Anders:</label>
                                    <input type="checkbox" class="form-control" name="producten[14]" id="anders" value="anders">
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-default aanmelden">
                    <div class="shineAnimation"></div>
                    Aanmelden
                </button>
            </div>

        </form>
        <?php } ?>
    </div>
</div>

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>

<script>
    $(document).ready(function(){
        $("._aanmeldformulieropenen").fancybox({
            'onStart': function() { $("#aanmelden").removeClass('hidden'); },
            'onClosed': function() { $("#aanmelden").addClass('hidden'); }
        });

        required = ['bedrijfsnaam', 'voornaam', 'achternaam', 'straat', 'postcode', 'huisnummer', 'woonplaats', 'telefoon', 'email'];
        for(var x=0;x<required.length;x++){
            $(".test-form input[name="+required[x]+"]").on("focus keypress keydown paste", function(){

                var self = $(this);
                setTimeout(function(){
                    if(self.attr("name") == "huisnummer"){
                        if(self.val().length >= 1 ){
                            self.removeClass("error");
                        } else {
                            self.addClass("error");
                        }
                    } else {
                        if(self.val().length > 1 ){
                            self.removeClass("error");
                        } else {
                            self.addClass("error");
                        }
                    }
                }, 10);
            });
        }

        $("#aanmeld-formulier button").on("click", function(event){
            event.preventDefault();

            for(var x=0;x<required.length;x++){
                if ( $("#aanmeld-formulier input[name="+required[x]+"]").val().length < 1 )
                {
                    $("#aanmeld-formulier input[name="+required[x]+"]").addClass("error");
                }
                else
                {
                    $("#aanmeld-formulier input[name="+required[x]+"]").removeClass("error");
                }
            }

            $.ajax({
                type: "POST",
                url: "/aanmelding/markt",
                data: $("#aanmeld-formulier").serialize(),
                success: function(data) {
                    alert("U aanmelding is succesvol ontvangen. We hebben u zojuist een mail gestuurd. Mocht u deze niet ontvangen hebben graag een e-mail sturen naar info@directevents.nl");
                    $(".form-overlay").fadeOut(700);
                    $(".form-wrapper").fadeOut(700);
                },
                error: function (jXHR, textStatus, errorThrown) {
                    if(jXHR.status == 503)
                    {
                        alert("Nog niet alle velden zijn goed ingevuld.");
                    }
                    else if (jXHR.status == 404)
                    {
                        alert("We konden de opgegeven markt niet vinden. Wij zouden u willen vragen om een e-mail te sturen naar info@directevents.nl.");
                    }
                    else
                    {
                        alert("Er is iets fout gegaan. Onze excuses voor het ongemak. Wij zouden u willen vragen om een e-mail te sturen naar info@directevents.nl als dit probleem zich voor blijft doen.");
                    }
                }
            });
        });
    });
</script>
</body>
</html>
