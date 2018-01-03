<?php
  // exit();
?>
  <!doctype html>
  <html lang="en">

  <?php include_once('components/head.php'); ?>

  <body class="home">
    <div id="wrapper" class="container">

      <?php include_once('components/header.php'); ?>

      <div class="content">
        <h1 class="page-title">
            Wie zijn wij?
        </h1>

        <p>
            Welkom Wij zijn Evenementenbureau Direct events. Drie jonge ondernemers met een passie
            voor organisatie. Samen bedenken en organiseren we verschillende creatieve concepten voor
            verschillende doelgroepen. Onze doelstelling is om voor de standhouders, sponsoren, partners
            en voor de bezoekers van de evenementen  een ultieme thema-beleving te organiseren.
        </p>

        <div class="row owners">
            <div class="col-sm-offset-2 col-sm-4 col-xs-12 text-center owner">
                <div class="round hideOverflow center">
                    <img src="{{ asset('images/lorrena.jpg') }}" alt="eigenaar direct events">
                </div>
                <h3>
                    Lorrena Sluijter
                </h3>
                <a href="mailto:lorrena@directevents.nl">lorrena@directevents.nl</a>
            </div>
            <div class="col-sm-4 col-xs-12 text-center owner">
                <div class="round hideOverflow center">
                    <img src="{{ asset('images/graham.jpg') }}" alt="eigenaar direct events">
                </div>
                <h3>
                    Graham Neal
                </h3>
                <a href="mailto:graham@directevents.nl">graham@directevents.nl</a>
            </div>
        </div>


      </div>

      <?php include_once('components/footer.php'); ?>

    </div>

    <?php include_once('components/bottom_scripts.php'); ?>

  </body>

  </html>
