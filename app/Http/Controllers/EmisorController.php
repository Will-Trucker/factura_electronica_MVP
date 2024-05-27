<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class EmisorController extends Controller
{

    public function index(){

        // Obtener el array de los departamentos
        $departSheet = Sheets::spreadsheet(env('SHEETID'))->sheet('Departamento')->get();
        $departmentsData = array_slice($departSheet->toArray(), 1);
        
        $departments = [];
        foreach ($departmentsData as $rowD) {
            $departments[] = [
                'Id' => $rowD[0],
                'Nombre' => $rowD[1]
            ];
        }

        // Mostrar Emisores Registrados
        $emSheet = Sheets::spreadsheet(env('SHEETID'))->sheet('2. Emisores')->get();
        $emData = array_slice($emSheet->toArray(),1);
        $emisores = [];
        foreach($emData as $rowE){
            $emisores[] = [
                'Id' => $rowE[0],
                'Nombre' => $rowE[1],
                'Nombre Comercial' => $rowE[2],
                'Actividad Economica' => $rowE[3],
                'NIT' => $rowE[4],
                'NRC' => $rowE[5],
                'Departamento' => $rowE[6],
                'Municipio' => $rowE[7],
                'Complemento' => $rowE[8],
                'Telefono' => $rowE[9],
                'Correo' => $rowE[10]
            ];
        }



        return view('emisor',compact('departments','emisores'));
    }

    public function storeEm(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'nombrecomercial' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'actividad' => 'required|string|regex:/^[\pL\s\-]+$/u',
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
            'actividad.alpa' => 'La Actividad solo puede contener letras',
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
            'corre.email' => 'El correo electrónico debe tener un formato válido'
        ]);
        $lastId = Session::get('lastEmisorId', 0);

        // Incrementar el ID
        $id = ++$lastId;

        // Guardar el nuevo ID en la sesión
        Session::put('lastEmisorId', $id);


        // Arreglo para insertar
        $datos = array(
            'Id'=>$id,
            'Nombre'=>$request->nombre,
            'Nombre Comercial'=>$request->nombrecomercial,
            'Actividad Economica'=>$request->actividad,
            'NIT'=>$request->nit,
            'NRC'=>$request->NRC,
            'Departamento'=>$request->departamento,
            'Municipio'=>$request->municipio,
            'Complemento'=>$request->complemento,
            'Telefono'=>$request->telefono,
            'Correo'=>$request->correo,
        );

        Sheets::spreadsheet(env('SHEETID'))->sheet('2. Emisores')->append([$datos]);


        return redirect()->route('emisores')->with('success','Emisor Registrado Exitosamente');

    }
}
