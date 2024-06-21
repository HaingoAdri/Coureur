@extends("import_maison_data")
@section('title', 'Participation'.$equipe_nom)
@section('equipe', $equipe_nom)
@section("contenu")
<div class="row pt-3">
    <div class="col-12">
        <div class="card card_default">
            <div class="card-header">
                <h2>Liste des participant</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Coureur</th>
                            <th>Etape</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($participation as $maison)
                            <tr>
                                <td>
                                    {{ $maison->nom_coureur }}
                                </td>
                                <td>
                                    Etape {{ $maison->rang_etape }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
