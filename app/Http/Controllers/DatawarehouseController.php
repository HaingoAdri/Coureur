<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coureur;
use App\Models\Equipe;
use Carbon\Carbon;

class DatawarehouseController extends Controller
{
    public function index(){
        $coureursWarehouse = DB::connection('pgsql_warehouse')->table('coureur')->get();
        foreach ($coureursWarehouse as $coureur) {
            $coureur->age = Carbon::parse($coureur->date_naissance)->age;
        }
        return view('coureur', compact('coureursWarehouse'));
    }

    public function transferAndInsertCoureur()
    {

        $equipes = Equipe::on('pgsql')->get();

        foreach ($equipes as $equipe) {
            $equipeExiste = DB::connection('pgsql_warehouse')
                              ->table('equipe')
                              ->where('nom', $equipe->nom)
                              ->where('login', $equipe->login)
                              ->exists();

            if (!$equipeExiste) {
                DB::connection('pgsql_warehouse')->statement('CALL inserer_equipe(?,?, ?, ?)', [
                    $equipe->id,
                    $equipe->nom,
                    $equipe->login,
                    $equipe->mot_de_passe,
                ]);
            }
        }

        $coureurs = Coureur::on('pgsql')->get();

        foreach ($coureurs as $coureur) {
            $coureurExiste = DB::connection('pgsql_warehouse')
                                ->table('coureur')
                                ->where('nom', $coureur->nom)
                                ->where('numero_dossard', $coureur->numero_dossard)
                                ->exists();

            if (!$coureurExiste) {
                DB::connection('pgsql_warehouse')->statement('CALL inserer_coureur(?, ?, ?, ?, ?, ?)', [
                    $coureur->id,
                    $coureur->nom,
                    $coureur->numero_dossard,
                    $coureur->genre,
                    $coureur->date_naissance,
                    $coureur->equipe,
                ]);
            }
        }
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $resultats = DB::connection('pgsql_warehouse')
                        ->table('coureur')
                        ->where(function ($query) use ($search) {
                            $query->where('nom', 'like', '%'.$search.'%')
                                  ->orWhereExists(function ($subQuery) use ($search) {
                                      $subQuery->select(DB::raw(1))
                                               ->from('equipe')
                                               ->whereRaw('coureur.equipe = equipe.id')
                                               ->where('equipe.nom', 'like', '%'.$search.'%');
                                  });
                        })
                        ->get();

        return view('coureurs.index', compact('resultats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'numero_dossard' => 'required|integer',
            'genre' => 'required|string|max:10',
            'date_naissance' => 'required|date',
            'equipe' => 'required|string|max:255',
        ]);
        $coureur = Coureur::on('pgsql_warehouse')->findOrFail($id);
        $coureur->nom = $request->nom;
        $coureur->numero_dossard = $request->numero_dossard;
        $coureur->genre = $request->genre;
        $coureur->date_naissance = $request->date_naissance;
        $coureur->equipe = $request->equipe;
        $coureur->save();
        DB::connection('pgsql_warehouse')->statement('UPDATE coureur SET updated_at = NOW() WHERE id = ?', [$id]);
        return redirect()->route('transfer-and-insert')->with('success', 'Coureur mis à jour avec succès.');
    }

    public function edit($id)
    {
        $coureur = Coureur::findOrFail($id);
        return view('edit', compact('coureur'));
    }
}
