@extends("import_maison_data")
@section('title', 'Liste Datawarehouse Coureur')
@section("section")
    <h1>Liste des Coureurs dans Datawarehouse</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Numéro Dossard</th>
                <th>Genre</th>
                <th>Date de Naissance</th>
                <th>Équipe</th>
                <th>Créé le</th>
                <th>Modifié le</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coureursWarehouse as $coureur)
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
</body>
</html>
@endsection