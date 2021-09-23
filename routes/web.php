<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::get('article', function(){
    return view('article.index');
})->name('article.list');
