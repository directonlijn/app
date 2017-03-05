<!DOCTYPE html>
<html>
	<head>
		<title>Hippiemarkt Amsterdam XL</title>

		<!-- FONTS -->
		<!-- <link rel="stylesheet" type="text/css" href="css/fonts/stylesheet.css"> -->
		<!-- <link rel="stylesheet" type="text/css" href="/assets/fonts/stylesheet.css"> -->
		{!! Html::style('/assets/fonts/stylesheet.css') !!}
		<link href="https://fonts.googleapis.com/css?family=Roboto:500,700,900" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

		<!-- STYLES -->
		{!! Html::style('/assets/css/moederdagmarkt-abcoude/style.css') !!}
		<!-- <link rel="stylesheet" href="css/bjqs.css"> -->

		<!-- JS -->
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="/assets/js/moederdagmarkt-abcoude/script.js"></script>

		<script>
  			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  			ga('create', 'UA-90347468-1', 'auto');
  			ga('send', 'pageview');

		</script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	</head>
	<body>
		<div class="landscape">
			<div class="landscape-text">Roteer uw telefoon naar portrait</div>
		</div>
		<div class="all">
			<img class="lichtinval-achter" src="/assets/img/moederdagmarkt-abcoude/lichtinval-achter.png">
			<img class="bord" src="/assets/img/moederdagmarkt-abcoude/bord.png">


			<img class="sticker" src="/assets/img/moederdagmarkt-abcoude/sticker.png">
			<img class="facebook" src="/assets/img/moederdagmarkt-abcoude/facebook.png">
			<img class="facebook-text" src="/assets/img/moederdagmarkt-abcoude/at-moederdagmarktabcoude.png">

			<img class="bord-footer" src="/assets/img/moederdagmarkt-abcoude/fashion-lifestyle-food-drinks-music.png">

			<img class="lichtinval-voor" src="/assets/img/moederdagmarkt-abcoude/lichtinval-voor.png">

			<img class="flower" src="/assets/img/moederdagmarkt-abcoude/flower.png">

			<div class="direct-events">
				<img class="direct-events-logo" src="/assets/img/logo.png">
			</div>

			<input type="button" class="aanmelden standhouders" value="">
			<input type="button" class="aanmelden winkeliersvereniging" value="">
		</div>

		<div class="form-overlay"></div>

        <div class="form-wrapper">
			<div class="close"></div>

			<div class="form-style-10">
				<h1>Aanmelden Moederdag Markt Abcoude<span>Hier kunt u zich aanmelden als standhouder voor de Moederdag Markt Abcoude.</span></h1>
				<form class="test-form" action="test.php" method="post">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	                <input type="hidden" name="markt_id" value="4" />
	                <input type="hidden" name="winkeliersvereniging" value="0" />
				    <div class="section"><span>1</span>Bedrijfs- &amp; <h3 class="mobile-only"><br></h3>Persoons-gegevens</div>
				    <div class="inner-wrap">
				        <label>Bedrijfsnaam*: <input type="text" name="bedrijfsnaam" required/></label>
				        <label>Voornaam*: <input type="text" name="voornaam" required/></label>
				        <label>Achternaam*: <input type="text" name="achternaam" required/></label>
				        <label>Telefoon*: <input type="tel" name="telefoon" maxlength="10" required/></label>
				        <label>E-mail*: <input type="email" name="email"  placeholder="info@hippiemarktderondevenen.nl" required/></label>
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
				        <label>Aantal kramen (4 meter<span class="text-standhouders">, &euro;75,- incl. BTW</span>): <input type="number" name="kramen" value="0"/></label>
				        <label>Aantal grondplekken (4 meter<span class="text-standhouders">, &euro;65,- incl. BTW</span>): <input type="number" name="grondplekken" value="0"/></label>
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
