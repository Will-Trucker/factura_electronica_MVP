<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Receptor;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class ReceptorController extends Controller
{
    public function index(){
       $departments = Departamento::all()->keyBy('codigoDepartamento');
        $municipios = Municipio::all();
        $receptores = Receptor::all();


        return view('receptor.index',compact('departments','municipios','receptores'));
    }

    public function storeRe(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'ndocumento' => 'required|numeric',
            'nrc' => 'required|numeric',
            'departamento' => 'required',
            'municipio' => 'required',
            'complemento' => 'required|string',
            'telefono' => 'required',
            'correo' => 'required|email'
        ],[
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.alpa' => 'El Nombre solo puede contener letras',
            'ndocumento.required' => 'La Actvidad es obligatorio.',
            'ndocumento.numeric' => 'La Actividad solo puede contener numeros',
            'nrc.required' => 'El NRC es obligatorio',
            'nrc.numeric' => 'El NRC solo puede contener números',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'complemento.required' => 'El complementos es requerido',
            'complemento.alpa' => 'El complemento solo puede contener texto',
            'telefono.required' => 'El telefono es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'correo.email' => 'El correo electrónico debe tener un formato válido'
        ]);

        $receptores = new Receptor([
            'Nombre' => $request->nombre,
            'NumDocumento' => $request->ndocumento,
            'NRC' => $request->nrc,
            'idDepartamento' => $request->departamento,
            'idMunicipio' => $request->municipio,
            'Complemento' => $request->complemento,
            'Telefono' => $request->telefono,
            'Correo' => $request->correo
        ]);


        $receptores->save();

        return redirect()->route('receptor')->with('success','Receptor Registrado Exitosamente');
    }

    public function modificar_receptor(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'ndocumento' => 'required|numeric',
            'nrc' => 'required|numeric',
            'departamento' => 'required',
            'municipio' => 'required',
            'complemento' => 'required|string',
            'telefono' => 'required',
            'correo' => 'required|email'
        ],[
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.alpa' => 'El Nombre solo puede contener letras',
            'ndocumento.required' => 'La Actvidad es obligatorio.',
            'ndocumento.numeric' => 'La Actividad solo puede contener numeros',
            'nrc.required' => 'El NRC es obligatorio',
            'nrc.numeric' => 'El NRC solo puede contener números',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'complemento.required' => 'El complementos es requerido',
            'telefono.required' => 'El telefono es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'correo.email' => 'El correo electrónico debe tener un formato válido'
        ]);

        $id = $request->idreceptor;

        $receptores= Receptor::find($id);

        if(!$receptores){
            return redirect()->route('receptor')->with('error','Receptor no Encontrado');
        }

        $receptores->update([
            'Nombre' => $request->nombre,
            'NumDocumento' => $request->ndocumento,
            'NRC' => $request->nrc,
            'idDepartamento' => $request->departamento,
            'idMunicipio' => $request->municipio,
            'Complemento' => $request->complemento,
            'Telefono' => $request->telefono,
            'Correo' => $request->correo
        ]);
        return redirect()->route('receptor')->with('success', 'Emisor Modificado Exitosamente');
    }

    public function eliminar_receptor(Request $request)
    {
        $idreceptor = $request->input('idreceptor');

        $receptores = Receptor::find($idreceptor);

        if (!$receptores) {
            return redirect()->back()->with('error', 'Receptor No Encontrado');
        }

        $receptores->delete();

        return redirect()->back()->with('success', 'Receptor Eliminado Exitosamente');
    }

    public function obtenerReceptor($id)
{
    $receptor = Receptor::with('departamento', 'municipio')->find($id);

    if ($receptor) {
        $data = [
            'Nombre' => $receptor->Nombre,
            'NumDocumento' => $receptor->NumDocumento,
            'NRC' => $receptor->NRC,
            'Departamento' => $receptor->departamento->nombreDepartamento,
            'idMunicipio' => $receptor->municipio->nombreMunicipio,
            'Complemento' => $receptor->Complemento,
        ];
        return response()->json($data);
    }

    return response()->json(['error' => 'Receptor no encontrado'], 404);
}


}
