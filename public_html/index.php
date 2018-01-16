<?php
  // exit();

    global $page_tite;
  $page_tite = ' - home';
?>
  <!doctype html>
  <html lang="en">

  <?php include_once('components/head.php'); ?>

  <body class="home">
    <div id="wrapper" class="container">

      <?php include_once('components/header.php'); ?>

      <div class="content">
        <h1 class="page-title">
        Welkom bij Direct Events
    </h1>

        <p>
          Direct events is een evenementen bureau dat zich richt op thema evenementen. Het bedrijf bestaat uit drie ondernemers met een passie voor organiseren. Ons doel is om zowel de standhouders als de bezoekers een onvergetelijke dag te bezorgen.
        </p>

        <div id="event-carousel" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#event-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#event-carousel" data-slide-to="1"></li>
            <li data-target="#event-carousel" data-slide-to="2"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active text-center">
              <a href="hippiemarkt-amsterdam-xl">
                    <img src="/images/hippiemarkt-amsterdam-xl.png" alt="hippiemarkt amsterdam XL">
                </a>
            </div>

            <div class="item text-center">
              <a href="hippiemarkt-amsterdam-xl">
                    <img src="/images/hippiemarkt-amsterdam-xl.png" alt="Chicago">
                </a>
            </div>

            <div class="item text-center">
              <a href="hippiemarkt-amsterdam-xl">
                    <img src="/images/hippiemarkt-amsterdam-xl.png" alt="New York">
                </a>
            </div>
          </div>

          <!-- Left and right controls -->
          <a class="left carousel-control" href="#event-carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
          <a class="right carousel-control" href="#event-carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>

        <div class="row pages">
          <div class="col-sm-4 text-center">
            <a href="sponsoren">
                <img src="/images/sponsoren.png" alt="sponsoren">
                <h3>
                    Sponsoren
                </h3>
            </a>
          </div>
          <div class="col-sm-4 text-center">
            <a href="standhouders">
                <img src="/images/standhouders.png" alt="standhouders">
                <h3>
                    Standhouders
                </h3>
            </a>
          </div>
          <div class="col-sm-4 text-center">
            <a href="partners">
                <img src="/images/partners.png" alt="partners">
                <h3>
                    Partners
                </h3>
            </a>
          </div>
        </div>
      </div>

      <?php include_once('components/footer.php'); ?>

    </div>

    <?php include_once('components/bottom_scripts.php'); ?>

  </body>

  </html>
