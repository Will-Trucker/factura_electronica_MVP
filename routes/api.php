<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/emisor/{id}',[ApiController::class,'getEmisor']);
Route::get('/receptor/{id}', [ApiController::class, 'getReceptor']);

// Route::middleware('decrypt.id')->group(function () {
//     Route::get('/emisor/{id}', [ApiController::class, 'getEmisor']);
//     Route::get('/receptor/{id}', [ApiController::class, 'getReceptor']);
// });