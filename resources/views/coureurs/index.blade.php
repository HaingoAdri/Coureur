@extends("import_maison_data")
@section('title', 'Resultats recherche')
@section("section")
    <div class="container">
        <h1>Recherche de Coureurs</h1>

        <!-- Formulaire de recherche -->
        <form action="{{ route('coureurs.search') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou équipe">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </div>
        </form>

        <!-- Affichage des résultats de la recherche -->
        @if(isset($resultats))
            <h2>Résultats de la recherche</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Numéro de Dossard</th>
                        <th>Genre</th>
                        <th>Date de Naissance</th>
                        <th>Équipe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultats as $coureur)
                        <tr>
                            <td>{{ $coureur->nom }}</td>
                            <td>{{ $coureur->numero_dossard }}</td>
                            <td>{{ $coureur->genre }}</td>
                            <td>{{ $coureur->date_naissance }}</td>
                            <td>{{ $coureur->equipe }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
