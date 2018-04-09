<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="kIJdPKOJ057C5Qn1knw7LR4EfcKFvHVI2P9ImnEQ">

        <title>Direct Events - Lente braderie Amsterdam</title>

        <base href="http://lentebraderieamsterdam.test/lentebraderieamsterdam/">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.1/jquery.fancybox.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

        <link media="all" type="text/css" rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="hidden-xs hidden-sm col-md-2 rounds-left">
                    <div class="yellow-round date">
                        25|26|27
                        <div>Mei</div>
                    </div>
                    <div class="yellow-round time">
                        10:00<br>
                        -<br>
                        17:00
                    </div>
                </div>
                <div class="col-xs-12 col-md-10">
                    <img src="images/bord.png" class="bord">
                </div>
            </div>
            <div class="row visible-xs visible-sm">
                <div class="col-xs-6">
                    <div class="yellow-round date">
                        25|26|27
                        <div>Mei</div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="yellow-round time">
                        10:00<br>
                        -<br>
                        17:00
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <a href="#aanmelden" class="aanmelden btn">aanmelden</a>
                </div>
            </div>
            <div class="row hidden-xs">
                <div class="col-sm-12">
                    <img src="http://app.lentebraderieamsterdam.test/assets/img/hippiemarkt-amsterdam-xl/logo.png" class="directevents_logo">
                </div>
            </div>
        </div>
        <div class="bottom-text">
            <div class="col-xs-12 title">
                Osdorpplein Amsterdam XL
            </div>
            <div class="col-xs-12 subtitle">
                food | music | fashion | lifestyle | kermis
            </div>
        </div>

        <div id="aanmelden">
            <div class="form-wrapper">
    			<div class="close"></div>

    			<div class="form-style-10">
    				<h1>Aanmelden<br>lentebraderie amsterdam<span>Hier kunt u zich aanmelden als standhouder voor de Lentebraderie Amsterdam.</span></h1>
    				<form class="test-form" action="test.php" method="post">
    					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    	                <input type="hidden" name="markt_id" value="9" />
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
    						<div class="form-label">
    							Dagen*:<br>
    							<label><input type="checkbox" class="dagen" name="dagen[0]" value="dag1">Vrijdag 25 Mei - 10:00 tot 17:00</label>
    							<label><input type="checkbox" class="dagen" name="dagen[1]" value="dag2">Zaterdag 26 Mei - 10:00 tot 17:00</label>
    							<label><input type="checkbox" class="dagen" name="dagen[2]" value="dag3">Zondag 27 Mei - 10:00 tot 17:00</label>
    							<br>
    							Indien u voor alle drie de dagen kiest word er een prijs gerekend van &euro;55,- incl. BTW per dag voor een kraam of &euro;12,50 incl. BTW per dag per meter voor een grondplek
    						</div>
    				        <label>Aantal kramen (4 meter, &euro;65,- incl. BTW per dag): <input type="number" name="kramen" value="0"/></label>
    				        <label>Aantal grondplekken (per meter, &euro;15,- incl. BTW per dag): <input type="number" name="grondplekken" value="0"/></label>
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
            });
        </script>
    </body>
</html>
