<?php
    $markten = App\Models\Markt::orderBy('Datum_van', 'desc')->get();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        {!! Html::style('/assets/css/app.css') !!}

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script>

        </script>
    </head>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/dashboard">Direct events</a>
            </div>
            <div id="navbar" class="main-nav collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/dashboard">Home</a></li>
                    @if (Auth::check())
                        <li><a href="/invoices">Facturen</a></li>
                        <!-- <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Markten
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/markten/beheer">Markten beheren</a></li>
                                @foreach ($markten as $markt)
                                    <li><a href="/markten/{{ $markt->Naam }}">{{ $markt->Naam }}</a></li>
                                @endforeach
                            </ul>
                        </li> -->
                    @endif
                    @if (Auth::check())
                        <li><a href="/logout">log uit</a></li>
                    @else
                        <li><a href="/login">inloggen</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <body>
        <div class="container-fluid content">
            @yield('content')
        </div><!-- /.container -->

        @yield('bottom')
    </body>
</html>
