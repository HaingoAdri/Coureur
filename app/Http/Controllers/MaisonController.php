<?php

namespace App\Http\Controllers;

use App\Helper\Services;
use App\Models\Categorie;
use App\Models\Coureur;
use App\Models\Equipe;
use App\Models\Etape;
use App\Models\Maison_data;
use App\Models\Maison_travaux;
use App\Models\Participation;
use App\Models\Points;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Type\Time;

class MaisonController extends Controller
{
    public function index(){
        $admin = true;
        $client = false;
        Session::put('client_page',$client);
        Session::put('admin_page',$admin);
        $liste = Equipe::all();
        $liste_categorie = Categorie::all();
        return view("admin",compact('liste','liste_categorie'));
    }

    public function etape_points(){
        $liste_etape = Etape::all();
        $liste_points = Points::all();
        return view("etape_points", compact('liste_points','liste_etape'));
    }

    public function coureur_liste(){
        $liste_coureur = (new Coureur())->getCoureur();
        return view("equipe_details",compact('liste_coureur'));
    }

    public function insert_etape(Request $request){
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        for($i = 1; $i<count($fileContents); $i++){
            $data = str_getcsv($fileContents[$i], ',');
            $id = $data[3];
            $nom = $data[0];
            $longueur = str_replace(',', '.', $data[1]);
            $coureur = $data[2];
            $rang = $data[3];
            $date_depart = $data[4];
            $heure_depart = $data[5];

            Etape::updateOrCreate([
                'id' => $id,
                'nom' => $nom,
                'longueur_km' => $longueur,
                'coureurs_par_equipe' => $coureur,
                'rang_etape' => $rang,
                'date_depart' => $date_depart,
                'heure_depart' => $heure_depart,
            ]);
        }
        return redirect()->back();
    }

    public function insert_points(Request $request){
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        for($i = 1; $i<count($fileContents); $i++){
            $data = str_getcsv($fileContents[$i], ',');
            $classement = $data[0];
            $points = $data[1];

            Points::updateOrCreate([
                'classement' => $classement,
                'points' => $points,
            ]);
        }
        return redirect()->back();
    }

    public function insert_participation(Request $request){
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        for($i = 1; $i<count($fileContents); $i++){
            $data = str_getcsv($fileContents[$i], ',');
            $rang = $data[0];
            $dossard = $data[1];
            $nom = $data[2];
            $genre = $data[3];
            $naissance = $data[4];
            $equipe = $data[5];
            $arrive = Carbon::createFromFormat('d/m/Y H:i:s', $data[6]);
            $date_arrivee = $arrive->format('d/m/Y');
            $heure_arrivee = $arrive->format('H:i:s');
            $penalite = "00:00:00";
            $id_equipe = Equipe::updateOrCreate([
                'nom' => $equipe,
                'login' => $equipe,
                'mot_de_passe' => '123456'
            ])->id;
            $heure_depart = Etape::where('rang_etape',$rang)->get();
            $heure_depart_dep = $heure_depart[0]->heure_depart;
            $id_joueur = Coureur::updateOrCreate([
                'nom' => $nom,
                'numero_dossard' => $dossard,
                'genre' => $genre,
                'date_naissance' => $naissance,
                'equipe' => $id_equipe
            ])->id;

            $sql = "insert into participation(id_etape,id_coureur,id_equipe,heure_depart,heure_arrivee,date_arrivee,penalty_time,created_at,updated_at) values ($rang,$id_joueur,$id_equipe,'$heure_depart_dep','$heure_arrivee','$date_arrivee','$penalite',now(),now())";
            DB::insert($sql);
        }
        return redirect()->back();
    }

    public function genererCategories(Request $request)
    {
        $categories = DB::table('categorie')->get();
        $coureurs = DB::table('coureur')->get();
        foreach ($coureurs as $coureur) {
            $age = Carbon::now()->diffInYears($coureur->date_naissance);
            if ($coureur->genre == "F") {
                DB::table('categorie_joueur')->insert([
                    'id_coureur' => $coureur->id,
                    'id_categorie' => $categories[1]->id,
                ]);
            }
            else {
                DB::table('categorie_joueur')->insert([
                    'id_coureur' => $coureur->id,
                    'id_categorie' => $categories[0]->id,
                ]);
            }
            if ($age < 18) {
                DB::table('categorie_joueur')->insert([
                    'id_coureur' => $coureur->id,
                    'id_categorie' => $categories[2]->id,
                ]);
            }
            else{
                DB::table('categorie_joueur')->insert([
                    'id_coureur' => $coureur->id,
                    'id_categorie' => $categories[3]->id,
                ]);
            }
        }
        return redirect()->back();
    }

    // page pour entrer le temps
    public function liste_participation(){
        $etape = DB::table('etape')->get();
        $equipe = DB::table('equipe')->get();
        $participants = DB::select("select nom_equipe, nom ,penalite, id, id_etape, id_equipe, rang_etape from vie_penalite");
        $etapes = [];
        foreach ($participants as $participant) {
            $etapes[$participant->rang_etape][] = $participant;
        }
        return view('participation_temp', ['etapes' => $etapes, 'etapes_un' => $etape, 'equipe' => $equipe]);
    }

    // voir le classement
    public function liste_details_participation(){
        $resultat_categorie = DB::table('view_categorie_classement')->orderBy('rang')->get();
        $result = [];
        foreach($resultat_categorie as $r){
            $result[$r->nom_categorie][] = $r;
        }
        $resultat_equipe = DB::select("select * from view_equipe_classement order by rang asc");
        return view('classement', ['resultat' => $resultat_equipe, 'resultat_categorie' => $result]);
    }

    public function liste_classement_etape_coureur(){
        $participants = DB::select("select * , ( EXTRACT(EPOCH FROM (heure_final - date_depart)) +
        EXTRACT(EPOCH FROM penalty_time)) as chrono_final , (chrono_tonga)+penalty_time as heure_chrono , EXTRACT(EPOCH FROM (heure_final - date_depart)) as chrono from view_classement order by rang, rang_etape asc");
        $etapes = [];
        foreach ($participants as $participant) {
            $etapes[$participant->id_etape][] = $participant;
        }
        return view('classement_etape_coureur', ['etapes' => $etapes]);
    }

    public function liste_classement_etape_equipe(){
        $classement = DB::table('classement_equipe')->get();
        $class = [];
        foreach($classement as $cl){
            $class[$cl->rang_etape][] = $cl;
        }
        return view('classement_etape_equipe', ['class'=>$class]);
    }

    public function liste_classement_etape_categorie(){
        $participants = DB::select("select * from view_classement order by rang asc");
        $categories = [];
        $classement_categorie = DB::select("select * from view_classement_categorie_etape order by nom_categorie, rang_etape asc");
        $etapes = [];
        foreach ($participants as $participant) {
            $etapes[$participant->id_etape][] = $participant;
        }
        foreach($classement_categorie as $cat){
            $categories[$cat->id_etape][$cat->nom_categorie][] = $cat;
        }
        return view('classement_etape_categorie', ['etapes' => $etapes,'categories' => $categories]);
    }

    public function delete($id,$equipe,$etape){
        $sql = DB::select("select penalite from penalite where id = $id");
        $s = $sql[0]->penalite;
        $pen = DB::select("select sum(penalite) - '$s' as penalite from penalite where id_equipe = $equipe  and id_etape = $etape");
        $somme = $pen[0]->penalite;
        $request = "update participation set penalty_time = '$somme' where id_equipe = $equipe and id_etape = $etape";
        DB::update($request);
        DB::delete("delete from penalite where id = $id");
        return redirect()->back();
    }

    // classement par equipe
    public function liste_details_participation_parequipe($equipe){
        $resultat_categorie = DB::table('view_categorie_classement')->where('nom_equipe',$equipe)->orderBy('rang')->get();
        $result = [];
        foreach($resultat_categorie as $r){
            $result[$r->nom_categorie][] = $r;
        }
        $resultat_equipe = DB::select("select * from view_equipe_classement where nom_equipe = '$equipe' order by rang asc");
        return view('classement_equipe', ['resultat' => $resultat_equipe, 'resultat_categorie' => $result, 'equipe'=>$equipe]);
    }

    public function liste_classement_etape_coureur_parequipe($equipe){
        $participants = DB::table('view_classement')->where('nom_equipe',$equipe)->orderBy('rang_etape','asc')->orderBy('rang','asc')->get();
        $etapes = [];
        foreach ($participants as $participant) {
            $etapes[$participant->id_etape][] = $participant;
        }
        return view('classement_etape_coureur_parequipe', ['etapes' => $etapes, 'equipe' => $equipe]);
    }

    public function liste_classement_etape_equipe_parequipe($equipe){
        $classement = DB::table('classement_equipe')->where('nom_equipe',$equipe)->get();
        $class = [];
        foreach($classement as $cl){
            $class[$cl->rang_etape][] = $cl;
        }
        return view('classement_etape_equipe_parequipe', ['class'=>$class, 'equipe' => $equipe]);
    }

    public function liste_classement_etape_categorie_parequipe($equipe){
        $participants = DB::table('view_classement')->where('nom_equipe',$equipe)->orderBy('rang')->get();
        $categories = [];
        $classement_categorie = DB::select("select * from view_classement_categorie_etape where nom_equipe = '$equipe' order by rang_etape asc");
        $etapes = [];
        foreach ($participants as $participant) {
            $etapes[$participant->id_etape][] = $participant;
        }
        foreach($classement_categorie as $cat){
            $categories[$cat->id_etape][$cat->nom_categorie][] = $cat;
        }
        return view('classement_etape_categorie_parequipe', ['etapes' => $etapes,'categories' => $categories, 'equipe' => $equipe]);
    }


    // modifier temps
    public function saveParticipation(Request $request)
    {
        $equipe = $request->input('equipe');
        $etape = $request->input('etape');
        $penalite = $request->input('time_es');

        $insert_penalite = "insert into penalite values ($equipe, $etape, '$penalite')";
        DB::insert($insert_penalite);

        $sql_somme = "select sum(penalite) as penalite from penalite where id_equipe = $equipe  and id_etape = $etape";
        $somme_penalite = DB::select($sql_somme);
        $somme = $somme_penalite[0]->penalite;
        $request = "update participation set penalty_time = '$somme' where id_etape = $etape and id_equipe = $equipe";
        // var_dump($request);
        DB::update($request);
        return redirect()->back();
    }

    public function afficher_graphe_classement(){
        $classement = DB::table('view_equipe_classement')->get();
        $resultat_categorie = DB::table('view_categorie_classement')->orderBy('rang')->get();
        $result = [];
        foreach($resultat_categorie as $r){
            $result[$r->nom_categorie][] = $r;
        }
        return view('graphe_classement', compact("classement","result"));
    }

    public function pdf_gagnant(){
        $select = DB::select("select * from  view_equipe_classement where rang = 1");
        $course = DB::select("select * from course limit 1");
        return view('pdf_certificat', compact("select", "course"));
    }

    public function pdf_gagnant_categorie($equipe,$cat,$totals){
        $course = DB::select("select * from course limit 1");
        return view('pdf_categorie', compact("equipe", "course","cat","totals"));
    }

    // initialiser donner
    public function truncateMaison(){
        $nom_table = ["equipe","etape","coureur","participation",'categorie_joueur','points','penalite'];
        foreach($nom_table as $nom){
            (new Services())->initisalisation_table($nom);
        }
        return redirect()->back();
    }
}
