@extends("import_maison_data")
@section("section")
<div class="row">
    <div class="col-3 pt-3">
        <div class="card">
            <div class="card-header">
                <h2>Import Travaux</h2>
            </div>
            <div class="card-body">
                <form action="{{route('import_maison_data')}}" method="post" enctype="multipart/form-data">
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
                <h2>Import Devis</h2>
            </div>
            <div class="card-body">
                <form action="{{route('import_Client')}}" method="post" enctype="multipart/form-data">
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
                <h2>Import Paiement</h2>
            </div>
            <div class="card-body">
                <form action="import_paiement" method="post" enctype="multipart/form-data">
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
                <h2>Initialiser vos données</h2>
            </div>
            <div class="card-body">
                <a href="{{route('initialize')}}" class="btn btn-success">Truncate table</a>
            </div>
        </div>
    </div>
</div>
<div class="row flex-nowrap pt-2">
    <div class="col-md-9">
        <div class="card card-default">
            <div class="card-header">
                <h2>Travaux Maison</h2>
                <input type="text" id="searchInput" class="form-control" onkeyup="search()" placeholder="Rechercher...">
            </div>
            <div class="card-body">
                <table class="table" id="travauxMaisonTable">
                    <thead>
                        <th>Type_maison</th>
                        <th class="col-6">Description</th>
                        <th>Surface</th>
                        <th>Type_travaux</th>
                        <th>Unité</th>
                        <th>Quanite</th>
                        <th>Prix_unitaire</th>
                        <th>Duree_travaux</th>
                        <th>Montant</th>
                    </thead>
                    <tbody>
                        @foreach ($liste as $maison)
                            <tr>
                                <td>{{$maison->nom}}</td>
                                <td class="col-6">{{$maison->descriptions}}</td>
                                <td>{{$maison->surface}}</td>
                                <td>{{$maison->type_travaux}}</td>
                                <td>{{$maison->unite}}</td>
                                <td>{{$maison->quantite}}</td>
                                <td>{{$maison->pu}} Ar</td>
                                <td>{{$maison->duree}}</td>
                                <td>{{$maison->montant}} Ar</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{-- Bouton "Précédent" --}}
                    @if ($liste->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link btn btn-outline-primary">&laquo; Précédent</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link btn btn-outline-primary" href="{{ $liste->previousPageUrl() }}" rel="prev">&laquo; Précédent</a>
                        </li>
                    @endif

                    {{-- Numéro de la page --}}
                    <li class="page-item disabled">
                        <span class="page-link btn btn-outline-primary">Page {{ $liste->currentPage() }} de {{ $liste->lastPage() }}</span>
                    </li>

                    {{-- Bouton "Suivant" --}}
                    @if ($liste->hasMorePages())
                        <li class="page-item">
                            <a class="page-link btn btn-outline-primary" href="{{ $liste->nextPageUrl() }}" rel="next">Suivant &raquo;</a>
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

    <div class="col-md-3">
        <div class="card card_default">
            <div class="card-header">
                <h2>Montant des travaux Maison</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Type_maison</th>
                        <th>Montant</th>
                    </thead>
                    <tbody>
                        @foreach ($montant as $maison)
                            <tr>
                                <td>{{$maison->nom}}</td>
                                <td>{{$maison->montant_total}} Ar</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
