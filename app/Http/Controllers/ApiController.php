<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emisor;
use App\Models\Receptor;

class ApiController extends Controller
{
    public function getEmisor($id)
    {
        $emisor = Emisor::with(['departamento', 'municipio', 'actividades'])->find($id);

        if (!$emisor) {
            return response()->json(['message' => 'Emisor not found'], 404);
        }

        return response()->json($emisor);
    }

    public function getReceptor($id)
    {
        $receptor = Receptor::with(['departamento', 'municipio', 'actividades', 'tipos'])->find($id);

        if (!$receptor) {
            return response()->json(['error' => 'Receptor not found'], 404);
        }

        return response()->json($receptor);
    }


}
