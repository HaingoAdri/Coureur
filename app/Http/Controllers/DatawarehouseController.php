<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coureur;

class DatawarehouseController extends Controller
{
    public function transferAndInsertCoureur()
    {

        $equipe = Equipe::on('pgsql')->get();

        $coureurs = Coureur::on('pgsql')->get();
        foreach ($coureurs as $coureur) {
            DB::connection('pgsql_warehouse')->statement('CALL inserer_coureur(?, ?, ?, ?, ?)', [
                $coureur->nom,
                $coureur->numero_dossard,
                $coureur->genre,
                $coureur->date_naissance,
                $coureur->equipe,
            ]);
        }
        $coureursWarehouse = DB::connection('pgsql_warehouse')->table('Coureur')->get();
        return view('coureurs.index', compact('coureursWarehouse'));
    }
}
