<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// PublicController
Route::get('/', [PublicController::class, 'home'])->name('home');

// ProductController
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create')->middleware('auth');
Route::post('/product/store', [ProductController::class, 'store'] )->name('product.store')->middleware('auth');
Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');

// ArticleController

Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create')->middleware('auth');
Route::post('/article/store', [ArticleController::class, 'store'])->name('article.store')->middleware('auth');

Route::get('/article/index', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/show/{article}', [ArticleController::class, 'show'])->name('article.show'); 
// Rotta parametrica a cui passo il parametro article - ce lo permette Laravel, teoricamente si passerebbe "id"

Route::get('/article/edit/{article}', [ArticleController::class, 'edit'])->name('article.edit')->middleware('auth');
// Rotta parametrica a cui passo il parametro article - ce lo permette Laravel, teoricamente si passerebbe "id"
Route::put('/article/update/{article}', [ArticleController::class, 'update'])->name('article.update')->middleware('auth');
Route::delete('/article/destroy/{article}', [ArticleController::class, 'destroy'])->name('article.destroy')->middleware('auth');


