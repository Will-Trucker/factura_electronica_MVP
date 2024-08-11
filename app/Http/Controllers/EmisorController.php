<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Str;
use App\Models\Emisor;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\ActividadEconomica;
use Illuminate\Support\Facades\Session;

class EmisorController extends Controller
{

    public function index(){

        $departments = Departamento::all()->keyBy('codigoDepartamento');
        $municipios = Municipio::all();
        $actividades = ActividadEconomica::all()->keyBy('codigoGiro');
       
        $emisores = Emisor::all();
    

        return view('emisor',compact('departments','municipios','actividades','emisores'));
    }

    public function storeEm(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'nombrecomercial' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'actividad' => 'required',
            'NRC' => 'required|numeric',
            'nit' => 'required|numeric',
            'departamento' => 'required',
            'municipio' => 'required',
            'complemento' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email'
        ],[
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.alpa' => 'El Nombre solo puede contener letras',
            'nombrecomercial.required' => 'El Nombre Comercial es obligatorio.',
            'nombrecomercial.alpa' => 'El nombre comercial solo puede contener letras',
            'actividad.required' => 'La Actvidad es obligatorio.',
            'NRC.required' => 'El NRC es obligatorio',
            'NRC.numeric' => 'El NRC solo puede contener números',
            'nit.required' => 'El NIT es obligatorio',
            'nit.numeric' => 'El NIT solo puede contener números',
            'nit' => 'El NIT solo puede contener 14 números',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'complemento.required' => 'El complementos es requerido',
            'telefono.required' => 'El telefono es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'correo.email' => 'El correo electrónico debe tener un formato válido'
        ]);
    
            $emisor = new Emisor([
                            'Nombre'=>$request->nombre,
                            'NombreComercial'=>$request->nombrecomercial,
                            'idActividadEconomica'=>$request->actividad,
                            'NIT'=>$request->nit,
                            'NRC'=>$request->NRC,
                            'idDepartamento'=>$request->departamento,
                            'idMunicipio'=>$request->municipio,
                            'Complemento'=>$request->complemento,
                            'Telefono'=>$request->telefono,
                            'Correo'=>$request->correo,
                    ]);

            
            $emisor->save();
    
        return redirect()->route('emisores')->with('success','Emisor Registrado Exitosamente');
    }

    public function modificar_emisor(Request $request){
       $request->validate([
         'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
         'nombrecomercial' => 'required|string|regex:/^[\pL\s\-]+$/u',
         'actividad' => 'required',
         'NRC' => 'required|numeric',
         'nit' => 'required|numeric',
         'departamento' => 'required',
         'municipio' => 'required',
         'complemento' => 'required',
         'telefono' => 'required',
         'correo' => 'required|email'
     ],[
        'nombre.required' => 'El Nombre es obligatorio.',
        'nombre.alpa' => 'El Nombre solo puede contener letras',
        'nombrecomercial.required' => 'El Nombre Comercial es obligatorio.',
        'nombrecomercial.alpa' => 'El nombre comercial solo puede contener letras',
        'actividad.required' => 'La Actvidad es obligatorio.',
        'NRC.required' => 'El NRC es obligatorio',
        'NRC.numeric' => 'El NRC solo puede contener números',
        'nit.required' => 'El NIT es obligatorio',
        'nit.numeric' => 'El NIT solo puede contener números',
        'nit' => 'El NIT solo puede contener 14 números',
        'departamento.required' => 'El departamento es obligatorio.',
        'municipio.required' => 'El municipio es obligatorio.',
        'complemento.required' => 'El complementos es requerido',
        'telefono.required' => 'El telefono es obligatorio',
        'correo.required' => 'El correo electrónico es obligatorio',
        'correo.email' => 'El correo electrónico debe tener un formato válido'
    ]);
    
    $id = $request->idemisor;
    

    $emisor = Emisor::find($id);


    if(!$emisor){
        return redirect()->route('emisores')->with('error','Emisor no Encontrado');
    }

    

    $emisor->update([
        'Nombre'=>$request->nombre,
        'NombreComercial'=>$request->nombrecomercial,
        'idActividadEconomica'=>$request->actividad,
        'NIT'=>$request->nit,
        'NRC'=>$request->NRC,
        'idDepartamento'=>$request->departamento,
        'idMunicipio'=>$request->municipio,
        'Complemento'=>$request->complemento,
        'Telefono'=>$request->telefono,
        'Correo'=>$request->correo,
    ]);

   
    
     return redirect()->route('emisores')->with('success', 'Emisor Modificado Exitosamente');
    }

    public function eliminar_emisor(Request $request)
    {
        $idemisor = $request->input('idemisor');
        
        $emisor = Emisor::find($idemisor);

        if(!$emisor){
            return redirect()->back()->with('error','Emisor No Encontrado');
        }

        $emisor->delete();

         return redirect()->back()->with('success', 'Emisor eliminado correctamente.');
    }

  
}
