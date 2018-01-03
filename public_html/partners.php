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
            Partners
        </h1>

        <p>
            Evenementenbureau Direct events werkt met verschillende Partners samen. Dit kunnen leveranciers
            zijn, decoratie specialisten, andere evenementenbureaus maar ook gemeenten!
        </p>

        <p>
            Wilt u ook partner worden van Direct events neem dan contact op via onderstaand formulier
            of stuur een e-mail naar <a href="mailto:info@directevents.nl">info@directevents.nl</a>.
        </p>

        <div class="row">
            <form id="sign-up-partner">
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
                    <div class="input-group">
                        <textarea class="form-control" name="message" placeholder="Typ hier uw bericht"></textarea>
                    </div>
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
