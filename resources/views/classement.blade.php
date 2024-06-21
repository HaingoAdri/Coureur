@extends("import_maison_data")
@section('title', 'Classement_general')
@section("classement")
<div class="row pt-3">
    <div class="col-6">
        <div class="card-header">
            <h4>Voir le résultat de chaque equipe</h4>
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
                                <td><a href="{{route('classement_etape_coureur_equipe', ['equipe'=>$participant->nom_equipe])}}">Details classements</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-header">
            <h4>Voir le résultat de chaque equipe par catégorie</h4>
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
                            @php
                                $displayedRangs = [];
                            @endphp

                            @foreach ($details as $participant)
                                @if (in_array($participant->rang, $displayedRangs))
                                    <tr class="bg-danger text-white">
                                        <td>{{ $participant->rang }}</td>
                                        <td>Equipe {{ $participant->nom_equipe }}</td>
                                        <td>{{ $participant->nom_categorie }}</td>
                                        <td>{{ $participant->points_equipe }} points</td>
                                        {{-- <td><a class="dropdown-item" href="{{route('classement_etape_categorie_equipe', ['equipe'=>$participant->nom_equipe])}}">Classement par étape pour chaque catégorie</a></td> --}}
                                    </tr>
                                @else
                                    @php
                                        $isExaequo = false;
                                        foreach ($details as $checkParticipant) {
                                            if ($checkParticipant->rang == $participant->rang && $checkParticipant !== $participant) {
                                                $isExaequo = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <tr class="{{ $isExaequo ? 'bg-danger text-white' : '' }}">
                                        <td>{{ $participant->rang }}</td>
                                        <td>Equipe {{ $participant->nom_equipe }}</td>
                                        <td>{{ $participant->nom_categorie }}</td>
                                        <td>{{ $participant->points_equipe }} points</td>
                                    </tr>
                                @endif

                                @php
                                    $displayedRangs[] = $participant->rang;
                                @endphp
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
