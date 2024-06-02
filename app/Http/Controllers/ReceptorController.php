<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class ReceptorController extends Controller
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
        
                $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores')->get();

                $header = $sheet->pull(0);
                $values = Sheets::collection($header, $sheet);
                $receptores = $values->toArray();
        
        return view('receptor',compact('departments','receptores'));
    }

    public function storeRe(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'tipodocumento' => 'required',
            'ndocumento' => 'required|numeric',
            'nrc' => 'required|numeric',
            'departamento' => 'required|numeric',
            'municipio' => 'required',
            'complemento' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'actividadecono' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'telefono' => 'required',
            'correo' => 'required|email'
        ],[
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.alpa' => 'El Nombre solo puede contener letras',
            'tipodocumento.required' => 'El Nombre Comercial es obligatorio.',
            'ndocumento.required' => 'La Actvidad es obligatorio.',
            'ndocumento.numero' => 'La Actividad solo puede contener numeros',
            'nrc.required' => 'El NRC es obligatorio',
            'nrc.numeric' => 'El NRC solo puede contener números',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'complemento.required' => 'El complementos es requerido',
            'complemento.alpa' => 'El complemento solo puede contener texto',
            'actividadecono' => 'La Actividad Economica es requerido',
            'actividadecono.alpa' => 'La Actividad Economica solo puede contener letras',
            'telefono.required' => 'El telefono es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'corre.email' => 'El correo electrónico debe tener un formato válido'
        ]);
        $lastId = Session::get('lastReceptorId', 0);

        // Incrementar el ID
        $id = ++$lastId;

        // Guardar el nuevo ID en la sesión
        Session::put('lastReceptorId', $id);


        // Arreglo para insertar
        $datos = array(
            'Id'=>$id,
            'Nombre'=>$request->nombre,
            'Tipo Documento'=>$request->tipodocumento,
            'Num Documento'=>$request->ndocumento,
            'NRC'=>$request->nrc,
            'Departamento'=>$request->departamento,
            'Municipio'=>$request->municipio,
            'Complemento'=>$request->complemento,
            'Actividad Economica'=>$request->actividadecono,
            'Telefono'=>$request->telefono,
            'Correo'=>$request->correo,
        );

        Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores')->append([$datos]);


        return redirect()->route('receptores')->with('success','Receptor Registrado Exitosamente');

    }

    public function modificar_receptor(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'tipodocumento' => 'required',
            'ndocumento' => 'required|numeric',
            'nrc' => 'required|numeric',
            'departamento' => 'required|numeric',
            'municipio' => 'required',
            'complemento' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'actividadecono' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'telefono' => 'required',
            'correo' => 'required|email'
        ],[
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.alpa' => 'El Nombre solo puede contener letras',
            'tipodocumento.required' => 'El Nombre Comercial es obligatorio.',
            'ndocumento.required' => 'La Actvidad es obligatorio.',
            'ndocumento.numero' => 'La Actividad solo puede contener numeros',
            'nrc.required' => 'El NRC es obligatorio',
            'nrc.numeric' => 'El NRC solo puede contener números',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'complemento.required' => 'El complementos es requerido',
            'complemento.alpa' => 'El complemento solo puede contener texto',
            'actividadecono' => 'La Actividad Economica es requerido',
            'actividadecono.alpa' => 'La Actividad Economica solo puede contener letras',
            'telefono.required' => 'El telefono es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'corre.email' => 'El correo electrónico debe tener un formato válido'
        ]);
    
        $id = $request->idreceptor;
    
        $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores');
        $reData = $sheet->get()->toArray();
    
        // Find the row with the given ID
        foreach ($reData as $index => $row) {
            if ($row[0] == $id) {
                // Update the row data
                $reData[$index] = [
                    $id,
                    $request->nombre,
                    $request->tipodocumento,
                    $request->ndocumento,
                    $request->nrc,
                    $request->departamento,
                    $request->municipio,
                    $request->complemento,
                    $request->actividadecono,
                    $request->telefono,
                    $request->correo
                ];
                break;
            }
        }
    
        // Save the updated data back to the sheet
        Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores')->range('A1')->update($reData);
    
        return redirect()->route('receptores')->with('success', 'Emisor Modificado Exitosamente');
    }

    public function obetenerReceptor($id){
        $respuesta = buscar('3. Receptores','Nombre', $id);

        return $respuesta;
    }

    
}
