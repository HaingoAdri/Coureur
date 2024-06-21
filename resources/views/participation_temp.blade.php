@extends("import_maison_data")
@section('title', 'Pénalité')
@section("section")
<div class="row pt-3">
    <h2>Ajouter pénalités</h2>
    <div class="card mb-3">
        <div class="card-body mb-3">
            <form action="{{route('save_participation')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="validationCustom04" class="form-label">Equipe</label>
                        <select class="form-select" id="validationCustom04" name="equipe" required>
                            @foreach ($equipe as $e)
                                <option value="{{$e->id}}">Equipe {{$e->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="validationCustom04" class="form-label">Etape</label>
                        <select class="form-select" id="validationCustom04" name="etape" required>
                            @foreach ($etapes_un as $un)
                                <option value="{{$un->id}}">Etape {{$un->rang_etape}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="validationCustom04" class="form-label">Penalités</label>
                        <input type="text" name="time_es" class="form-control" step="1" pattern="\d{1,2}:[0-5]\d:[0-5]\d" required>
                    </div>
                </div>
                <div class="pt-3">
                    <input type="submit" value="Ajouter pénalités" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
    <h3>Pénalités des équipe par étapes</h3>
    <div class="card-body">
        <div class="row">
            @foreach ($etapes as $etape => $participants)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>Étape {{ $participants[0]->rang_etape }} ({{$participants[0]->nom}})</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <th>Equipe</th>
                                    <th>Pénalités</th>
                                    <th>Etape</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->nom_equipe }}</td>
                                            <td>{{ $participant->penalite }}</td>
                                            <td>Etape {{$participant->rang_etape}} ({{ $participant->nom}})</td>
                                            <td>
                                                <form action="{{route('delete_penalite', ['id'=>$participant->id, 'equipe'=>$participant->id_equipe, 'etape'=>$participant->id_etape])}}" method="post" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">X</button>
                                                </form>
                                                <script>
                                                    function confirmDelete(){
                                                        return confirm('Etes vous sur de vouloir supprimer cette pénaités ?');
                                                    }
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
