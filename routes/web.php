<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaisonController;
use App\Models\Client;

// login et inscription
Route::get('/login', [AdminController::class, 'go_login'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/register', [AdminController::class, 'go_register'])->name('register');
Route::post('/auth_admin', [AdminController::class, 'get_admin'])->name('auth_admin');
Route::post('/insert_admin', [AdminController::class, 'insert_admin'])->name('insert_admin');

// page acceuil
Route::get('/acceuil_admin', [MaisonController::class, 'index'])->name("defaut");
Route::get('/etape_points', [MaisonController::class, 'etape_points'])->name("etape_points");
Route::get('/coureur_liste', [MaisonController::class, 'coureur_liste'])->name("coureur_liste");

// importation de donnees
Route::post('/import_equipe', [MaisonController::class, 'insert_equipe'])->name('import_equipe');
Route::post('/import_coureur', [MaisonController::class, 'insert_coureur'])->name('import_coureur');
Route::post('/import_etape', [MaisonController::class, 'insert_etape'])->name('import_etape');
Route::post('/import_categorie', [MaisonController::class, 'insert_categorie'])->name('import_categorie');
Route::post('/import_participation', [MaisonController::class, 'insert_participation'])->name('import_participation');
Route::post('/import_points', [MaisonController::class, 'insert_points'])->name('import_points');

// generation de categorie
Route::post('/generer-categories', [MaisonController::class, 'genererCategories'])->name('generer_categories');

// initialisation de la base
Route::get('/initialize_table', [MaisonController::class, 'truncateMaison'])->name('initialize');

// ajout de temps dans la participation
Route::get('/participation', [MaisonController::class, 'liste_participation'])->name('participation');

// classement
Route::get('/classement_etape_categorie', [MaisonController::class, 'liste_classement_etape_categorie'])->name('classement_etape_categorie');
Route::get('/classement_etape_coureur', [MaisonController::class, 'liste_classement_etape_coureur'])->name('classement_etape_coureur');
Route::get('/classement_etape_equipe', [MaisonController::class, 'liste_classement_etape_equipe'])->name('classement_etape_equipe');

// classement par equipe wher equipe = ?
Route::get('/classement_equipe/{equipe}', [MaisonController::class, 'liste_details_participation_parequipe'])->name('classement_equipe_admin');
Route::get('/classement_etape_categorie_equipe/{equipe}', [MaisonController::class, 'liste_classement_etape_categorie_parequipe'])->name('classement_etape_categorie_equipe');
Route::get('/classement_etape_coureur_equipe/{equipe}', [MaisonController::class, 'liste_classement_etape_coureur_parequipe'])->name('classement_etape_coureur_equipe');
Route::get('/classement_etape_equipe_equipe/{equipe}', [MaisonController::class, 'liste_classement_etape_equipe_parequipe'])->name('classement_etape_equipe_equipe');

// classement général
Route::get('/details_participation', [MaisonController::class, 'liste_details_participation'])->name('details_participation');
Route::get('/graphe', [MaisonController::class, 'afficher_graphe_classement'])->name('graphe');
Route::get('/pdf', [MaisonController::class, 'pdf_gagnant'])->name('pdf');
Route::get('/pdf_categorie/{equipe}/{cat}/{totals}', [MaisonController::class, 'pdf_gagnant_categorie'])->name('pdf_categorie');

// effacer penalite
Route::delete('penalite/{id}/{equipe}/{etape}', [MaisonController::class, 'delete'])->name('delete_penalite');

// ajouter temps et penalite
Route::post('/save_participation', [MaisonController::class, 'saveParticipation'])->name('save_participation');
Route::get('/', [ClientController::class, 'login_client'])->name('login_client');
Route::get('/show_equipe', [ClientController::class, 'acceuil'])->name('show_equipe');
Route::post('/acceuil_client', [ClientController::class, 'get_client'])->name('acceuil_client');
Route::post('/insert_participation', [ClientController::class, 'get_participation'])->name('insert_participation');
Route::get('/equipe/participation', [ClientController::class, 'show'])->name('equipe_participation');
Route::get('/classement_equipe', [ClientController::class, 'liste_details_participation_parequipe'])->name('classement_equipe');
Route::post('/import_Client', [ClientController::class, 'import_client'])->name('import_Client');
Route::post('/import_paiement', [ClientController::class, 'do_paiement'])->name('import_paiement');
Route::get('/logout_client', [ClientController::class, 'logout'])->name('logout_client');
