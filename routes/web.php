<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/registros', function () {
    return view('registros');
})->name('registros');
// Route::post('/iniciarSesion',[App\Http\Controllers\loginController::class, 'iniciar_sesion'])->name('iniciarSesion');
// Route::post('/guardarFactura',[App\Http\Controllers\facturaController::class, 'guardarFactura'])->name('guardarFactura');
// Route::get('/tok',[App\Http\Controllers\FacturaController::class, 'ultimoToken'])->name('tok');

Route::get('/token',[App\Http\Controllers\TokenController::class, 'index'])->name('tokens');
Route::post('/guardartoken',[App\Http\Controllers\TokenController::class, 'guardartoken'])->name('guardartoken');

Route::get('/emisores',[App\Http\Controllers\EmisorController::class, 'index'])->name('emisores');
Route::post('/guardaremisor',[App\Http\Controllers\EmisorController::class, 'storeEm'])->name('storeEm');
Route::post('/modificaremisor',[App\Http\Controllers\EmisorController::class, 'modificar_emisor'])->name('modificar_emisor');
Route::post('/eliminaremisor',[App\Http\Controllers\EmisorController::class, 'eliminar_emisor'])->name('eliminar_emisor');
Route::post('/buscaremisor/{id}',[App\Http\Controllers\EmisorController::class, 'obtenerEmisor'])->name('buscaremisor');

Route::get('/receptores',[App\Http\Controllers\ReceptorController::class, 'index'])->name('receptores');
Route::post('/guardarreceptor',[App\Http\Controllers\ReceptorController::class, 'storeRe'])->name('storeRe');
Route::post('/modificarreceptor',[App\Http\Controllers\ReceptorController::class, 'modificar_receptor'])->name('modificar_receptor');
Route::post('/eliminarreceptor',[App\Http\Controllers\ReceptorController::class, 'eliminar_receptor'])->name('eliminarreceptor');
Route::post('/buscareceptor/{id}',[App\Http\Controllers\ReceptorController::class, 'obetenerReceptor'])->name('buscareceptor');

Route::get('/documentos',[App\Http\Controllers\DocumentosController::class, 'index'])->name('documentos');
Route::get('/obtenerpdf/{codGeneracion}',[App\Http\Controllers\DocumentosController::class, 'obtenerPdf'])->name('obtenerpdf');

Route::get('/eInvalidacion',[App\Http\Controllers\EventosController::class, 'listaEInvalidacion'])->name('eInvalidacion');
Route::get('/eContingencia',[App\Http\Controllers\EventosController::class, 'listaEContingencia'])->name('eContingencia');
Route::get('/nuevoEContingencia',[App\Http\Controllers\EventosController::class, 'nuevoEContingencia'])->name('nuevoEContingencia');


Route::get('/facturacion',[App\Http\Controllers\FacturaController::class, 'registro'])->name('facturacion');

Route::get('/registro', function () {
    return view('registro');
})->name('registro');

// Route::post('createusuario', [App\Http\Controllers\loginController::class,'registro'])->name('createusuario');
// Route::get('login', [App\Http\Controllers\loginController::class,'iniciar'])->name('login');
// Route::get('hoja', [App\Http\Controllers\loginController::class,'pruebas'])->name('hoja');

