<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Devis_client;
use App\Models\Finition;
use App\Models\Maison_data;
use App\Models\Paiements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function import_client(Request $request){

        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        for($i = 1; $i<count($fileContents); $i++){
            $data = str_getcsv($fileContents[$i], ',');
            $client = $data[0];
            $devis = $data[1];
            $maison = $data[2];
            $finition = $data[3];
            $type_finition = floatval(str_replace(',', '.', $data[4]));
            $date_devis = $data[5];
            $date_debut = $data[6];
            $lieu = $data[7];

            $idFinition = Finition::updateOrCreate([
                'nom' => $finition,
                'pourcentage' => $type_finition,
            ])->id;

            $idMaison = Maison_data::where('nom','like','%'.$maison.'%')->get();

            Client::updateOrCreate([
                'id'=>$client
            ]);

            Devis_client::updateOrCreate([
                'id' => $devis,
                'numero' => $client,
                'date_devis' => $date_devis,
                'date_debut' => $date_debut,
                'maison_data' =>$idMaison[0]->id,
                'finition' => $idFinition,
                'lieu' => $lieu
            ]);

        }
        return redirect()->back();
    }

    public function get_Client_Choice(){
        $client = true;
        $admin = false;
        Session::put('client_page',$client);
        Session::put('admin_page',$admin);
        $liste = Maison_data::all();
        $liste_finition = Finition::all();
        return view("client",compact("liste","liste_finition"));
    }

    public function do_paiement(Request $request){
        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        for($i = 1; $i<count($fileContents); $i++){
            $data = str_getcsv($fileContents[$i], ',');
            $devis = $data[0];
            $paiement = $data[1];
            $date = $data[2];
            $montant = $data[3];
            $ids = (new Devis_client())->getDevis_Id($devis);

            Paiements::create([
                'id'=>$paiement,
                'devis_client'=>$devis,
                'date_paiement'=>$date,
                'montant'=>$montant
            ]);

            var_dump($data);
            // return redirect()->back();
        }
    }
}
