<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Revolution\Google\Sheets\Facades\Sheets;

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

        return view('emisor',compact('departments'));
    }

    public function storeEm(Request $request){

    }
}
