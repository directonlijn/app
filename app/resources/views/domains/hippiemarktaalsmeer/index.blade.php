<?php

    $name = 'Hippiemarkt Aalsmeer';
    $markt_id = 10;
?>

<?php
header("Location: http://hippiemarktamsterdamxl.nl");
die();
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{{ csrf_token() }}}">

        <title>Direct Events - {{ $name }}</title>

        <base href="http://{{ $_SERVER['HTTP_HOST'] }}/hippiemarktaalsmeer/">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.1/jquery.fancybox.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

        <link media="all" type="text/css" rel="stylesheet" href="style/style.css">

        <meta property="og:url"                content="http://www.hippiemarktaalsmeer.nl" />
        <meta property="og:type"               content="website" />
        <meta property="og:title"              content="Hippiemarkt Aalsmeer - Direct Events" />
        <meta property="og:description"        content="De Hippiemarkt Aalsmeer is op vrijdag 27 juli van 16:00 tot 23:00 op het surfeiland te Aalsmeer" />
        <meta property="og:image"              content="http://app.directevents.nl/assets/img/hippiemarkt-aalsmeer/mail-header.png" />

        <link rel="image_src" href="http://app.directevents.nl/assets/img/hippiemarkt-aalsmeer/mail-header.png">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="hidden-xs hidden-sm col-md-2 rounds-left">
                    <div class="yellow-round date">
                        Vrijdag
                        <div>27 Juli</div>
                    </div>
                    <div class="yellow-round time">
                        16:00<br>
                        -<br>
                        23:00
                    </div>
                </div>
                <div class="col-xs-12 col-md-10">
                    <img src="images/bord.png" class="bord">
                </div>
                <div class="col-xs-12 visible-xs types">
                    food | music | fashion | lifestyle | kermis
                </div>
            </div>
            <div class="row visible-xs visible-sm">
                <div class="col-xs-6">
                    <div class="yellow-round date">
                        Vrijdag
                        <div>27 Juli</div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="yellow-round time">
                        16:00<br>
                        -<br>
                        23:00
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <a href="#aanmelden" class="aanmelden btn">aanmelden</a>
                </div>
            </div>
            <div class="row hidden-xs">
                <div class="col-sm-12 types">
                    food | music | fashion | lifestyle | kermis
                </div>
                <div class="col-sm-12">
                    <img src="/images/logo.png" class="directevents_logo">
                </div>
            </div>
        </div>

        <div id="aanmelden">
            <div class="form-wrapper">
    			<div class="close"></div>

    			<div class="form-style-10">
    				<h1>Aanmelden<br>{{ $name }}<span>Hier kunt u zich aanmelden als standhouder voor de {{ $name }}.</span></h1>
    				<form class="test-form" action="test.php" method="post">
    					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    	                <input type="hidden" name="markt_id" value="{{ $markt_id }}" />
    				    <div class="section"><span>1</span>Bedrijfs- &amp; <h3 class="mobile-only"><br></h3>Persoons-gegevens</div>
    				    <div class="inner-wrap">
    				        <label>Bedrijfsnaam*: <input type="text" name="bedrijfsnaam" required/></label>
    				        <label>Voornaam*: <input type="text" name="voornaam" required/></label>
    				        <label>Achternaam*: <input type="text" name="achternaam" required/></label>
    				        <label>Telefoon*: <input type="tel" name="telefoon" maxlength="10" required/></label>
    				        <label>E-mail*: <input type="email" name="email" required/></label>
    				        <label>Website: <input type="text" name="website" /></label>
    					</div>

    					<div class="section"><span>2</span>Adresgegevens</div>
    				    <div class="inner-wrap">
    				        <label>Straat*: <input type="text" name="straat" required/></label>
    				        <label>Huisnummer*: <input type="text" name="huisnummer" required/></label>
    				        <label>Toevoeging: <input type="text" name="toevoeging" /></label>
    				        <label>Postcode*: <input type="text" name="postcode" maxlength="6" required/></label>
    				        <label>Woonplaats*: <input type="text" name="woonplaats" required/></label>
    				    </div>

    					<div class="section"><span>3</span>Markt gegevens</div>
    				    <div class="inner-wrap">
    				        <?php
    						/*<label>
    							Food/non-food*:<br>
    							<input type="radio" name="foodNonfood" value="food">food (standaardtarief: €242,- incl. BTW)<br>

                                <input type="radio" name="foodNonfood" value="non-food" checked="checked">non food
    						</label>*/
    						?>
    						<input style="display: none;" type="radio" name="foodNonfood" value="non-food" checked="checked">
                            <input type="hidden" name="dag[0]" checked="checked">
    						<div class="form-label hidden">
    							Dagen*:<br>
    							<label><input type="checkbox" class="dagen" name="dagen[0]" value="dag1">Vrijdag 25 Mei - 10:00 tot 17:00</label>
    							<label><input type="checkbox" class="dagen" name="dagen[1]" value="dag2">Zaterdag 26 Mei - 10:00 tot 17:00</label>
    							<label><input type="checkbox" class="dagen" name="dagen[2]" value="dag3">Zondag 27 Mei - 10:00 tot 17:00</label>
    							<br>
    							Indien u voor alle drie de dagen kiest word er een prijs gerekend van &euro;55,- incl. BTW per dag voor een kraam of &euro;12,50 incl. BTW per dag per meter voor een grondplek
    						</div>
    				        <label>Aantal kramen (4 meter, &euro;120,- incl. BTW): <input type="number" name="kramen" value="0"/></label>
    				        <label>Aantal grondplekken (per meter, &euro;25,- incl. BTW per dag): <input type="number" name="grondplekken" value="0"/></label>
    				        <div class="form-label">
    							Producten*:<br>
    							<label><input type="checkbox" class="producten" name="producten[0]" value="grote-maten">Grote maten kleding</label>
                                <label><input type="checkbox" class="producten" name="producten[1]" value="dames-kleding">Dameskleding</label>
                                <label><input type="checkbox" class="producten" name="producten[2]" value="heren-kleding">Herenkleding</label>
                                <label><input type="checkbox" class="producten" name="producten[3]" value="kinder-kleding">Kinderkleding</label>
                                <label><input type="checkbox" class="producten" name="producten[4]" value="baby-kleding">Babykleding</label>
                                <label><input type="checkbox" class="producten" name="producten[5]" value="fashion-accesoires">Kledingaccesoires</label>
                                <label><input type="checkbox" class="producten" name="producten[6]" value="schoenen">Schoenen</label>
                                <label><input type="checkbox" class="producten" name="producten[7]" value="lifestyle">Lifestyle</label>
                                <label><input type="checkbox" class="producten" name="producten[8]" value="woon-accessoires">Woonaccessoires</label>
                                <label><input type="checkbox" class="producten" name="producten[9]" value="kunst">Kunst</label>
                                <label><input type="checkbox" class="producten" name="producten[10]" value="sieraden">Sieraden</label>
                                <label><input type="checkbox" class="producten" name="producten[11]" value="tassen">Tassen</label>
                                <label><input type="checkbox" class="producten" name="producten[12]" value="brocante">Brocante</label>
                                <label><input type="checkbox" class="producten" name="producten[13]" value="dierenspullen">Dierenspullen</label>
                                <label><input type="checkbox" class="producten" name="producten[14]" value="anders">Anders</label>
    						</div>
    				    </div>
    				    <div class="button-section">
    				     	<input type="button" name="Aanmelden" value="aanmelden"/>
    				    </div>
    				</form>
    			</div>
            </div>
        </div>

        <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.1/jquery.fancybox.min.js"></script>

        <script>
            $(document).ready(function(){
                $(".aanmelden").fancybox({
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

                $(".test-form input[type=button]").on("click", function(event){
            	    event.preventDefault();

                    for(var x=0;x<required.length;x++){
                        if ( $(".test-form input[name="+required[x]+"]").val().length < 1 )
                            {
                            $(".test-form input[name="+required[x]+"]").addClass("error");
                            }
                        else
                        {
                            $(".test-form input[name="+required[x]+"]").removeClass("error");
                        }
                    }

                    $.ajax({
                        type: "POST",
                        url: "/aanmelding/markt",
                        data: $(".test-form").serialize(),
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
