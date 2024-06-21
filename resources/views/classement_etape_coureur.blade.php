@extends("import_maison_data")
@section('title', 'Classement_etape_coureur')
@section("classement")
<div class="row pt-3">
    <div class="col-12">
        <h4>Voir le classement par étape pour chaque joueur</h4>
        <div class="row">
            @foreach ($etapes as $etape => $participants)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Étape {{ $participants[0]->rang_etape }} ({{$participants[0]->lieu}}) {{$participants[0]->longueur_km}} km</h5>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#etape_{{$etape}}">Voir rang</button>
                        </div>
                        <div class="modal fade" id="etape_{{$etape}}" tabindex="-1" aria-labelledby="etape_{{$etape}}Title" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEtape{{ $etape }}Label">Classement des participants pour  Étape {{ $etape }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Rang</th>
                                                    <th>Equipe</th>
                                                    <th>Coureur</th>
                                                    <th>Genre</th>
                                                    <th>Chrono</th>
                                                    <th>Pénalité</th>
                                                    <th>Secondes</th>
                                                    <th>Temps final</th>
                                                    <th>Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($participants as $participant)
                                                    <tr>
                                                        <td>{{ $participant->rang}}</td>
                                                        <td> Equipe {{ $participant->nom_equipe }}</td>
                                                        <td>{{ $participant->nom_coureur }}</td>
                                                        <td>{{$participant->genre}}</td>
                                                        <td>{{$participant->chrono_tonga}}</td>
                                                        @if ($participant->penalty_time != '00:00:00' && $participant->penalty_time != '')
                                                            <td class="bg-danger text-white">{{ $participant->penalty_time }}</td>
                                                        @else
                                                            <td>{{ $participant->penalty_time }}</td>
                                                        @endif
                                                        {{-- <td>{{ $participant->date_arrivee }}</td> --}}
                                                        {{-- <td>{{ $participant->heure_arrivee }}</td> --}}
                                                        <td>{{ $participant->chrono_final }} s</td>
                                                        <td>({{ $participant->heure_chrono }})</td>
                                                        <td>{{ $participant->total_points }} points</td>
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
</div>
@endsection
