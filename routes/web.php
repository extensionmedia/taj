<?php

use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('produit', [ProduitController::class, 'index'])->name('produit.list');
Route::get('produit/edit/{produit}', [ProduitController::class, 'edit'])->name('produit.edit');

Route::get('produit/search', [ProduitController::class, 'search'])->name('produit.search');
