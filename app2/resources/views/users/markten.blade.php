@extends('baselayout')

@section('title') Markten @stop

@section('bottom')
    <script>
        $(document).ready(function(){
            $(".markt-item").on("click", function(){
                var $id = $(this).find("a").data("id");
                var $data = { _token: "{{ csrf_token() }}", id: $id };

                $.post({
                    type: "POST",
                    url: "getStandhoudersForMarkt",
                    data: $data
                })
                .done(function(data){
                    console.log("done");
                    $(".standhouders-table tbody").empty();
                    $standhouders = data.standhouders;
                    $html = '';
                    for(var i = 0;i < $standhouders.length; i++)
                    {
                        $html += "<tr>";
                        $html += "<td>"+ $standhouders[i].id +"</td>";
                        $html += "<td>"+ $standhouders[i].Bedrijfsnaam +"</td>";
                        $html += "<td>"+ $standhouders[i].Voornaam + " " + $standhouders[i].Achternaam +"</td>";
                        $html += "<td>"+ $standhouders[i].Telefoon +"</td>";
                        $html += "<td>"+ $standhouders[i].Email +"</td>";
                        $html += "<td>"+ $standhouders[i].Website +"</td>";
                        $html += "</tr>";
                    }

                    $(".standhouders-table tbody").append($html);
                })
                .fail(function(data){
                    console.log("fail");
                });

                // $.post( "getStandhouderForMarkt", { id: $id, _token: "{{ csrf_token() }}" } );
            });
        });
    </script>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="position: absolute;">
            <ul class="nav nav-sidebar">
                <li class="markt-item active"><a data-id="0" href="#">Overview <span class="sr-only">(current)</span></a></li>
                @foreach ($markten as $markt)
                    <li class="markt-item"><a data-id="{{ $markt->id }}" href="#">{{ $markt->Naam }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
            </div>

            <h2 class="sub-header">Standhouders</h2>
            <div class="table-responsive">
                <table class="table table-striped standhouders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bedrijfsnaam</th>
                            <th>Naam</th>
                            <th>Telefoon</th>
                            <th>E-mail</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
