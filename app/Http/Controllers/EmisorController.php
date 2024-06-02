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

       
        $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('2. Emisores')->get();

        $header = $sheet->pull(0);
        $values = Sheets::collection($header, $sheet);
        $emisores = $values->toArray();



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

    public function modificar_emisor(Request $request){
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
        ]);
    
        $id = $request->idemisor;
    
        $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('2. Emisores');
        $emData = $sheet->get()->toArray();
    
        // Find the row with the given ID
        foreach ($emData as $index => $row) {
            if ($row[0] == $id) {
                // Update the row data
                $emData[$index] = [
                    $id,
                    $request->nombre,
                    $request->nombrecomercial,
                    $request->actividad,
                    $request->nit,
                    $request->NRC,
                    $request->departamento,
                    $request->municipio,
                    $request->complemento,
                    $request->telefono,
                    $request->correo
                ];
                break;
            }
        }
    
        // Save the updated data back to the sheet
        Sheets::spreadsheet(env('SHEETID'))->sheet('2. Emisores')->range('A1')->update($emData);
    
        return redirect()->route('emisores')->with('success', 'Emisor Modificado Exitosamente');
    }

    public function eliminar_emisor(Request $request)
    {
        $idemisor = $request->input('idemisor');
        
        // Obtener los datos actuales de la hoja
        $values = Sheets::spreadsheet(env('SHEETID'))
                        ->sheet('2. Emisores')
                        ->all();
        
        // Encontrar la fila que coincide con el id del emisor
        $rowToDelete = null;
        foreach ($values as $index => $row) {
            if ($row[0] == $idemisor) { // Suponiendo que el ID está en la primera columna
                $rowToDelete = $index + 1; // Las filas en Sheets empiezan en 1
                break;
            }
        }

        // Si se encontró la fila, eliminarla
        if ($rowToDelete) {
            Sheets::spreadsheet(env('SHEETID'))
                    ->sheet('2. Emisores')
                    ->all();
        }

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Emisor eliminado correctamente.');
    }

    public function obtenerEmisor($id){
        $respuesta = buscar('2. Emisores','Nombre', $id);

        return $respuesta;
    }
}
