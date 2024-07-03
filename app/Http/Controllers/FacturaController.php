<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emisor;
use App\Models\Receptor;

class FacturaController extends Controller
{
    public function registro()
    {
        // ... 
        $emisores = Emisor::all(); // Obtiene todos los emisores de la base de datos
        $receptores = Receptor::all();
        return view('facturacion', compact('emisores', 'receptores'));
    }

    public function obtenerEmisor($id) {
        $emisor = Emisor::find($id);
    
        if (!$emisor) {
            return response()->json(['message' => 'Emisor no encontrado'], 404);
        }
    
        return response()->json($emisor);
    }
    
}
