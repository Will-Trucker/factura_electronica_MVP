<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\ActividadEconomica;
use App\Models\TipoDocumento;
use App\Models\Receptor;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class ReceptorController extends Controller
{
    public function index(){
                // // Obtener el array de los departamentos
                // $departSheet = Sheets::spreadsheet(env('SHEETID'))->sheet('Departamento')->get();
                // $departmentsData = array_slice($departSheet->toArray(), 1);

                // $departments = [];
                // foreach ($departmentsData as $rowD) {
                //     $departments[] = [
                //         'Id' => $rowD[0],
                //         'Nombre' => $rowD[1]
                //     ];
                // }

                // $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores')->get();

                // $header = $sheet->pull(0);
                // $values = Sheets::collection($header, $sheet);
                // $receptores = $values->toArray();

                $departments = Departamento::all();
                $municipios = Municipio::all();
                $actividades = ActividadEconomica::all();
                $tipos = TipoDocumento::all();
                $receptores = Receptor::all();


        return view('receptor',compact('departments','municipios','actividades','tipos','receptores'));
    }

    public function storeRe(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'tipodocumento' => 'required',
            'ndocumento' => 'required|numeric',
            'nit' => 'required|numeric',
            'nrc' => 'required|numeric',
            'departamento' => 'required',
            'municipio' => 'required',
            'complemento' => 'required|string',
            'actividadecono' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email'
        ],[
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.alpa' => 'El Nombre solo puede contener letras',
            'tipodocumento.required' => 'El Nombre Comercial es obligatorio.',
            'ndocumento.required' => 'La Actvidad es obligatorio.',
            'ndocumento.numero' => 'La Actividad solo puede contener numeros',
            'nit.required' => 'El NIT es obligatorio',
            'nit.numeric' => 'El NIT solo puede contener números',
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
            'correo.email' => 'El correo electrónico debe tener un formato válido'
        ]);
        // $lastId = Session::get('lastReceptorId', 0);

        // // Incrementar el ID
        // $id = ++$lastId;

        // // Guardar el nuevo ID en la sesión
        // Session::put('lastReceptorId', $id);


        // // Arreglo para insertar
        // $datos = array(
        //     'Id'=>$id,
        //     'Nombre'=>$request->nombre,
        //     'Tipo Documento'=>$request->tipodocumento,
        //     'Num Documento'=>$request->ndocumento,
        //     'NRC'=>$request->nrc,
        //     'Departamento'=>$request->departamento,
        //     'Municipio'=>$request->municipio,
        //     'Complemento'=>$request->complemento,
        //     'Actividad Economica'=>$request->actividadecono,
        //     'Telefono'=>$request->telefono,
        //     'Correo'=>$request->correo,
        // );

        // Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores')->append([$datos]);

        $receptores = new Receptor([
            'Nombre' => $request->nombre,
            'TipoDocumento' => $request->tipodocumento,
            'NumDocumento' => $request->ndocumento,
            'NIT' => $request->nit,
            'NRC' => $request->nrc,
            'idDepartamento' => $request->departamento,
            'idMunicipio' => $request->municipio,
            'Complemento' => $request->complemento,
            'idActividadEconomica' => $request->actividadecono,
            'Telefono' => $request->telefono,
            'Correo' => $request->correo
        ]);


        $receptores->save();

        return redirect()->route('receptores')->with('success','Receptor Registrado Exitosamente');
    }

    public function modificar_receptor(Request $request){
        $request->validate([
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'tipodocumento' => 'required',
            'ndocumento' => 'required|numeric',
            'nit' => 'required|numeric',
            'nrc' => 'required|numeric',
            'departamento' => 'required',
            'municipio' => 'required',
            'complemento' => 'required|string',
            'actividadecono' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email'
        ],[
            'nombre.required' => 'El Nombre es obligatorio.',
            'nombre.alpa' => 'El Nombre solo puede contener letras',
            'tipodocumento.required' => 'El Nombre Comercial es obligatorio.',
            'ndocumento.required' => 'La Actvidad es obligatorio.',
            'ndocumento.numero' => 'La Actividad solo puede contener numeros',
            'nit.required' => 'El NIT es obligatorio',
            'nit.numeric' => 'El NIT solo puede contener números',
            'nrc.required' => 'El NRC es obligatorio',
            'nrc.numeric' => 'El NRC solo puede contener números',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'complemento.required' => 'El complementos es requerido',
            'actividadecono.required' => 'La Actividad Economica es requerido',
            'telefono.required' => 'El telefono es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'correo.email' => 'El correo electrónico debe tener un formato válido'
        ]);

        $id = $request->idreceptor;

        $receptores= Receptor::find($id);

        if(!$receptores){
            return redirect()->route('receptores')->with('error','Receptor no Encontrado');
        }

        $receptores->update([
            'Nombre' => $request->nombre,
            'TipoDocumento' => $request->tipodocumento,
            'NumDocumento' => $request->ndocumento,
            'NIT' => $request->nit,
            'NRC' => $request->nrc,
            'idDepartamento' => $request->departamento,
            'idMunicipio' => $request->municipio,
            'Complemento' => $request->complemento,
            'idActividadEconomica' => $request->actividadecono,
            'Telefono' => $request->telefono,
            'Correo' => $request->correo
        ]);

        // $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores');
        // $reData = $sheet->get()->toArray();

        // // Find the row with the given ID
        // foreach ($reData as $index => $row) {
        //     if ($row[0] == $id) {
        //         // Update the row data
        //         $reData[$index] = [
        //             $id,
        //             $request->nombre,
        //             $request->tipodocumento,
        //             $request->ndocumento,
        //             $request->nrc,
        //             $request->departamento,
        //             $request->municipio,
        //             $request->complemento,
        //             $request->actividadecono,
        //             $request->telefono,
        //             $request->correo
        //         ];
        //         break;
        //     }
       // }

        // Save the updated data back to the sheet
        //Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores')->range('A1')->update($reData);

        return redirect()->route('receptores')->with('success', 'Emisor Modificado Exitosamente');
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
    

    public function obetenerReceptor($id){
        $respuesta = buscar('3. Receptores','Nombre', $id);

        return $respuesta;
    }


}
