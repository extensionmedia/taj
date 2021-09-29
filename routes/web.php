<?php

use App\Http\Controllers\ProduitCategoryController;
use App\Http\Controllers\ProduitColorController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProduitMarqueController;
use App\Http\Controllers\ProduitStatusController;
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

Route::get('produit_marque/search', [ProduitMarqueController::class, 'search'])->name('produit_marque.search');
Route::get('produit_marque/create', [ProduitMarqueController::class, 'create'])->name('produit_marque.create');
Route::get('produit_marque/edit/{produitMarque}', [ProduitMarqueController::class, 'edit'])->name('produit_marque.edit');
Route::post('produit_marque/store', [ProduitMarqueController::class, 'store'])->name('produit_marque.store');
Route::put('produit_marque/update/{produitMarque}', [ProduitMarqueController::class, 'update'])->name('produit_marque.update');
Route::delete('produit_marque/delete/{produitMarque}', [ProduitMarqueController::class, 'destroy'])->name('produit_marque.delete');
Route::get('produit_marque/exists/{produit_marque}', [ProduitMarqueController ::class, 'isExists'])->name('produit_marque.exists');

Route::get('produit_color/search', [ProduitColorController::class, 'search'])->name('produit_color.search');
Route::get('produit_color/create', [ProduitColorController::class, 'create'])->name('produit_color.create');
Route::get('produit_color/edit/{produitColor}', [ProduitColorController::class, 'edit'])->name('produit_color.edit');
Route::post('produit_color/store', [ProduitColorController::class, 'store'])->name('produit_color.store');
Route::put('produit_color/update/{produitColor}', [ProduitColorController::class, 'update'])->name('produit_color.update');
Route::delete('produit_color/delete/{produitColor}', [ProduitColorController::class, 'destroy'])->name('produit_color.delete');
Route::get('produit_color/exists/{produit_color}', [ProduitColorController ::class, 'isExists'])->name('produit_color.exists');

Route::get('produit_status/search', [ProduitStatusController::class, 'search'])->name('produit_status.search');
Route::get('produit_status/create', [ProduitStatusController::class, 'create'])->name('produit_status.create');
Route::get('produit_status/edit/{produitStatus}', [ProduitStatusController::class, 'edit'])->name('produit_status.edit');
Route::post('produit_status/store', [ProduitStatusController::class, 'store'])->name('produit_status.store');
Route::put('produit_status/update/{produitStatus}', [ProduitStatusController::class, 'update'])->name('produit_status.update');
Route::delete('produit_status/delete/{produitStatus}', [ProduitStatusController::class, 'destroy'])->name('produit_status.delete');
Route::get('produit_status/exists/{produit_status}', [ProduitStatusController ::class, 'isExists'])->name('produit_status.exists');


Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('settings/render/{page}', [SettingsController::class, 'render'])->name('settings.render');
Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');
