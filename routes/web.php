<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [AuthController::class, 'dashboard'])
->name('dashboard')
->middleware('auth.jwt');

    Route::get('/registros', function () {
        return view('registros');
    })->name('registros')->middleware('auth.jwt');

    // Ruta de Municipios
    Route::get('/municipios/{idDepartamento}', [App\Http\Controllers\MunicipioController::class, 'getMunicipios'])->name('municipios');

    // PDF
    Route::get('/get-PDF/{codGeneracion}', [App\Http\Controllers\DocumentosController::class, 'generarDTE'])->name('getPDF')->middleware('auth.jwt');

    // DTE'S
    Route::post('/guardarFactura',[App\Http\Controllers\facturaController::class, 'guardarFactura'])->name('guardarFactura')->middleware('auth.jwt');

    // Tokens MH (Ministerio de Hacienda)
    Route::get('/tok',[App\Http\Controllers\FacturaController::class, 'lastToken'])->name('tok') ->middleware('auth.jwt');
    Route::get('/tokens',[App\Http\Controllers\TokenController::class, 'index'])->name('token')  ->middleware('auth.jwt');
    Route::post('/guardartoken',[App\Http\Controllers\TokenController::class, 'guardartoken'])->name('guardartoken')->middleware('auth.jwt');

    // Crud de Emisor
    Route::get('/emisor',[App\Http\Controllers\EmisorController::class, 'index'])->name('emisor')->middleware('auth.jwt');
    Route::post('/guardaremisor',[App\Http\Controllers\EmisorController::class, 'storeEm'])->name('storeEm')->middleware('auth.jwt');
    Route::put('/modificaremisor',[App\Http\Controllers\EmisorController::class, 'modificar_emisor'])->name('modificar_emisor')->middleware('auth.jwt');
    Route::post('/eliminaremisor',[App\Http\Controllers\EmisorController::class, 'eliminar_emisor'])->name('eliminar_emisor')->middleware('auth.jwt');

    // Ruta de Crud Receptor
    Route::get('/receptor',[App\Http\Controllers\ReceptorController::class, 'index'])->name('receptor')  ->middleware('auth.jwt');
    Route::post('/guardarreceptor',[App\Http\Controllers\ReceptorController::class, 'storeRe'])->name('storeRe')  ->middleware('auth.jwt');
    Route::put('/modificarreceptor',[App\Http\Controllers\ReceptorController::class, 'modificar_receptor'])->name('modificar_receptor')  ->middleware('auth.jwt');
    Route::post('/eliminarreceptor',[App\Http\Controllers\ReceptorController::class, 'eliminar_receptor'])->name('eliminar_receptor')  ->middleware('auth.jwt');
    Route::post('/buscareceptor/{id}', [App\Http\Controllers\ReceptorController::class, 'obtenerReceptor'])->name('buscareceptor')  ->middleware('auth.jwt');

    // Historial de DTE
    Route::get('/documentos',[App\Http\Controllers\DocumentosController::class, 'index'])->name('documento')->middleware('auth.jwt');
    Route::get('/filtrarDocs',[App\Http\Controllers\DocumentosController::class, 'filtrarDoc'])->name('filtrarDocs')->middleware('auth.jwt');
    Route::get('/obtenerpdf/{codGeneracion}',[App\Http\Controllers\DocumentosController::class, 'obtenerPdf'])->name('obtenerpdf')->middleware('auth.jwt');
    Route::get('/verJson/{codGeneracion}', [App\Http\Controllers\DocumentosController::class, 'verJson'])->name('verJson')->middleware('auth.jwt');
    Route::get('/obtenerJsonGuardado/{codGeneracion}',[App\Http\Controllers\DocumentosController::class, 'obtenerJsonGuardado'])->name('obtenerJsonGuardado')  ->middleware('auth.jwt');

    // Contingencia
    Route::get('/obtenerJsonGuardadoC/{sello}',[App\Http\Controllers\DocumentosController::class, 'obtenerJsonGuardadoC'])->name('obtenerJsonGuardadoC')  ->middleware('auth.jwt');

    Route::get('/obtenerdoc',[App\Http\Controllers\DocumentosController::class, 'obtenerDocumento'])->name('obtenerdoc')->middleware('auth.jwt');

    // Mandar el email
    Route::get('/mandarComprobantes/{codGeneracion}', [App\Http\Controllers\DocumentosController::class, 'enviarCorreoConDocumentos'])->name('mandarComprobantes')->middleware('auth.jwt');


    // Eventos Contingencia y Invalidacion
    Route::get('/eInvalidacion',[App\Http\Controllers\EventosInvalidacionController::class, 'listaEInvalidacion'])->name('eInvalidacion')->middleware('auth.jwt');
    Route::get('/eContingencia',[App\Http\Controllers\EventosController::class, 'listaEContingencia'])->name('eContingencia')->middleware('auth.jwt');
    Route::get('/nuevoEContingencia',[App\Http\Controllers\EventosController::class, 'nuevoEContingencia'])->name('nuevoEContingencia')->middleware('auth.jwt');
    Route::get('/lotesContingencia',[App\Http\Controllers\EventosController::class, 'nuevoEContingenciaLotes'])->name('lotesContingencia')->middleware('auth.jwt');
    Route::post('/generarContingencia',[App\Http\Controllers\EventosController::class, 'eventoContingencia'])->name('generarContingencia')->middleware('auth.jwt');
    Route::get('/nuevoEInvalidacion',[App\Http\Controllers\EventosInvalidacionController::class, 'nuevoEInvalidacion'])->name('nuevoEInvalidacion')->middleware('auth.jwt');
    Route::post('/generarInvalidacion',[App\Http\Controllers\EventosInvalidacionController::class,'eventoInvalidacion'])->name('generarInvalidacion')->middleware('auth.jwt');


    Route::get('/facturacion',[App\Http\Controllers\FacturaController::class, 'registro'])->name('factura')->middleware('auth.jwt');
    Route::get('/reenviar',[App\Http\Controllers\FacturaController::class, 'registro'])->name('reenviar')->middleware('auth.jwt');
    Route::post('/docContingencia',[App\Http\Controllers\FacturaController::class, 'docContingencia'])->name('docContingencia')->middleware('auth.jwt');
