<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Revolution\Google\Sheets\Facades\Sheets;
if (! function_exists('algo')) {
    function algo()
    {//esquema
        return "Hola Mundo!";
    }
}
if (! function_exists('buscar_algo')) {
    function buscar($hoja, $campo, $busqueda)
    {
        //$busqueda = "FE";
        //$campo = 'tipodte';
        //$hoja = 'numerosdecontrol';
        $sheet = Sheets::spreadsheet('1AahrJPHHBgl0sqdxihCaRgRDt9Q3_numT4VndLDvUos')->sheet($hoja)->get();
        
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
    }
}

if (! function_exists('insertar')) {
    function insertar($tabla, $datos)
    {

        Sheets::spreadsheet('1AahrJPHHBgl0sqdxihCaRgRDt9Q3_numT4VndLDvUos')->sheet($tabla)->append([$datos]);
        $count = count($datos);
        return "Se insertaron $count datos";
    }
}

if (! function_exists('modificar')) {
    function modificar($tabla, $datos, $key)
    {//data tiene que ser solo valores en el orden correcto de los campos

        $rango=buscar_id($tabla, $key);
        Sheets::spreadsheet('1AahrJPHHBgl0sqdxihCaRgRDt9Q3_numT4VndLDvUos')->range($rango)->sheet($tabla)->update([$datos]);
        
    }
}

if (!function_exists('buscar_id')){
    function buscar_id($tabla, $id){
        
        $sheet = Sheets::spreadsheet('1AahrJPHHBgl0sqdxihCaRgRDt9Q3_numT4VndLDvUos')->sheet($tabla)->get();

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
/*
if (!function_exists('googleClient')){
    function googleClient(){
        // configure the Google Client
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        // credentials.json is the key file we downloaded while setting up our Google Sheets API
        $path = storage_path('credentials.json');
        $client->setAuthConfig($path);

        // configure the Sheets Service
        $service = new \Google_Service_Sheets($client);
        // get all the rows of a sheet
        $spreadsheetId = '1AahrJPHHBgl0sqdxihCaRgRDt9Q3_numT4VndLDvUos';
        $range = 'otro'; // here we use the name of the Sheet to get all the rows
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        dd($values);
        }
}*/