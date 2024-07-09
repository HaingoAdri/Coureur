@extends("import_maison_data")

@section('title', 'Liste Datawarehouse Coureur')

@section("section")
    <h1>Liste des Coureurs dans Datawarehouse</h1>
    <div class="row">
        <div class="col-9">
            <form action="{{ route('coureurs.search') }}" method="GET">
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control" name="search" placeholder="Rechercher par nom ou équipe">
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-3">
            <a href="{{ route('generate') }}" class="btn btn-success">Transférer données</a>
        </div>
    </div>
    <br>    

    <table class="table table-bordered p-2">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Numéro Dossard</th>
                <th>Genre</th>
                <th>Date de Naissance</th>
                <th>Âge</th> <!-- Nouvelle colonne pour l'âge -->
                <th>Équipe</th>
                <th>Action</th> <!-- Nouvelle colonne pour les actions -->
            </tr>
        </thead>
        <tbody>
            @foreach ($coureursWarehouse as $coureur)
            <tr>
                <td>{{ $coureur->nom }}</td>
                <td>{{ $coureur->numero_dossard }}</td>
                <td>{{ $coureur->genre }}</td>
                <td>{{ $coureur->date_naissance }}</td>
                <td>{{ $coureur->age }} ans</td> <!-- Affichage de l'âge calculé -->
                <td>{{ $coureur->equipe }}</td>
                <td>
                    <a href="{{ route('coureurs.edit', $coureur->id) }}" class="btn btn-success">Modifier</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
