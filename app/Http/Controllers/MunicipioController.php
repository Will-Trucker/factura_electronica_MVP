<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;
class MunicipioController extends Controller
{
    public function getMunicipios($idDepartamento)
    {
        $municipios = Municipio::where('idDepartamento', $idDepartamento)->get();
        return response()->json($municipios);
    }
}
