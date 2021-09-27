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

Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('settings/render/{page}', [SettingsController::class, 'render'])->name('settings.render');
Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');
