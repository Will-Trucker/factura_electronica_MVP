<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSheetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('sheet',[GoogleSheetController::class,'index']);


