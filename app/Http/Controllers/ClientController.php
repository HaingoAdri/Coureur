<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Coureur;
use App\Models\Devis_client;
use App\Models\Equipe;
use App\Models\Etape;
use App\Models\Finition;
use App\Models\Maison_data;
use App\Models\Paiements;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function login_client(){
        return view('login_client');
    }

    public function get_client(Request $request){
        $admin = false;
        $client = true;
        Session::put('client_page',$client);
        Session::put('admin_page', $admin);
        Session::put('client',$client);
        $email = $request->input('equipe');
        $pass = $request->input('pass');
        $admin = Equipe::where('login',$email)
                ->where('mot_de_passe',$pass)
                ->get();
        Session::put('equipe',$admin);
        return redirect()->route('show_equipe');
    }

    public function acceuil(){
        $id = Session::get('equipe')[0]->id;
        $equipe = Session::get('equipe')[0]->nom;
        $liste_joueur = (new Coureur())->getCoureur_Equipe($id);
        $liste_cour = DB::select("select distinct *, (heure_final-date_depart)+penalty_time as total from view_getChrono where nom_equipe = '$equipe'");
        $tables = [];
        foreach($liste_cour as $participation){
            $tables[$participation->id_etape][] = $participation;
        }
        $liste_etape = Etape::all();
        return view("client",compact('equipe','liste_joueur','liste_etape','id','tables'));
    }

    public function liste_details_participation_parequipe(){
        $equipe = Session::get('equipe')[0]->nom;
        $resultat_categorie = DB::table('view_categorie_classement')->where('nom_equipe',$equipe)->orderBy('rang')->get();
        $result = [];
        foreach($resultat_categorie as $r){
            $result[$r->nom_categorie][] = $r;
        }
        $resultat_equipe = DB::select("select * from view_equipe_classement where nom_equipe = '$equipe' order by rang asc");
        return view('classement_equipe', ['resultat' => $resultat_equipe, 'resultat_categorie' => $result, 'equipe'=>$equipe]);
    }

    public function get_participation(Request $request){
        $coureurIds = $request->input('coureur_id');
        $equipeIds = $request->input('equipe_id');
        $equipe_nom = $request->input('equipe_nom');
        $check = $request->input('etape');
        $nbr = $request->input('nbr');
        $num = $request->input('numero_etape');
        foreach($check as $index => $c){
            $coureurIds = $request->input('coureur_id_'.$c);
            $nbr_actuelle = DB::select("select count(*) from pview_participation where nom_equipe = '$equipe_nom' and id_etape = $num ");
            $reste = count($check) - $nbr_actuelle[0]->count;
            $coureurIds[$index];
            var_dump($coureurIds[$index]);
            if(count($check) < $nbr_actuelle[0]->count){
                $id = Participation::create([
                    'id_etape' => $num,
                    'id_coureur' => $coureurIds[$index],
                    'id_equipe' => $equipeIds
                ])->get();
                return redirect()->back();
            }else{
                return redirect()->back()->with('error','Ajouter juste '.$reste.' coureur pour cette étape et pas plus.');
            }
        }
    }

    public function show(){
        $equipe = Session::get('equipe')[0]->id;
        $equipe_nom = Session::get('equipe')[0]->nom;
        $participation = (new Participation())->get_participation($equipe_nom);
        return view('participation',compact('participation','equipe_nom'));
    }

    public function logout(Request $request){
        $request->session()->forget('client');
        $request->session()->forget('equipe');
        return redirect()->route('login_client');
    }
}
