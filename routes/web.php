<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registros', function () {
    return view('registros');
})->name('registros');

Route::get('/municipios/{idDepartamento}', [App\Http\Controllers\MunicipioController::class, 'getMunicipios'])->name('municipios');



// Route::post('/iniciarSesion',[App\Http\Controllers\loginController::class, 'iniciar_sesion'])->name('iniciarSesion');
Route::post('/guardarFactura',[App\Http\Controllers\facturaController::class, 'guardarFactura'])->name('guardarFactura');
Route::get('/tok',[App\Http\Controllers\FacturaController::class, 'lastToken'])->name('tok');

Route::get('/tokens',[App\Http\Controllers\TokenController::class, 'index'])->name('token');
Route::post('/guardartoken',[App\Http\Controllers\TokenController::class, 'guardartoken'])->name('guardartoken');

Route::get('/emisor',[App\Http\Controllers\EmisorController::class, 'index'])->name('emisor');
Route::post('/guardaremisor',[App\Http\Controllers\EmisorController::class, 'storeEm'])->name('storeEm');
Route::put('/modificaremisor',[App\Http\Controllers\EmisorController::class, 'modificar_emisor'])->name('modificar_emisor');
Route::post('/eliminaremisor',[App\Http\Controllers\EmisorController::class, 'eliminar_emisor'])->name('eliminar_emisor');
// Route::post('/buscaremisor/{id}',[App\Http\Controllers\EmisorController::class, 'obtenerEmisor'])->name('buscaremisor');
// Route::get('/emisores/{id}', [App\Http\Controllers\FacturaController::class, 'obtenerEmisor']);

Route::get('/receptor',[App\Http\Controllers\ReceptorController::class, 'index'])->name('receptor');
Route::post('/guardarreceptor',[App\Http\Controllers\ReceptorController::class, 'storeRe'])->name('storeRe');
Route::put('/modificarreceptor',[App\Http\Controllers\ReceptorController::class, 'modificar_receptor'])->name('modificar_receptor');
Route::post('/eliminarreceptor',[App\Http\Controllers\ReceptorController::class, 'eliminar_receptor'])->name('eliminar_receptor');
Route::post('/buscareceptor/{id}', [App\Http\Controllers\ReceptorController::class, 'obtenerReceptor'])->name('buscareceptor');

Route::get('/documentos',[App\Http\Controllers\documentosController::class, 'index'])->name('documento');
Route::get('/filtrarDocs',[App\Http\Controllers\documentosController::class, 'filtrarDoc'])->name('filtrarDocs');
Route::get('/obtenerpdf/{codGeneracion}',[App\Http\Controllers\documentosController::class, 'obtenerPdf'])->name('obtenerpdf');
Route::get('/verJson/{codGeneracion}', [App\Http\Controllers\DocumentosController::class, 'verJson'])->name('verJson');



Route::get('/obtenerJsonGuardado/{codGeneracion}',[App\Http\Controllers\documentosController::class, 'obtenerJsonGuardado'])->name('obtenerJsonGuardado');
Route::get('/obtenerJsonGuardadoC/{sello}',[App\Http\Controllers\documentosController::class, 'obtenerJsonGuardadoC'])->name('obtenerJsonGuardadoC');
Route::get('/obtenerdoc',[App\Http\Controllers\documentosController::class, 'obtenerDocumento'])->name('obtenerdoc');

// Mandar el email
Route::get('/mandarComprobantes/{codGeneracion}', [App\Http\Controllers\DocumentosController::class, 'enviarCorreoConDocumentos'])->name('mandarComprobantes');



Route::get('/eInvalidacion',[App\Http\Controllers\EventosController::class, 'listaEInvalidacion'])->name('eInvalidacion');
Route::get('/eContingencia',[App\Http\Controllers\EventosController::class, 'listaEContingencia'])->name('eContingencia');
Route::get('/nuevoEContingencia',[App\Http\Controllers\EventosController::class, 'nuevoEContingencia'])->name('nuevoEContingencia');
Route::get('/lotesContingencia',[App\Http\Controllers\eventosController::class, 'nuevoEContingenciaLotes'])->name('lotesContingencia');
Route::post('/generarContingencia',[App\Http\Controllers\eventosController::class, 'eventoContingencia'])->name('generarContingencia');

Route::get('/facturacion',[App\Http\Controllers\FacturaController::class, 'registro'])->name('factura');
Route::get('/reenviar',[App\Http\Controllers\facturaController::class, 'registro'])->name('reenviar');
Route::post('/docContingencia',[App\Http\Controllers\FacturaController::class, 'docContingencia'])->name('docContingencia');



Route::get('/facturacion',[App\Http\Controllers\FacturaController::class, 'registro'])->name('factura');

Route::get('/registro', function () {
    return view('registro');
})->name('registro');

// Route::post('createusuario', [App\Http\Controllers\loginController::class,'registro'])->name('createusuario');
// Route::get('login', [App\Http\Controllers\loginController::class,'iniciar'])->name('login');
// Route::get('hoja', [App\Http\Controllers\loginController::class,'pruebas'])->name('hoja');

