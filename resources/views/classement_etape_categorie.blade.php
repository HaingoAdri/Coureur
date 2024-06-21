@extends("import_maison_data")
@section('title', 'Classement_etape_categorie')
@section("classement")
<div class="row pt-3">
    <div class="col-12">
        <h4>Voir classement par étape pour chaque categorie</h4>
        <div class="card-body">
            <div class="row">
                @foreach ($etapes as $etape => $participants)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Étape {{ $participants[0]->rang_etape }} ({{$participants[0]->lieu}})</h5>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#etape_categorie_{{$etape}}">Voir rang</button>
                            </div>
                            <div class="modal fade" id="etape_categorie_{{$etape}}" tabindex="-1" aria-labelledby="etape_categorie_{{$etape}}Title" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEtape{{ $etape }}Label">Mon classement par catégorie pour  Étape {{ $etape }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="nav nav-tabs" id="categorieTab{{ $etape }}" role="tablist">
                                                @foreach ($categories[$etape] as $categorie => $details)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $etape }}-{{ $categorie }}" data-bs-toggle="tab"
                                                            data-bs-target="#content-{{ $etape }}-{{ $categorie }}" type="button" role="tab" aria-controls="content-{{ $etape }}-{{ $categorie }}"
                                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $categorie }}</button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content" id="categorieTabContent{{ $etape }}">
                                                @foreach ($categories[$etape] as $categorie => $details)
                                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $etape }}-{{ $categorie }}" role="tabpanel" aria-labelledby="tab-{{ $etape }}-{{ $categorie }}">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Rang</th>
                                                                    <th>Equipe</th>
                                                                    <th>Coureur</th>
                                                                    <th>Categorie</th>
                                                                    <th>Date arrivée</th>
                                                                    <th>Heure arrivée</th>
                                                                    <th>Penalite</th>
                                                                    <th>Points</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($details as $participant)
                                                                    <tr>
                                                                        <td>{{ $participant->rang_coureur }}</td>
                                                                        <td>Equipe {{ $participant->nom_equipe }}</td>
                                                                        <td>{{$participant->nom_coureur}}</td>
                                                                        <td>{{ $participant->nom_categorie }}</td>
                                                                        <td>{{ $participant->date_arrivee }}</td>
                                                                        <td>{{$participant->penalty_time}}</td>
                                                                        <td>{{ $participant->heure_arrivee }}</td>
                                                                        <td>{{ $participant->points_cate }} points</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>
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
