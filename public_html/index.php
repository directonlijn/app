<?php
  // exit();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="kIJdPKOJ057C5Qn1knw7LR4EfcKFvHVI2P9ImnEQ">

        <title>Direct Events - home</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
    </head>
    <body class="home">
        <div id="wrapper" class="container">

            <header>
                <a class="hidden-xs logo-outer" href="/"><img src="/images/logo.png" class="logo" alt="logo"></a>
            </header>

            <div class="row">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand visible-xs" href="/">Direct Events</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Zoeken</button>
                </form> -->
                <ul class="nav navbar-nav text-center">
                    <li><a href="/">Home</a></li>
                    <li><a href="standhouders">Standhouders</a></li>
                    <li><a href="sponsoren">Sponsoren</a></li>
                    <li><a href="partners">Partners</a></li>
                    <li><a href="agenda">Agenda</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Evenementen <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="agenda">Alle evenementen</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="markt/hippiemarkt-aalsmeer">Hippiemarkt Aalsmeer</a></li>
                            <li><a href="markt/hippiemarkt-vinkeveen">Hippiemarkt Vinkeveen</a></li>
                            <li><a href="hippiemarkt-amsterdam-xl">Hippiemarkt Amsterdam XL</a></li>
                        </ul>
                    </li>
                    <li><a href="wie-zijn-wij">Wie zijn wij</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>

            <div class="content">
                    <h1 class="page-title">
        Welkom bij Direct Events
    </h1>

    <p>
        Direct events is een evenementen bureau dat zich richt op thema evenementen.
        Het bedrijf bestaat uit drie ondernemers met een passie voor organiseren. Ons
        doel is om zowel de standhouders als de bezoekers een onvergetelijke dag te
        bezorgen.
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

            <footer>
                <div class="row text-center">
    <img src="/images/logo.png" class="logo" alt="logo">
</div>
<div class="row text-center">
    <p>
        Copyright 2018 - Direct Events
    </p>
</div>
            </footer>

                        <div class="popup-background" v-on:click="closePopup"></div>

                    </div>

        <script src="js/app.js"></script>

    </body>
</html>
