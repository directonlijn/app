<html><head>
        <meta http-equiv="Content-Type" content="charset=utf-8">
        <meta charset="UTF-8">
        <title>Factuur Direct Events - 10-02-2017</title>

        <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet"> -->


        <style type="text/css">
            * {
                font-family: 'Roboto', sans-serif;
                font-size: 10px;
            }
           .page-break {
                page-break-after: always;
            }
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: normal;
                src: local('Roboto'), local('Roboto-Regular'), url("https://fonts.googleapis.com/css?family=Roboto:500") format('truetype');
            }
        </style>
    </head>
    <body>
        <div class="to" style="
    margin-top: 190px;
    margin-bottom: -20px;
">
            {{ $standhouder['bedrijfsnaam'] }}
            <br>
            {{ $standhouder['adres'] }}
            <br>
            {{ $standhouder['postcodeplaats'] }}
        </div>

        <!-- <img style="width: 400px;position: absolute;right: 0px;top: 0px;" src="/assets/img/hippiemarkt-amsterdam-xl/logo.png"> -->
        <img style="width: 400px;height: 133px;position: absolute;right: 0px;top: 0px;" src="http://app.directevents.nl/assets/img/direct-events-logo.jpg">

        <div class="own-left" style="font-weight:900;text-align: left;position: absolute;right: 170px;">
            E-MAIL:
            <br>
            T.N.V.
            <br>
            BANK IBAN:
            <br>
            KVK-NUMMER:
            <br>
            BTW-NUMMER
        </div>

        <div class="own-right" style="position: absolute;right: 0px;width: 150px;">
            info@directevents.nl
            <br>
            G.J. Neal
            <br>
            NL90 INGB 0747 8910 01
            <br>
            75783908
            <br>
            NL85 6498 944B 01
        </div>

        <div style="margin-top:60px;">
            Bedankt voor uw aaanmelding op de {{ $titel }}
        </div>

        <div style="margin-top:20px;font-size:20px;font-weight:900;">
            FACTUUR
        </div>

        <div style="text-align:right;">
            Factuurdatum: {{ $datum }}
            <br>
            Vervaldatum: {{ $vervaldatum }}
        </div>

        <table style="margin-top: 20px; width: 100%;">
            <thead style="font-weight: 700;border-bottom:1px solid #000;">
                <tr><td>
                    Factuurnummer
                </td>
                <td>
                    Aantal dagen:
                </td>
                <td>
                    Aantal
                </td>
                <td>
                    Soort
                </td>
                <td>
                    Btw
                </td>
                <td>
                    Prijs per stuk
                </td>
                <td>
                    Totaal
                </td>
            </tr></thead>
            <tbody>
                <?php $x = 0; ?>
                @foreach ($tabel as $row)
                    <tr>
                        <td>
                            @if ($x == 0)
                                {{ $factuurnr }}
                            @endif
                        </td>
                        <td>
                            {{ $aantal_dagen }}
                        </td>
                        <td>
                            {{ $row['aantal'] }}
                        </td>
                        <td>
                            {{ $row['soort'] }}
                        </td>
                        <td>
                            {{ $row['btw'] }}
                        </td>
                        <td>
                            {{ $row['prijsperstuk'] }}
                        </td>
                        <td>
                            {{ $row['totaal'] }}
                        </td>
                    </tr>
                    <?php $x++; ?>
                @endforeach
            </tbody>
        </table>

        <div style="height:50px;"></div>

        <div style="width:100%;text-align:right;height:1px;">
            <div style="height:1px;background-color:#000;width:250px;display:inline-block;float:right;"></div>
        </div>

        <table style="width:250px;position:absolute;right: 0px;">
            <tr>
                <td style="width:150px;">
                    Totaal excl. btw
                </td>
                <td style="width:100px;">
                    {{ $totaalexbtw }}
                </td>
            </tr>
            <tr>
                <td style="width:150px;">
                    Totaal btw(21%)
                </td>
                <td style="width:100px;">
                    {{ $totaalbtw }}
                </td>
            </tr>
            <tr>
                <td style="width:150px;">
                    Totaal incl. btw
                </td>
                <td style="width:100px;">
                    {{ $totaalinbtw }}
                </td>
            </tr>
        </table>

        <div style="height:100px;"></div>

        <div class="margin-top: 150px;">
            Wij verzoeken u vriendelijk bovenstaan bedrag binnen 8 dagen over te maken onder vermelding van uw factuurnummer.
        </div>

</body></html>
