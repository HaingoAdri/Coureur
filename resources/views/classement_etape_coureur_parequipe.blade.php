@extends("import_maison_data")
@section('title', 'Classement_pour_equipe_'.$equipe.'_coureur')
@section('equipe', $equipe)
@section("classement")
<div class="row pt-3">
   <div class="col-12">
        <h4>Voir classement par étape pour chaque coueur de l'Equipe {{$equipe}}</h4>
        <div class="card-body">
            <div class="row">
                @foreach ($etapes as $etape => $participants)
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Étape {{ $participants[0]->rang_etape }} ({{$participants[0]->lieu}})</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $somme = 0;
                                @endphp
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Rang</th>
                                            <th>Equipe</th>
                                            <th>Coureur</th>
                                            {{-- <th>Heure début</th> --}}
                                            <th>Date arrivee</th>
                                            <th>Heure arrivee</th>
                                            {{-- <th>Temp total</th> --}}
                                            <th>Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($participants as $participant)

                                            <tr>
                                                <td>{{ $participant->rang}}</td>
                                                <td> Equipe {{ $participant->nom_equipe }}</td>
                                                <td>{{ $participant->nom_coureur }}</td>
                                                {{-- <td>{{ $participant->heure_depart }}</td> --}}
                                                <td>{{ $participant->date_arrivee }}</td>
                                                <td>{{ $participant->heure_arrivee }}</td>
                                                {{-- <td>{{ $participant->total }}</td> --}}
                                                <td>{{ $participant->total_points }} points</td>
                                            </tr>
                                            @php
                                                $somme += $participant->total_points;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <p>Total points pour <b>Etape {{$participants[0]->rang_etape}} </b>: {{$somme}} points</p>
                                {{-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#etape_{{$etape}}">Voir rang</button> --}}
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
                                                            {{-- <th>Heure début</th> --}}
                                                            <th>Date arrivee</th>
                                                            <th>Heure arrivee</th>
                                                            {{-- <th>Temp total</th> --}}
                                                            <th>Points</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($participants as $participant)
                                                            <tr>
                                                                <td>{{ $participant->rang}}</td>
                                                                <td> Equipe {{ $participant->nom_equipe }}</td>
                                                                <td>{{ $participant->nom_coureur }}</td>
                                                                {{-- <td>{{ $participant->heure_depart }}</td> --}}
                                                                <td>{{ $participant->date_arrivee }}</td>
                                                                <td>{{ $participant->heure_arrivee }}</td>
                                                                {{-- <td>{{ $participant->total }}</td> --}}
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
</div>
@endsection
