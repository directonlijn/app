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
            Standhouders
        </h1>


        <p>
            Voor de Standhouders proberen we het zo makkelijk mogelijk te maken om in te schrijven
            voor een van onze evenementen. Direct events maakt het mogelijk voor de standhouders
            om zich online in te schrijven. Standhouders welke eerder hebben gestaan op een van onze
            evenementen of zich hebben ingeschreven voor de nieuwsbrief van Direct events, hebben altijd de
            mogelijkheid om zich als eerste in te schrijven!
        </p>

        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <h3>
                    Schrijf u nu in voor de nieuwsbrief!
                </h3>

                <form id="sign-up-newsletter">
                    <div class="input-group">
                        <label>
                            <span>Uw bedrijfsnaam:</span>
                            <input name="company-name" type="text" class="form-control" placeholder="Voorbeeld: Direct Events">
                        </label>
                    </div>
                    <div class="input-group">
                        <label>
                            <span>Uw e-mail adres:</span>
                            <input name="email" type="text" class="form-control" placeholder="Voorbeeld: info@directevents.nl">
                        </label>
                    </div>
                    <div class="input-group text-right">
                        <button type="submit" class="btn btn-default">verzenden</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="testimonial">
                    <span>
                        <img class="icon-quote quote-first" alt="quote icon" src="{{ asset('images/quote.png') }}">Super leuke concepten, makkelijk om me in te schrijven
                        en altijd veel bezoekers<img class="icon-quote quote-last" alt="quote icon" src="{{ asset('images/quote.png') }}">
                    </span>
                    <div class="testimonial-sub text-right">
                        Lil's Fashion
                    </div>
                </div>
                <div class="testimonial">
                    <span>
                        <img class="icon-quote quote-first" alt="quote icon" src="{{ asset('images/quote.png') }}">Direct events organiseert top
                        evenementen voor jong en oud.
                        Voor vragen zijn ze altijd
                        gemakkelijk te bereiken.<img class="icon-quote quote-last" alt="quote icon" src="{{ asset('images/quote.png') }}">
                    </span>
                    <div class="testimonial-sub text-right">
                        ibizaclothes
                    </div>
                </div>
            </div>
        </div>

      </div>

      <?php include_once('components/footer.php'); ?>

    </div>

    <?php include_once('components/bottom_scripts.php'); ?>

  </body>

  </html>
