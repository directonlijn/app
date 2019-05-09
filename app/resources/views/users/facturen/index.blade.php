@extends('baselayout')

@section('title') Facturen @stop


@section('content')

    <br>
    <br>
    <br>
    <br>
    <table class="table table-striped standhouders-table">
        <tr>
            <td>#</td>
            <td>factuurnummer</td>
            <td>datum</td>
            <td>totaal bedrag</td>
            <td>betaald</td>
            <td>acties</td>
        </tr>
        @foreach($facturen as $factuur)
            <tr>
                <td>{{ $factuur->id }}</td>
                <td>{{ $factuur->factuurnummer }}</td>
                <td>{{ $factuur->datum }}</td>
                <td>{{ $factuur->totaal_bedrag }}</td>
                <td>{{ $factuur->betaald }}</td>
                <td class="filterable-cell"><img class="see" data-toggle="modal" data-target="#basicModal" data-standhouder_id="{{ $factuur->standhouder_id }}" src="/assets/img/dashboard/icons/pencil.png"></td>
            </tr>
        @endforeach
    </table>

    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Standhouder gegevens</h4>
                </div>
                <div class="modal-body">
                    <?php
                        $fields = [
                            'Voornaam',
                            'Achternaam',
                            'Bedrijfsnaam',
                            'Email',
                            'Telefoon',
                            'Straat',
                            'Huisnummer',
                            'Toevoeging',
                            'Postcode',
                            'Woonplaats'
                        ];
                    ?>

                    @foreach($fields as $field)
                        <div class="form-group">
                            <label>{{ $field }}</label>
                            <input type="text" id="{{ $field }}" class="form-control" disabled>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.see', function(){
                console.log($(this).data('standhouder_id'));
                var standhouder_id = $(this).data('standhouder_id');

                $.post({
                    type: "GET",
                    url: "/standhouder/"+standhouder_id
                })
                    .done(function(data){
                        jQuery.each(data, function(index, value) {
                            console.log(index + ': ' + value);
                            $("#" + index).val(value);
                        });
                    })
                    .fail(function(data){
                        alert('er is iets fout gegaan');
                    });
            });
        });
    </script>
@endsection