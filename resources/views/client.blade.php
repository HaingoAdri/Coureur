@extends("import_maison_data")
@section('title', 'Acceuil client')
@section('equipe', $equipe)
@section("contenu")
<div class="row pt-3">
    <h4>Equipe {{$equipe}}</h4>
    <div class="card-body">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @foreach ($tables as $etape => $participants)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>Étape {{ $participants[0]->rang_etape }} ({{$participants[0]->lieu}} et {{$participants[0]->nbr}} coureur par équipe) {{$participants[0]->longueur_km}} km</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Coureur</th>
                                        <th>Chrono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->nom_coureur}}</td>
                                            <td>{{ $participant->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#etape_participation_{{$etape}}">Ajouter participants</button>
                            <div class="modal fade" id="etape_participation_{{$etape}}" tabindex="-1" aria-labelledby="etape_participation_{{$etape}}Title" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEtape{{ $etape }}Label">Ajouter participants pour  Étape {{ $etape }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card card_default">
                                                @if (count($participants) == $participants[0]->nbr)
                                                    <p class="text-danger mb-3 p-3  fw-bold">Equipe Complet pour cette étape!</p>
                                                @else
                                                <div class="card-header">
                                                    <h2>Liste des courses</h2>
                                                </div>
                                                <div class="card-body">
                                                    <form action="{{ route('insert_participation') }}" method="post">
                                                        @csrf
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Coureur</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($liste_joueur as $maison)
                                                                    <tr>
                                                                        <td>
                                                                            {{ $maison->nom_coureur }}
                                                                            <input type="hidden" name="coureur_id_{{ $maison->id }}" value="{{ $maison->id }}">
                                                                            <input type="hidden" name="equipe_id" value="{{ $id }}">
                                                                            <input type="hidden" name="equipe_nom" value="{{ $equipe }}">
                                                                            <input type="hidden" name="nbr" value="{{$participants[0]->nbr}}">
                                                                            <input type="hidden" name="numero_etape" value="{{$participants[0]->id_etape}}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" name="etape[]" value="{{$maison->id}}">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <input type="submit" value="Participer">
                                                    </form>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-12">

    </div>
</div>
@endsection
