<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\basketController;
use App\Http\Controllers\ordersController;



Route::get('/urunekle', [productController::class, 'ekle']);
Route::get('/kategoriekle', [categoryController::class, 'ekle']);
Route::get('/musteriekle', [customerController::class, 'ekle']);

Route::get('/sepetekle/{product}', [basketController::class, 'ekle']);
Route::get('/sepetsil/{product}', [basketController::class, 'sil']);
Route::get('/sepetlistele', [basketController::class, 'listele']);

Route::get('/emirler', [ordersController::class, '__construct']);
