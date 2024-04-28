<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\EmisorController;
use App\Http\Controllers\ReceptorController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\EventosController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/sheet', [GoogleSheetController::class, 'index']);

Route::post('/store', [GoogleSheetController::class, 'storeForm'])->name('storeForm');

Route::get('/facturacion', [FacturaController::class, 'registro'])->name('facturacion');

Route::get('/tokens', [TokenController::class, 'index'])->name('tokens');

Route::get('/emisores', [EmisorController::class, 'index'])->name('emisores');

Route::get('/receptores', [ReceptorController::class, 'index'])->name('receptores');

Route::get('/documentos', [DocumentosController::class, 'index'])->name('documentos');

Route::get('/eInvalidacion', [EventosController::class, 'listaEInvalidacion'])->name('eInvalidacion');

Route::get('/eContingencia', [EventosController::class, 'listaEContingencia'])->name('eContingencia');

Route::get('/nuevoEContingencia', [EventosController::class, 'nuevoEContingencia'])->name('nuevoEContingencia');
