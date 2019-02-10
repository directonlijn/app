<!DOCTYPE html>
<html>
	<head>
		<title>Hippiemarkt Amsterdam Centrum</title>

		<!-- FONTS -->
		<!-- <link rel="stylesheet" type="text/css" href="css/fonts/stylesheet.css"> -->
		<!-- <link rel="stylesheet" type="text/css" href="/assets/fonts/stylesheet.css"> -->
		{!! Html::style('/assets/fonts/stylesheet.css') !!}
		<link href="https://fonts.googleapis.com/css?family=Roboto:500,700,900" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

		<!-- STYLES -->
		{!! Html::style('/assets/style.css') !!}
		<!-- <link rel="stylesheet" href="css/bjqs.css"> -->

		<!-- JS -->
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="/assets/js/hippiemarkt-amsterdam-xl.js"></script>

		<script>
  			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  			ga('create', 'UA-90347468-1', 'auto');
  			ga('send', 'pageview');

		</script>

		<meta property="og:url"                content="http://www.hippiemarktamsterdamxl.nl" />
		<meta property="og:type"               content="website" />
		<meta property="og:title"              content="Hippiemarkt Amsterdam XL - Direct Events" />
		<meta property="og:description"        content="De Hippiemarkt Amsterdam XL is op zaterdag 22 september tijdens burendag op de Jan Pieter Heijestraat te Amsterdam" />
		<meta property="og:image"              content="http://app.directevents.nl/assets/img/hippiemarkt-amsterdam-xl/facebook.png" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

		<link rel="image_src" href="http://app.directevents.nl/assets/img/hippiemarkt-amsterdam-xl/facebook.png">
	</head>
	<body>
		<div class="all">
			<img class="beplanting" src="/assets/img/hippiemarkt-amsterdam-xl/beplanting.png">
			<img class="sterren" src="/assets/img/hippiemarkt-amsterdam-xl/sterren.png">
			<img class="glas-drinken" src="/assets/img/hippiemarkt-amsterdam-xl/glas-drinken.png">

			<img class="dromenvanger" src="/assets/img/hippiemarkt-amsterdam-xl/dromenvanger.png">
			<img class="bord" src="/assets/img/hippiemarkt-amsterdam-xl/bord.png">

			<img class="logo" src="/assets/img/hippiemarkt-amsterdam-xl/logo.png">

	        <div class="round datum">
						<div class="round-inner">
		            ZONDAG
		            <div class="day">31</div>
		            MAART
		        </div>
	        </div>

	        <div class="round kramen">
						<div class="round-inner">
							12:00
							<div class="day">-</div>
							17:00
						</div>
	        </div>

	        {{--<div class="round xl">--}}
	            {{--<span class="xl-inner">XL</span>--}}
	        {{--</div>--}}

	        <div class="footer">
	            FASHION | FOOD | DRINKS | MUSIC | LIFESTYLE
	        </div>

			{{--<input type="button" class="aanmelden winkeliersvereniging" value="Winkeliers">--}}
			<input type="button" class="aanmelden standhouders" value="Standhouders">
		</div>

		<div class="form-overlay"></div>

        <div class="form-wrapper">
			<div class="close"></div>


			<div class="form-style-10">
				<?php /* <h1>Informatie Hippiemarkt Amsterdam XL</span></h1>

				<h2>Algemene informatie</h2>
				<ul>
					<li>De markt is gratis toegankelijk</li>
					<li>De markt duurt van van 11:00 tot 17:00</li>
					<li>Parkeren is gratis doordat de Hippiemarkt op een zondag valt</li>
					<li>Adres: Osdorpplein 626, 1068 TB Amsterdam</li>
				</ul>

				<h2>Bezoekers</h2>
				<p>
					Hippiemarkt Amsterdam XL op het osdorpplein/tussenmeer in Amsterdam en is voor bezoekers vrij toegankelijk. De hippiemarkt vind plaats op 26 maart. Doordat dit op een zondag valt
					is het overal vrij parkeren in Amsterdam.
				</p>

				<h2>Standhouders</h2>
				<p>
					Helaas zitten wij helemaal vol. Mocht u zich aangemeld hebben en de email met informatie en de plattegrond ontvangen hebben dan bent u welkom op de Hippiemarkt Amsterdam XL.
				</p>

				<p>
					Mocht u nog verdere vragen hebben dan kunt u een e-mail sturen naar <a href="mailto:info@directevents.nl">info@directevents.nl</a>. Tot zondag 26 maart.
				</p>
				*/ ?>
				<h1>Aanmelden</h1>
				<form class="test-form" action="test.php" method="post">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	                <input type="hidden" name="markt_id" value="14" />
	                <input type="hidden" name="winkeliersvereniging" value="0" />
				    <div class="section"><span>1</span>Bedrijfs- &amp; <h3 class="mobile-only"><br></h3>Persoons-gegevens</div>
				    <div class="inner-wrap">
				        <label>Bedrijfsnaam*: <input type="text" name="bedrijfsnaam" required/></label>
				        <label>Voornaam*: <input type="text" name="voornaam" required/></label>
				        <label>Achternaam*: <input type="text" name="achternaam" required/></label>
				        <label>Telefoon*: <input type="tel" name="telefoon" maxlength="10" required/></label>
				        <label>E-mail*: <input type="email" name="email"  placeholder="info@hippiemarktamsterdamxl.nl" required/></label>
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
						<label class="gevel">Gevel vrij:<input type="checkbox" name="gevelvrij"></label>
				        <label>
									Food/non-food*:
									<input type="radio" name="foodNonfood" value="food">food
									<span style="display:inline-block;width:20px;"></span>
		                            <input type="radio" name="foodNonfood" value="non-food" checked="checked">non food
								</label>
								{{--<div class="form-label">--}}
									{{--Dagen*:<br>--}}
									{{--<label><input type="checkbox" class="dagen" name="dagen[0]" value="dag1">Vrijdag 30 Maart - 11:00 tot 17:00</label>--}}
									{{--<label><input type="checkbox" class="dagen" name="dagen[1]" value="dag2">Zaterdag 31 Maart - 11:00 tot 17:00</label>--}}
								{{--</div>--}}
				        <label>Aantal kramen (4 meter<span class="text-standhouders">, &euro;60,- incl. BTW</span>): <input type="number" name="kramen" value="0"/></label>
				        <label>Aantal grondplekken (per meter<span class="text-standhouders">, &euro;10,- incl. BTW</span>): <input type="number" name="grondplekken" value="0"/></label>
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

	</body>
</html>
