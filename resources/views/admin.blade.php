@extends("import_maison_data")
@section("section")
<div class="row">
    <div class="col-3 pt-3">
        <div class="card">
            <div class="card-header">
                <h2>Import Points</h2>
            </div>
            <div class="card-body">
                <form action="{{route('import_points')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-control">
                        <input type="file" name="file" class="form_control">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-dark">Inserer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3 pt-3">
        <div class="card">
            <div class="card-header">
                <h2>Import Etape</h2>
            </div>
            <div class="card-body">
                <form action="import_etape" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-control">
                        <input type="file" name="file" class="form_control">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-dark">Inserer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3 pt-3">
        <div class="card">
            <div class="card-header">
                <h3>Import resultat</h3>
            </div>
            <div class="card-body">

                <form action="{{route('import_participation')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-control">
                        <input type="file" name="file" class="form_control">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-dark">Inserer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3 pt-3">
        <div class="card">
            <div class="card-header">
                <h2>Initialiser et generer</h2>
            </div>
            <div class="card-body">
                <a href="{{route('initialize')}}" class="btn btn-success">Truncate table</a>
                <p></p>
                <form action="{{ route('generer_categories') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Générer Catégories</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row flex-nowrap pt-2">
    <div class="col-md-9">
        <div class="card card_default">
            <div class="card-header">
                <h2>Liste des Equipes</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Equipe</th>
                        <th>Login</th>
                    </thead>
                    <tbody>
                        @foreach ($liste as $maison)
                            <tr>
                                <td>Equipe {{$maison->nom}}</td>
                                <td>{{$maison->login}}</td>
                                {{-- <td>
                                    <li class="btn btn-outline-warning dropdown">
                                        <a class="nav-link dropdown-toggle link-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Classement
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="{{route('classement_equipe_admin', ['equipe'=>$maison->nom])}}">Classement général</a></li>
                                            <li><a class="dropdown-item" href="{{route('classement_etape_equipe_equipe', ['equipe'=>$maison->nom])}}">Classement d'équipe par étape</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="{{route('classement_etape_categorie_equipe', ['equipe'=>$maison->nom])}}">Classement par étape pour chaque catégorie</a></li>
                                            <li><a class="dropdown-item" href="{{route('classement_etape_coureur_equipe', ['equipe'=>$maison->nom])}}">Classement par étape pour chaque coureur</a></li>
                                        </ul>
                                    </li>
                                </td> --}}
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
                <h2>Liste des categories</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Nom</th>
                    </thead>
                    <tbody>
                        @foreach ($liste_categorie as $maison)
                            <tr>
                                <td>{{$maison->nom}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
