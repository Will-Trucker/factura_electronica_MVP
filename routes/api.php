<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/emisor/{id}',[ApiController::class,'getEmisor']);

Route::get('/login',function(){
    return view('auth.login');
})->name('login');

Route::post('login', [AuthController::class, 'login']); // Acción de login

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware('decrypt.id')->group(function () {
//     Route::get('/emisor/{id}', [ApiController::class, 'getEmisor']);
//     Route::get('/receptor/{id}', [ApiController::class, 'getReceptor']);
// });

Route::get('/receptor/{id}', [ApiController::class, 'getReceptor']);
