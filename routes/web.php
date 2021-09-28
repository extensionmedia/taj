<?php

use App\Http\Controllers\ProduitCategoryController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('produit', [ProduitController::class, 'index'])->name('produit.list');
Route::get('produit/edit/{produit}', [ProduitController::class, 'edit'])->name('produit.edit');

Route::get('produit/search', [ProduitController::class, 'search'])->name('produit.search');
Route::get('produit_category/search', [ProduitCategoryController::class, 'search'])->name('produit_category.search');
Route::get('produit_category/create', [ProduitCategoryController::class, 'create'])->name('produit_category.create');
Route::get('produit_category/edit/{produitCategory}', [ProduitCategoryController::class, 'edit'])->name('produit_category.edit');
Route::post('produit_category/store', [ProduitCategoryController::class, 'store'])->name('produit_category.store');
Route::put('produit_category/update/{produitCategory}', [ProduitCategoryController::class, 'update'])->name('produit_category.update');
Route::delete('produit_category/delete/{produitCategory}', [ProduitCategoryController::class, 'destroy'])->name('produit_category.delete');
Route::get('produit_category/exists/{produit_category}', [ProduitCategoryController::class, 'isExists'])->name('produit_category.exists');

Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('settings/render/{page}', [SettingsController::class, 'render'])->name('settings.render');
Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');
