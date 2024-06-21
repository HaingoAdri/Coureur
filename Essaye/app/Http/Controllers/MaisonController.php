<?php

namespace App\Http\Controllers;

use App\Helper\Services;
use App\Models\Maison_data;
use App\Models\Maison_travaux;
use App\Models\Type_travaux;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MaisonController extends Controller
{
    public function index(){
        $admin = true;
        $client = false;
        Session::put('client_page',$client);
        Session::put('admin_page',$admin);
        $nbr = 10;
        $liste = (new Maison_travaux())->getMaison_travaux();
        $montant = (new Maison_travaux())->getMaison_montant();
        return view("admin", compact("liste","montant"));
    }

    public function import_maison_data(Request $request){

        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        for($i = 1; $i<count($fileContents); $i++){
            $data = str_getcsv($fileContents[$i], ',');
            $nom_maison = $data[0];
            $description = $data[1];
            $surface = $data[2];
            $duree = $data[8];
            $code_travaux = $data[3];
            $type_travaux = $data[4];
            $unite = $data[5];
            $prix_unitaire = str_replace(',', '.', $data[6]);
            $quantite = str_replace(',', '.', $data[7]);

            $idMaison_data = Maison_data::updateOrCreate([
                'nom' => $nom_maison,
                'descriptions' => $description,
                'surface' => $surface,
                'duree' => $duree,
            ])->id;

            $idTy_travaux = Type_travaux::updateOrCreate([
                'id' => $code_travaux,
                'nom' => $type_travaux,
                'unite' => $unite,
                'pu' => $prix_unitaire,
            ])->id;

            // var_dump($idTy_travaux);

            Maison_travaux::updateOrCreate([
                'maison_data' => $idMaison_data,
                'type_travaux' => $idTy_travaux,
                'quantite' => $quantite
            ]);
        }
        return redirect()->back();
    }

    public function truncateMaison(){
        $nom_table = ["maison_data","maison_travaux","type_travaux","devis_client","paiement"];
        foreach($nom_table as $nom){
            (new Services())->initisalisation_table($nom);
        }
        return redirect()->back();
    }
}
