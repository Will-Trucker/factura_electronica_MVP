<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Revolution\Google\Sheets\Facades\Sheets;
use Luecano\NumeroALetras\NumeroALetras;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use Mockery\Undefined;

use function PHPUnit\Framework\returnSelf;

class FacturaController extends Controller
{
    public function registro(){
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


        $emisores = $this->obtenerEmisores();
        $receptores = $this->obtenerReceptores();
       
        return view('facturacion',compact('emisores','departments','receptores'));
    }
    
    function obtenerEmisores(){
        $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('2. Emisores')->get();
        $header = $sheet->pull(0);
        $values = Sheets::collection($header, $sheet);
        $emisores = $values->toArray();
  
        return $emisores;
    }

    function obtenerReceptores(){
        $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('3. Receptores')->get();

        $header = $sheet->pull(0);
        $values = Sheets::collection($header, $sheet);
        $receptores = $values->toArray();
  
          return $receptores;
    }

}
