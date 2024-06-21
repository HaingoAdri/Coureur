@extends("import_maison_data")
@section('title', 'Classement_pour_equipe_'.$equipe)
@section('equipe', $equipe)
@section("classement")
<div class="row pt-3">
    <div class="col-6">
        <div class="card-header">
            <h4>Voir le résultat pour equipe {{$equipe}}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Equipe</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultat as $participant)
                            <tr>
                                <td>{{$participant->rang}}</td>
                                <td>Equipe {{ $participant->nom_equipe}}</td>
                                <td>{{ $participant->totals }} points</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-header">
            <h4>Voir résultat par catégorie pour Equipe {{$equipe}}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="categorieTab" role="tablist">
                @foreach ($resultat_categorie as $categorie => $details)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $categorie }}" data-bs-toggle="tab"
                            data-bs-target="#content-{{ $categorie }}" type="button" role="tab" aria-controls="content-{{ $categorie }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $categorie }}</button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="categorieTabContent">
                @foreach ($resultat_categorie as $categorie => $details)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $categorie }}" role="tabpanel" aria-labelledby="tab-{{ $categorie }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Rang</th>
                                    <th>Equipe</th>
                                    <th>Categorie</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $participant)
                                    <tr>
                                        <td>{{ $participant->rang }}</td>
                                        <td>Equipe {{ $participant->nom_equipe }}</td>
                                        <td>{{ $participant->nom_categorie }}</td>
                                        <td>{{ $participant->points_equipe }} points</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
