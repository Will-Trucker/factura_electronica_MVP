<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emisor;
use App\Models\Receptor;

class FacturaController extends Controller
{
    public function registro()
    {
        $emisores = Emisor::all(); // Obtiene todos los emisores de la base de datos
        $receptores = Receptor::all(); // Obtiene todos los receptores de la base de datos
        return view('facturacion', compact('emisores', 'receptores'));
    }



}
