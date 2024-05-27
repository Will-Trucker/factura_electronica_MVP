<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Revolution\Google\Sheets\Facades\Sheets;

class TokenController extends Controller
{
    public function index(){

    //     $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('1. Tokens')->get();

    //     $header = $sheet->pull(0);
    //     $values = Sheets::collection($header, $sheet);
    //     $values->toArray();
    

    // $tokens = json_decode($values, true);

    

    // $ultimo = end($tokens);
    
    // return view('token', compact('tokens', 'ultimo'));     
    
    $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet('1. Tokens')->get();

    $header = $sheet->pull(0);
    $values = Sheets::collection($header, $sheet);
    $tokens = $values->toArray();

    $ultimo = end($tokens);

    // Chekar si $ultimo es un arreglo antes de pasarlo a la vista
    if (!$ultimo || !is_array($ultimo)) {
        $ultimo = [];
    }
    
    return view('token', compact('tokens', 'ultimo'));
    }

    public function guardartoken(Request $request){
        $datos = array(
            'Fecha'=>date('d-m-Y'),
            'Token'=>$this->generartoken($request->nit, $request->clave),
            
        );

        Sheets::spreadsheet(env('SHEETID'))->sheet('1. Tokens')->append([$datos]);
    
        return redirect()->route('tokens')->with('success','Token Creado con Éxito');
    }

    function generartoken($usuario, $clave){
        // Credenciales del MH
        $user = $usuario;
        $pwd = $clave;

        $apiUrl = "https://apitest.dtes.mh.gob.sv/seguridad/auth?user=".$user."&pwd=".$pwd;
 
        $response = Http::post($apiUrl);
        $token = json_decode($response)->body->token;
        return ($token);
    }
}