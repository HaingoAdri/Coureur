<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaisonController;

// login client
Route::get('/login', [AdminController::class, 'go_login'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/register', [AdminController::class, 'go_register'])->name('register');
Route::post('/auth_admin', [AdminController::class, 'get_admin'])->name('auth_admin');
Route::post('/insert_admin', [AdminController::class, 'insert_admin'])->name('insert_admin');
Route::get('/acceuil_admin', [MaisonController::class, 'index'])->name("defaut");
Route::post('/import_maison_data', [MaisonController::class, 'import_maison_data'])->name('import_maison_data');
Route::get('/initialize_table', [MaisonController::class, 'truncateMaison'])->name('initialize');
Route::get('/', [ClientController::class, 'get_Client_Choice'])->name('choix');
Route::post('/import_Client', [ClientController::class, 'import_client'])->name('import_Client');
Route::post('/import_paiement', [ClientController::class, 'do_paiement'])->name('import_paiement');
