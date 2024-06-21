@extends("import_maison_data")
@section("contenu")
<div class="row pt-3">
    <div class="col-9">
        <div class="row">
            <h2 class="pb-2 border-bottom">Choisir votre batiment</h2>
            @foreach ($liste as $maison)
                <div class="col-4 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{$maison->nom}}</h2>
                        </div>
                        <div class="card-body">
                            <p>Description :{{$maison->descriptions}}</p>
                            <p>Surface: {{$maison->surface}}</p>
                        </div>
                        <div class="card-footer">
                            <p>Duree :{{$maison->duree}} Jour</p>
                            <input type="checkbox" name="maison" id="" class="form-check">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <h2 class="pb-2 border-bottom">Choisir votre type de finition</h2>
            @foreach ($liste_finition as $maison)
                <div class="col-3 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{$maison->nom}}</h2>
                        </div>
                        <div class="card-body">
                            <p>Un paiement supplémentaire se fera pour chaque finition.</p>
                            <p>Le prix total de la maison augmentera de "x%" en fonction de choix</p>
                            <p>Pourcentage: {{$maison->pourcentage}} %</p>
                        </div>
                        <div class="card-footer">
                            <input type="checkbox" name="maison" id="" class="form-check">
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
    </div>
    <div class="col-3">
        <h2 class="pb-2 border-bottom">Créer votre devis</h2>
        <div class="card">
            <div class="card-header">
                <h2>Entrer votre devis</h2>
            </div>
            <div class="card-body">
                <div class="pt-2">
                    <label for="">Lieu</label>
                    <input type="text" name="lieu" class="form-control">
                </div>
                <div class="pt-2">
                    <label for="">Date de construction</label>
                    <input type="text" name="date" class="form-control">
                </div>
                <div class="pt-2">
                    <label for="">Combien de tranche de paiement</label>
                    <input type="number" name="date" class="form-control">
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-danger" value="Faire devis">
            </div>
        </div>
    </div>

    </div>
</div>
@endsection
