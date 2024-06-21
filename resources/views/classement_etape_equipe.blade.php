@extends("import_maison_data")
@section('title', 'Classement_equipe_etape')
@section("classement")
<div class="row pt-3">
    <h4>Voir le classement des équipes pour chaque etape</h4>
    <div class="row">
        @foreach ($class as $etape => $class)
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Étape {{ $etape }} classement d'equipe</h5>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classement_{{$etape}}">Voir classement</button>
                    </div>
                    <div class="modal fade" id="classement_{{$etape}}" tabindex="-1" aria-labelledby="classement_{{$etape}}Title" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEtape{{ $etape }}Label">Classement des équipes pour  Étape {{ $etape }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Rang</th>
                                                <th>Equipe</th>
                                                <th>Etape</th>
                                                <th>Lieu</th>
                                                <th>Point Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($class as $maison)
                                                <tr>
                                                    <td>{{$maison->rang_equipe}}</td>
                                                    <td>
                                                        Equipe {{ $maison->nom_equipe }}
                                                    </td>
                                                    <td>
                                                        Etape {{ $maison->rang_etape }}
                                                    </td>
                                                    <td>
                                                        <b>{{ $maison->lieu }}</b>
                                                    </td>
                                                    <td>
                                                        {{ $maison->total_points_etape }} points
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
