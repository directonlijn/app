<?php
  // exit();

    global $page_tite;
  $page_tite = ' - agenda';
?>
  <!doctype html>
  <html lang="en">

  <?php include_once('components/head.php'); ?>

  <body class="home">
    <div id="wrapper" class="container">

      <?php include_once('components/header.php'); ?>

      <div class="content">
        <h1 class="page-title">
            Agenda
        </h1>

        <p>
            Vanuit de Agenda kunnen standhouders zich inschrijven voor de komende evenementen van
            Direct events. Ook zijn de plannen van de komende evenementen al gepland. Hou de website of
            de facebookpagina van Direct events in de gaten voor nieuw toegevoegde evenementen en voor
            de mogelijkheid om in te schrijven!
        </p>

        <div class="agenda hidden-xs">
            <div class="row agenda-item">
                <div class="col-xs-4 text-center date">
                    Zondag 24 maart
                </div>
                <div class="col-xs-4 text-center name">
                    <h3>
                        Hippiemarkt Amsterdam XL
                    </h3>
                </div>
                <div class="col-xs-4 text-center registration">
                    <a href="#" class="btn btn-default">Inscrhijving open</a>
                </div>
            </div>
            <div class="row agenda-item">
                <div class="col-xs-4 text-center date">
                    Zondag 24 maart
                </div>
                <div class="col-xs-4 text-center name">
                    <h3>
                        Hippiemarkt Amsterdam XL
                    </h3>
                </div>
                <div class="col-xs-4 text-center registration">
                    Onder voorbehoud
                </div>
            </div>
        </div>

        <div class="agenda visible-xs">
            <div class="row agenda-item">
                <div class="col-xs-6 text-center date">
                    <h3>
                        Hippiemarkt Amsterdam XL
                    </h3>
                    <div>
                        Zondag 24 maart
                    </div>
                </div>
                <div class="col-xs-6 text-center registration">
                    <a href="#" class="btn btn-default">Inscrhijving open</a>
                </div>
            </div>
            <div class="row agenda-item">
                <div class="col-xs-6 text-center date">
                    <h3>
                        Hippiemarkt Amsterdam XL
                    </h3>
                    <div>
                        Zondag 24 maart
                    </div>
                </div>
                <div class="col-xs-6 text-center registration">
                    Onder voorbehoud
                </div>
            </div>
        </div>


      </div>

      <?php include_once('components/footer.php'); ?>

    </div>

    <?php include_once('components/bottom_scripts.php'); ?>

  </body>

  </html>
