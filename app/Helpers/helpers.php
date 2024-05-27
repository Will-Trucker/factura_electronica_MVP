<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Response;
use Google\Exception as GoogleException;

if (! function_exists('algo')) {
    function algo()
    {//esquema
        return "Hola Mundo!";
    }
}
if (! function_exists('buscar_algo')) {
    function buscar($hoja, $campo, $busqueda)
    {

        if(verificarConexionInternet()){

            $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet($hoja)->get();
            
            $header = $sheet->pull(0);
            $values = Sheets::collection($header, $sheet);
            $values->toArray();
    
            $resultado = null;
            foreach($values as $value) {
                //echo $value[$campo];
                if($value[$campo]==$busqueda){
                    $resultado = $value;
                }
            }
    
            return $resultado;
        } else{
            // Manejo de errores cuando no hay conexión a internet
            return null; // O puedes lanzar una excepción personalizada, loguear el error, etc.
        }
    }
}

if (! function_exists('buscar_algo')) {
    function filtrar($hoja, $campo, $busqueda)
    {

        if(verificarConexionInternet()){

            $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet($hoja)->get();
            
            $header = $sheet->pull(0);
            $values = Sheets::collection($header, $sheet);
            $values->toArray();
    
            $resultado = [];
            foreach($values as $value) {
                //echo $value[$campo];
                if($value[$campo]==$busqueda){
                    array_push($resultado, $value);
                }
            }
    
            return $resultado;
        } else{
            // Manejo de errores cuando no hay conexión a internet
            return null; // O puedes lanzar una excepción personalizada, loguear el error, etc.
        }
    }
}


if(! function_exists('verificarConexionInternet')){
    function verificarConexionInternet()
    {
        $url = 'http://www.google.com';
        $headers = @get_headers($url);

        if ($headers && strpos($headers[0], '200')) {
            // Hay conexión a Internet
            return true;
        } else {
            // No hay conexión a Internet
            return false;
        }
    }
}

if (! function_exists('insertar')) {
    function insertar($tabla, $datos)
    {

        Sheets::spreadsheet(env('SHEETID'))->sheet($tabla)->append([$datos]);
        $count = count($datos);
        return "Se insertaron $count datos";
    }
}

if (! function_exists('modificar')) {
    function modificar($tabla, $datos, $key)
    {//data tiene que ser solo valores en el orden correcto de los campos

        $rango=buscar_id($tabla, $key);
        Sheets::spreadsheet(env('SHEETID'))->range($rango)->sheet($tabla)->update([$datos]);
        
    }
}

if (!function_exists('buscar_id')){
    function buscar_id($tabla, $id){
        
        $sheet = Sheets::spreadsheet(env('SHEETID'))->sheet($tabla)->get();

        $header = $sheet->pull(0);
        $values = Sheets::collection($header, $sheet);
        $values->toArray();
        $posicion = 1;
        $respuesta = 0;
        foreach ($values as $value) {
            $posicion++;
            if($value['id'] == $id){
                $respuesta  = "B".$posicion;
            }
        }
        return $respuesta;

    }
}

if (!function_exists('ultimoToken')){
    function ultimoToken(){
        if(verificarConexionInternet()){
            $sheet = Sheets::spreadsheet(env('SHEETID'))
            ->sheet('1. Tokens')
            ->get();
    
            $header = $sheet->pull(0);
            $values = Sheets::collection($header, $sheet);
            $values->toArray();
            $respuesta = ($values[$values->count()]);
            
            return $respuesta['token'];

        }else{
            return 0;
        }
    }
}

if (!function_exists('ultimoID')){
    function ultimoID($tabla){
        $sheet = Sheets::spreadsheet(env('SHEETID'))
        ->sheet($tabla)
        ->get();

        $header = $sheet->pull(0);
        $values = Sheets::collection($header, $sheet);
        $values->toArray();
        $respuesta = ($values[$values->count()]);
        
        return $respuesta['id'];
    }
}
if (!function_exists('bajarDoc')){
    function bajarDoc(){
        $esquema = session()->get('descargarjson');
        $doc = json_decode($esquema);
        $filename = $doc->identificacion->codigoGeneracion.'.json';
        $headers = [
          'Content-Type'=> 'application/json',
          'Content-Disposition'=> 'attachment; filename="' . $filename . '"',
          
        ];
          // Crear la respuesta de descarga del archivo
        return Response::make($esquema, 200, $headers);
    }
}


if(!function_exists('obtenerCorreo')){
    function obtenerCorreo($codGeneracion){
        
        if(verificarConexionInternet()){

            $documento = json_decode(buscar('4. Documentos', 'codigoGeneracion', $codGeneracion));
            $documento = json_decode($documento->esquema);
            
            $resultado = $documento->receptor->correo;
    
            return $resultado;
        } else{
            // Manejo de errores cuando no hay conexión a internet
            return null; // O puedes lanzar una excepción personalizada, loguear el error, etc.
        }
    }
}

if(!function_exists('obtenerDetalles')){
    function obtenerDetalles($codGeneracion){
        
        if(verificarConexionInternet()){

            $documento = json_decode(buscar('4. Documentos', 'codigoGeneracion', $codGeneracion));
            $documento = json_decode($documento->esquema);
            
            $resultado = $documento->cuerpoDocumento;
    
            return $resultado;
        } else{
            // Manejo de errores cuando no hay conexión a internet
            return null; // O puedes lanzar una excepción personalizada, loguear el error, etc.
        }
    }
}
