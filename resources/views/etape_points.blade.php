@extends("import_maison_data")
@section("section")
<div class="row flex-nowrap pt-2">
    <div class="col-md-9">
        <div class="card card_default">
            <div class="card-header">
                <h2>Liste des etapes</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        {{-- <th>Course</th> --}}
                        <th>Nom</th>
                        <th>Rang</th>
                        <th>Longueur en km</th>
                        <th>Nombre de coureurs par equipe</th>
                        <th>Data depart</th>
                        <th>Heure depart</th>
                    </thead>
                    <tbody>
                        @foreach ($liste_etape as $maison)
                            <tr>
                                {{-- <td class="col-2">Course n°{{$maison->id_course}}</td> --}}
                                <td class="col-2">{{$maison->nom}}</td>
                                <td class="col-2">Etape {{$maison->rang_etape}}</td>
                                <td class="col-2">{{$maison->longueur_km}} km</td>
                                <td>{{$maison->coureurs_par_equipe}}</td>
                                <td>{{$maison->date_depart}}</td>
                                <td>{{$maison->heure_depart}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card_default">
            <div class="card-header">
                <h2>Liste des Points</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Classement</th>
                        <th>Points</th>
                    </thead>
                    <tbody>
                        @foreach ($liste_points as $maison)
                            <tr>
                                <td>{{$maison->classement}} rang</td>
                                <td>{{$maison->points}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
