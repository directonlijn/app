<?php
  exit();
  global $page_tite;
  $page_tite = ' - sponsoren';
?>

  <!doctype html>
  <html lang="en">

  <?php include_once('components/head.php'); ?>

  <body class="home">
    <div id="wrapper" class="container">

      <?php include_once('components/header.php'); ?>

      <div class="content">
        <h1 class="page-title">
            Sponsoren
        </h1>

        <p>
            Sponsoren van een evenement van Direct Events hebben de mogelijkeheid om op wel drie kanelen
            terug te komen!
        </p>

        <ol>
            <li>
                Op de facebookpagina van het evenement
            </li>
            <li>
                Op de webpagina van het evenement
            </li>
            <li>
                En op het evenement zelf!
            </li>
        </ol>

        <p>
            Sponsoren krijgen na afloop van het evenement een evaluatierapport met verkregen bereik en het
            sponsormateriaal in beeld!
        </p>

        <p>
            Wilt u sponsor worden van een van de evenementen? Neem dan contact op via onderstaand formulier
            of stuur een e-mail naar <a href="mailto:info@directevents.nl">info@directevents.nl</a>.
        </p>

        <div class="row">
            <form id="sign-up-sponsor">
                <div class="col-sm-6 col-xs-12">
                    <div class="input-group">
                        <label>
                            <span>Uw bedrijfnaam of gemeente:</span>
                            <input name="company-name" type="text" class="form-control" placeholder="Voorbeeld: Direct Events">
                        </label>
                    </div>
                    <div class="input-group">
                        <label>
                            <span>Uw e-mail adres:</span>
                            <input name="email" type="text" class="form-control" placeholder="Voorbeeld: info@directevenst.nl">
                        </label>
                    </div>
                    <div class="input-group">
                        <label>
                            <span>Uw telefoonnummer:</span>
                            <input name="phone" type="text" class="form-control" placeholder="Voorbeeld: 0612345678">
                        </label>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <textarea name="message" class="form-control" placeholder="Typ hier uw bericht"></textarea>
                    <div class="input-group text-right">
                        <button type="submit" class="btn btn-default">verzenden</button>
                    </div>
                </div>
            </form>
        </div>


      </div>

      <?php include_once('components/footer.php'); ?>

    </div>

    <?php include_once('components/bottom_scripts.php'); ?>

  </body>

  </html>
