@extends("import_maison_data")
@section("section")
<div class="row flex-nowrap pt-2">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h2>Liste de coureur</h2>
                {{-- <input type="text" id="searchInput" class="form-control" onkeyup="search()" placeholder="Rechercher..."> --}}
            </div>
            <div class="card-body">
                <table class="table" id="travauxMaisonTable">
                    <thead>
                        <th>Equipe</th>
                        <th>Nom</th>
                        <th class="col-6">Dossard</th>
                        <th>Genre</th>
                        <th>Naissance</th>
                    </thead>
                    <tbody>
                        @foreach ($liste_coureur as $maison)
                            <tr>
                                <td>Equipe {{$maison->nom_equipe}}</td>
                                <td>{{$maison->nom_coureur}}</td>
                                <td class="col-6">{{$maison->numero_dossard}}</td>
                                <td>{{$maison->genre}}</td>
                                <td>{{$maison->date_naissance}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    @if ($liste_coureur->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link btn btn-outline-primary">&laquo; Précédent</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link btn btn-outline-primary" href="{{ $liste_coureur->previousPageUrl() }}" rel="prev">&laquo; Précédent</a>
                        </li>
                    @endif
                    <li class="page-item disabled">
                        <span class="page-link btn btn-outline-primary">Page {{ $liste_coureur->currentPage() }} de {{ $liste_coureur->lastPage() }}</span>
                    </li>
                    @if ($liste_coureur->hasMorePages())
                        <li class="page-item">
                            <a class="page-link btn btn-outline-primary" href="{{ $liste_coureur->nextPageUrl() }}" rel="next">Suivant &raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link btn btn-outline-primary">Suivant &raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
