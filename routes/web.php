<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DepenseController;






Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth'])->resource('users', UserController::class);

Route::middleware(['auth'])->resource('clients', ClientController::class);

Route::middleware(['auth'])->resource('produits', ProduitController::class);

Route::middleware(['auth'])->resource('ligne_commandes', ClientController::class);

Route::middleware(['auth'])->resource('commandes', CommandeController::class);

Route::middleware(['auth'])->resource('depenses', DepenseController::class);


Route::middleware(['auth'])->get('/total_journalier', [CommandeController::class, 'totalJournalier'])->name('totalJournalier');

Route::middleware(['auth'])->get('/all_commandes', [CommandeController::class, 'all_commande'])->name('allCommande');

//Route::post('/depenses', [CommandeController::class, 'storeDepense'])->name('depenses');




Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::middleware(['auth'])->post('/logout', [LoginController::class, 'logout'])->name('logout');
