@extends("import_maison_data")

@section('title', 'Modifier Coureur')

@section("section")
    <h1>Modifier un Coureur</h1>

    <form action="{{ route('coureurs.update', $coureur->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $coureur->nom) }}">
        </div>

        <div class="form-group">
            <label for="numero_dossard">Numéro Dossard</label>
            <input type="text" class="form-control" id="numero_dossard" name="numero_dossard" value="{{ old('numero_dossard', $coureur->numero_dossard) }}">
        </div>

        <div class="form-group">
            <label for="genre">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre', $coureur->genre) }}">
        </div>

        <div class="form-group">
            <label for="date_naissance">Date de Naissance</label>
            <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $coureur->date_naissance) }}">
        </div>

        <div class="form-group">
            <label for="equipe">Équipe</label>
            <input type="text" class="form-control" id="equipe" name="equipe" value="{{ old('equipe', $coureur->equipe) }}">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection
